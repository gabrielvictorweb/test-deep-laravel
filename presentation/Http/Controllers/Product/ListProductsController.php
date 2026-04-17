<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\Product\ListProductsUseCase;
use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;

class ListProductsController extends Controller
{
    public function execute(
        Request $request,
        ListProductsUseCase $useCase,
        ProductRepositoryInterface $productRepository,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): View|RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository);

        if ($registeredUser === null) {
            return redirect()
                ->route('users.create')
                ->with('warning', 'Conclua seu cadastro de usuario para listar seus produtos.');
        }

        $perPage = max(1, min(30, (int) $request->integer('per_page', 12)));
        $products = $useCase->execute($productRepository, $registeredUser->id, $perPage)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'registeredUser' => $registeredUser,
        ]);
    }
}
