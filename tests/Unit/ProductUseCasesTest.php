<?php

namespace Tests\Unit;

use Application\UseCases\Product\CreateProductUseCase;
use Application\UseCases\Product\DeleteProductUseCase;
use Application\UseCases\Product\ListProductsUseCase;
use Application\UseCases\Product\UpdateProductUseCase;
use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class ProductUseCasesTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_create_product_uploads_image_and_persists_enriched_payload(): void
    {
        $payload = [
            'name' => 'Cafeteira',
            'description' => 'Inox',
            'price' => 199.90,
            'user_id' => 10,
        ];

        $image = Mockery::mock(UploadedFile::class);

        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $storage = Mockery::mock(ProductImageStorageInterface::class);

        $storage->shouldReceive('upload')->once()->with($image)->andReturn('products/image.jpg');
        $storage->shouldReceive('url')->once()->with('products/image.jpg')->andReturn('https://cdn.test/products/image.jpg');

        $repository->shouldReceive('create')->once()->with(Mockery::on(function (array $attributes) use ($payload): bool {
            return $attributes['name'] === $payload['name']
                && $attributes['description'] === $payload['description']
                && $attributes['price'] === $payload['price']
                && $attributes['user_id'] === $payload['user_id']
                && $attributes['image_path'] === 'products/image.jpg'
                && $attributes['image_url'] === 'https://cdn.test/products/image.jpg';
        }))->andReturn(new Product());

        $result = (new CreateProductUseCase())->execute($payload, $image, $repository, $storage);

        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_list_products_delegates_pagination_to_repository(): void
    {
        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $paginator = Mockery::mock(LengthAwarePaginator::class);

        $repository->shouldReceive('paginateByUserId')->once()->with(77, 15)->andReturn($paginator);

        $result = (new ListProductsUseCase())->execute($repository, 77, 15);

        $this->assertSame($paginator, $result);
    }

    public function test_update_product_replaces_existing_image_when_new_file_is_sent(): void
    {
        $product = new Product();
        $product->image_path = 'products/old.jpg';

        $payload = [
            'name' => 'Nome novo',
            'description' => 'Desc nova',
            'price' => 299.90,
        ];

        $image = Mockery::mock(UploadedFile::class);

        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $storage = Mockery::mock(ProductImageStorageInterface::class);

        $storage->shouldReceive('delete')->once()->with('products/old.jpg');
        $storage->shouldReceive('upload')->once()->with($image)->andReturn('products/new.jpg');
        $storage->shouldReceive('url')->once()->with('products/new.jpg')->andReturn('https://cdn.test/products/new.jpg');

        $repository->shouldReceive('update')->once()->with($product, Mockery::on(function (array $attributes): bool {
            return $attributes['image_path'] === 'products/new.jpg'
                && $attributes['image_url'] === 'https://cdn.test/products/new.jpg';
        }))->andReturn($product);

        $result = (new UpdateProductUseCase())->execute($product, $payload, $image, $repository, $storage);

        $this->assertSame($product, $result);
    }

    public function test_delete_product_removes_image_and_product_record(): void
    {
        $product = new Product();
        $product->image_path = 'products/delete-me.jpg';

        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $storage = Mockery::mock(ProductImageStorageInterface::class);

        $storage->shouldReceive('delete')->once()->with('products/delete-me.jpg');
        $repository->shouldReceive('delete')->once()->with($product);

        (new DeleteProductUseCase())->execute($product, $repository, $storage);

        $this->assertTrue(true);
    }
}
