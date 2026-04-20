<?php

namespace Presentation\Http\Controllers\Product;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Presentation\Http\Controllers\Controller;

class ShowEditProductController extends Controller
{
    public function execute(
        Product $product,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): View|RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        if ($registeredUser === null) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'Nao foi possivel carregar seu perfil agora.');
        }

        abort_if($product->user_id !== $registeredUser->id, 403);

        $product->loadMissing('images');

        return view('products.edit', [
            'product' => $product,
            'registeredUser' => $registeredUser,
        ]);
    }
}
