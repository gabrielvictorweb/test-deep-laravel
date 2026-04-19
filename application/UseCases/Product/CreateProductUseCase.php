<?php

namespace Application\UseCases\Product;

use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Http\UploadedFile;

class CreateProductUseCase
{
    public function execute(
        array $payload,
        UploadedFile|array|null $images,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
    ): Product {
        $normalizedImages = $this->normalizeImages($images);

        if ($normalizedImages !== []) {
            $firstPath = $imageStorage->upload($normalizedImages[0]);
            $payload['image_path'] = $firstPath;
            $payload['image_url'] = $imageStorage->url($firstPath);
        }

        $product = $productRepository->create($payload);

        if ($product->exists) {
            foreach ($normalizedImages as $index => $image) {
                $path = $index === 0 && isset($firstPath) ? $firstPath : $imageStorage->upload($image);

                $product->images()->create([
                    'path' => $path,
                    'url' => $imageStorage->url($path),
                    'sort_order' => $index,
                ]);
            }

            return $product->refresh();
        }

        return $product;
    }

    /**
     * @return array<int, UploadedFile>
     */
    private function normalizeImages(UploadedFile|array|null $images): array
    {
        if ($images instanceof UploadedFile) {
            return [$images];
        }

        if (! is_array($images)) {
            return [];
        }

        return array_values(array_filter(
            $images,
            static fn ($file): bool => $file instanceof UploadedFile,
        ));
    }
}
