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
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
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
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('product_images', 'id')->where(static fn ($query) => $query->where('product_id', $product->id)),
            ],
        ]);

        $images = array_values(array_filter(
            (array) $request->file('images', []),
            static fn ($file): bool => $file instanceof UploadedFile,
        ));

        $removeImageIds = array_values(array_filter(
            array_map(static fn ($id): int => (int) $id, (array) ($payload['remove_image_ids'] ?? [])),
            static fn (int $id): bool => $id > 0,
        ));

        $useCase->execute(
            $product,
            [
                'name' => $payload['name'],
                'description' => $payload['description'] ?? null,
                'price' => $payload['price'],
            ],
            $images,
            $productRepository,
            $imageStorage,
            $removeImageIds,
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }
}
