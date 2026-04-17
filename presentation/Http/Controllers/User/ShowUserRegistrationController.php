<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Presentation\Http\Controllers\Controller;

class ShowUserRegistrationController extends Controller
{
    public function execute(
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): View {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository);

        return view('users.create', [
            'registeredUser' => $registeredUser,
            'authEmail' => (string) (data_get(auth()->user(), 'email') ?? ''),
            'authName' => (string) (data_get(auth()->user(), 'name') ?? data_get(auth()->user(), 'nickname') ?? ''),
        ]);
    }
}
