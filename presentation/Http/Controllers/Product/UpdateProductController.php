<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\Product\UpdateProductUseCase;
use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;

class UpdateProductController extends Controller
{
    public function execute(
        Request $request,
        Product $product,
        UpdateProductUseCase $useCase,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository);

        if ($registeredUser === null) {
            return redirect()
                ->route('users.create')
                ->with('warning', 'Conclua seu cadastro de usuario para atualizar produtos.');
        }

        abort_if($product->user_id !== $registeredUser->id, 403);

        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $useCase->execute(
            $product,
            [
                'name' => $payload['name'],
                'description' => $payload['description'] ?? null,
                'price' => $payload['price'],
            ],
            $request->file('image'),
            $productRepository,
            $imageStorage,
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }
}
