<?php

namespace Application\UseCases\Product;

use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class UpdateProductUseCase
{
    public function execute(
        Product $product,
        array $payload,
        UploadedFile|array|null $images,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
        array $removeImageIds = [],
    ): Product {
        $normalizedImages = $this->normalizeImages($images);
        $normalizedRemoveImageIds = $this->normalizeImageIds($removeImageIds);

        if ($product->exists && ($normalizedImages !== [] || $normalizedRemoveImageIds !== [])) {
            $product->loadMissing('images');
        }

        if ($normalizedImages !== []) {
            if ($product->exists) {
                $existingPaths = $product->images
                    ->pluck('path')
                    ->filter(static fn ($path): bool => is_string($path) && $path !== '');

                if ($existingPaths->isEmpty() && is_string($product->image_path) && $product->image_path !== '') {
                    $existingPaths = Collection::make([$product->image_path]);
                }

                foreach ($existingPaths as $path) {
                    $imageStorage->delete($path);
                }

                $product->images()->delete();
            } elseif (is_string($product->image_path) && $product->image_path !== '') {
                $imageStorage->delete($product->image_path);
            }

            $firstPath = $imageStorage->upload($normalizedImages[0]);
            $payload['image_path'] = $firstPath;
            $payload['image_url'] = $imageStorage->url($firstPath);
        } elseif ($normalizedRemoveImageIds !== [] && $product->exists) {
            $imagesToRemove = $product->images
                ->whereIn('id', $normalizedRemoveImageIds)
                ->values();

            foreach ($imagesToRemove as $image) {
                if (is_string($image->path) && $image->path !== '') {
                    $imageStorage->delete($image->path);
                }
            }

            if ($imagesToRemove->isNotEmpty()) {
                $product->images()->whereIn('id', $imagesToRemove->pluck('id'))->delete();

                $product->unsetRelation('images');
                $product->load('images');

                $firstImage = $product->images->first();
                $payload['image_path'] = $firstImage?->path;
                $payload['image_url'] = $firstImage?->url;
            }
        }

        $updatedProduct = $productRepository->update($product, $payload);

        if ($normalizedImages !== [] && $updatedProduct->exists) {
            foreach ($normalizedImages as $index => $image) {
                $path = $index === 0 && isset($firstPath) ? $firstPath : $imageStorage->upload($image);

                $updatedProduct->images()->create([
                    'path' => $path,
                    'url' => $imageStorage->url($path),
                    'sort_order' => $index,
                ]);
            }
        }

        return $updatedProduct->exists ? $updatedProduct->refresh() : $updatedProduct;
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

    /**
     * @param array<int, mixed> $imageIds
     * @return array<int, int>
     */
    private function normalizeImageIds(array $imageIds): array
    {
        return array_values(array_unique(array_filter(
            array_map(static fn ($id): int => (int) $id, $imageIds),
            static fn ($id): bool => $id > 0,
        )));
    }
}
