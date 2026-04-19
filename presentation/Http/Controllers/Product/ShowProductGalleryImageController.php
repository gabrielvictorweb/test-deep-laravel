<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\Product;
use Domain\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Presentation\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ShowProductGalleryImageController extends Controller
{
    public function execute(
        Product $product,
        ProductImage $image,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): StreamedResponse|RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository);

        if ($registeredUser === null) {
            return redirect()
                ->route('users.create')
                ->with('warning', 'Conclua seu cadastro de usuario para acessar imagens de produtos.');
        }

        abort_if($product->user_id !== $registeredUser->id, 403);
        abort_if($image->product_id !== $product->id, 404);

        $path = (string) ($image->path ?? '');

        if ($path !== '') {
            try {
                return Storage::disk('s3')->response($path);
            } catch (Throwable) {
                // fallback handled below
            }
        }

        $fallbackUrl = (string) ($image->url ?? '');

        if ($fallbackUrl !== '' && filter_var($fallbackUrl, FILTER_VALIDATE_URL)) {
            return redirect()->away($fallbackUrl);
        }

        abort(404);
    }
}
