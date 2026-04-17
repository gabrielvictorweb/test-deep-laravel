<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\Product\CreateProductUseCase;
use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;

class CreateProductController extends Controller
{
    public function execute(
        Request $request,
        CreateProductUseCase $useCase,
        ProductRepositoryInterface $productRepository,
        ProductImageStorageInterface $imageStorage,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository);

        if ($registeredUser === null) {
            return redirect()
                ->route('users.create')
                ->with('warning', 'Conclua seu cadastro de usuario para cadastrar produtos.');
        }

        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $useCase->execute(
            [
                'user_id' => $registeredUser->id,
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
            ->with('success', 'Produto cadastrado com sucesso.');
    }
}
