<?php

namespace Database\Seeders;

use Domain\Models\Product;
use Domain\Models\ProductImage;
use Domain\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductSeeder extends Seeder
{
    private bool $storageWarningShown = false;

    public function run(): void
    {
        $faker = Factory::create('pt_BR');

        $users = User::query()->get();

        if ($users->isEmpty()) {
            $users = collect([
                User::query()->create([
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => 'password',
                ]),
            ]);
        }

        foreach ($users as $user) {
            $totalByUser = $faker->numberBetween(3, 8);

            for ($i = 0; $i < $totalByUser; $i++) {
                $product = Product::query()->create([
                    'user_id' => $user->id,
                    'name' => ucfirst($faker->words($faker->numberBetween(2, 4), true)),
                    'description' => $faker->optional(0.85)->sentence($faker->numberBetween(10, 16)),
                    'price' => $faker->randomFloat(2, 19, 3999),
                    'image_path' => null,
                    'image_url' => null,
                ]);

                $totalImages = $faker->numberBetween(1, 4);
                $firstImagePath = null;
                $firstImageUrl = null;

                for ($sortOrder = 0; $sortOrder < $totalImages; $sortOrder++) {
                    $storedImage = $this->storeGeneratedSvgImage($product->name, $sortOrder + 1);

                    if ($storedImage === null) {
                        continue;
                    }

                    [$path, $url] = $storedImage;

                    ProductImage::query()->create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'url' => $url,
                        'sort_order' => $sortOrder,
                    ]);

                    if ($firstImagePath === null) {
                        $firstImagePath = $path;
                        $firstImageUrl = $url;
                    }
                }

                if ($firstImagePath !== null) {
                    $product->update([
                        'image_path' => $firstImagePath,
                        'image_url' => $firstImageUrl,
                    ]);
                }
            }
        }
    }

    /**
     * @return array{0: string, 1: string}|null
     */
    private function storeGeneratedSvgImage(string $productName, int $index): ?array
    {
        $path = 'products/seeders/' . Str::uuid() . '.svg';
        $svg = $this->buildSvg($productName, $index);

        try {
            Storage::disk('s3')->put($path, $svg, [
                'visibility' => 'private',
                'ContentType' => 'image/svg+xml',
            ]);

            return [$path, Storage::disk('s3')->url($path)];
        } catch (Throwable $exception) {
            if (! $this->storageWarningShown && $this->command !== null) {
                $this->command->warn('Nao foi possivel gerar imagens de seed no S3/LocalStack. Produtos foram criados sem imagens.');
                $this->command->warn('Detalhe: ' . $exception->getMessage());
                $this->storageWarningShown = true;
            }

            return null;
        }
    }

    private function buildSvg(string $productName, int $index): string
    {
        $title = trim($productName) !== '' ? Str::limit($productName, 24, '') : 'Produto';
        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $colors = ['#0ea5e9', '#14b8a6', '#f97316', '#22c55e', '#6366f1'];
        $backgroundColor = $colors[($index - 1) % count($colors)];

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="1200" viewBox="0 0 1200 1200" role="img" aria-label="Imagem seed de {$safeTitle}">
  <rect width="1200" height="1200" fill="{$backgroundColor}"/>
  <circle cx="980" cy="220" r="240" fill="rgba(255,255,255,0.2)"/>
  <circle cx="200" cy="980" r="260" fill="rgba(255,255,255,0.14)"/>
  <text x="120" y="640" fill="#ffffff" font-size="84" font-family="Arial, sans-serif" font-weight="700">{$safeTitle}</text>
  <text x="120" y="730" fill="#ffffff" font-size="42" font-family="Arial, sans-serif" opacity="0.9">Imagem seed #{$index}</text>
</svg>
SVG;
    }
}
