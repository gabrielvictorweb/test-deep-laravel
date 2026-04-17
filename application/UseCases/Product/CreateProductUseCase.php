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
        ?UploadedFile $image,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
    ): Product {
        if ($image !== null) {
            $imagePath = $imageStorage->upload($image);
            $payload['image_path'] = $imagePath;
            $payload['image_url'] = $imageStorage->url($imagePath);
        }

        return $productRepository->create($payload);
    }
}
