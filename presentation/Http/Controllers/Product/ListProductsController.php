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
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        if ($registeredUser === null) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'Nao foi possivel carregar seu perfil agora.');
        }

        $perPage = max(1, min(30, (int) $request->integer('per_page', 12)));
        $searchName = trim((string) $request->string('q', ''));
        $products = $useCase->execute($productRepository, $registeredUser->id, $perPage, $searchName)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'registeredUser' => $registeredUser,
            'searchName' => $searchName,
        ]);
    }
}
