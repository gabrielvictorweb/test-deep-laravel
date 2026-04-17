<?php

namespace Domain\Contracts;

use Domain\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginateByUserId(int $userId, int $perPage = 12): LengthAwarePaginator;

    public function recentByUserId(int $userId, int $limit = 5): Collection;

    public function countByUserId(int $userId): int;

    public function create(array $attributes): Product;

    public function update(Product $product, array $attributes): Product;

    public function delete(Product $product): void;
}
