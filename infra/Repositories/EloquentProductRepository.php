<?php

namespace Infra\Repositories;

use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginateByUserId(int $userId, int $perPage = 12, ?string $name = null): LengthAwarePaginator
    {
        return Product::query()
            ->with('images')
            ->where('user_id', $userId)
            ->when(
                is_string($name) && trim($name) !== '',
                static fn ($query) => $query->where('name', 'like', '%' . trim((string) $name) . '%'),
            )
            ->latest()
            ->paginate($perPage);
    }

    public function recentByUserId(int $userId, int $limit = 5): Collection
    {
        return Product::query()
            ->with('images')
            ->where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function countByUserId(int $userId): int
    {
        return Product::query()
            ->where('user_id', $userId)
            ->count();
    }

    public function create(array $attributes): Product
    {
        return Product::query()->create($attributes);
    }

    public function update(Product $product, array $attributes): Product
    {
        $product->fill($attributes);
        $product->save();

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
