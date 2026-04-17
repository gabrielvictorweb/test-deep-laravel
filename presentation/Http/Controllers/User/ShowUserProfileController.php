<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Presentation\Http\Controllers\Controller;

class ShowUserProfileController extends Controller
{
    public function execute(
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): View|RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        if ($registeredUser === null) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'Nao foi possivel carregar seu perfil agora.');
        }

        return view('users.profile', [
            'registeredUser' => $registeredUser,
        ]);
    }
}
