<?php

namespace Application\UseCases\Product;

use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Http\UploadedFile;

class UpdateProductUseCase
{
    public function execute(
        Product $product,
        array $payload,
        ?UploadedFile $image,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
    ): Product {
        if ($image !== null) {
            $imageStorage->delete($product->image_path);

            $imagePath = $imageStorage->upload($image);
            $payload['image_path'] = $imagePath;
            $payload['image_url'] = $imageStorage->url($imagePath);
        }

        return $productRepository->update($product, $payload);
    }
}
