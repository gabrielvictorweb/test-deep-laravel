<?php

namespace Application\UseCases\Product;

use Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProductsUseCase
{
    public function execute(
        ProductRepositoryInterface $productRepository,
        int $userId,
        int $perPage = 12,
    ): LengthAwarePaginator {
        return $productRepository->paginateByUserId($userId, $perPage);
    }
}
