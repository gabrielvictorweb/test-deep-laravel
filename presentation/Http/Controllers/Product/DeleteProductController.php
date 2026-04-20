<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\Product\DeleteProductUseCase;
use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Http\RedirectResponse;
use Presentation\Http\Controllers\Controller;

class DeleteProductController extends Controller
{
    public function execute(
        Product $product,
        DeleteProductUseCase $useCase,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        if ($registeredUser === null) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'Nao foi possivel carregar seu perfil agora.');
        }

        abort_if($product->user_id !== $registeredUser->id, 403);

        $product->loadMissing('images');

        $useCase->execute($product, $productRepository, $imageStorage);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto removido com sucesso.');
    }
}
