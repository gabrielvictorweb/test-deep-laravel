<?php

namespace Application\UseCases\Dashboard;

use Domain\Contracts\ProductRepositoryInterface;

class GetDashboardOverviewUseCase
{
    public function execute(
        int $userId,
        ProductRepositoryInterface $productRepository,
    ): array {
        return [
            'productsCount' => $productRepository->countByUserId($userId),
            'recentProducts' => $productRepository->recentByUserId($userId, 5),
        ];
    }
}
