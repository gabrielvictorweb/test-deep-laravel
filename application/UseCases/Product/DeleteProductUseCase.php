<?php

namespace Application\UseCases\Product;

use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;

class DeleteProductUseCase
{
    public function execute(
        Product $product,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
    ): void {
        if ($product->relationLoaded('images')) {
            foreach ($product->images as $image) {
                $imageStorage->delete($image->path);
            }
        } else {
            $imageStorage->delete($product->image_path);
        }

        $productRepository->delete($product);
    }
}
