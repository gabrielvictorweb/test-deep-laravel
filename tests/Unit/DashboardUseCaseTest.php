<?php

namespace Tests\Unit;

use Application\UseCases\Dashboard\GetDashboardOverviewUseCase;
use Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class DashboardUseCaseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_it_returns_dashboard_overview_for_user(): void
    {
        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $recentProducts = new Collection();

        $repository->shouldReceive('countByUserId')->once()->with(42)->andReturn(8);
        $repository->shouldReceive('recentByUserId')->once()->with(42, 5)->andReturn($recentProducts);

        $result = (new GetDashboardOverviewUseCase())->execute(42, $repository);

        $this->assertSame(8, $result['productsCount']);
        $this->assertSame($recentProducts, $result['recentProducts']);
    }
}
