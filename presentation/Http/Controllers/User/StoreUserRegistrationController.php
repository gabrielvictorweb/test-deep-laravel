<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\RegisterUserUseCase;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;

class StoreUserRegistrationController extends Controller
{
    public function execute(
        Request $request,
        RegisterUserUseCase $registerUserUseCase,
        UserRepositoryInterface $userRepository,
        UserAvatarStorageInterface $avatarStorage,
    ): RedirectResponse {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        $registerUserUseCase->execute(
            $payload,
            $request->file('avatar'),
            auth()->check() ? (string) auth()->user()?->getAuthIdentifier() : null,
            $userRepository,
            $avatarStorage,
        );

        return redirect()
            ->route('users.create')
            ->with('success', 'Usuario cadastrado com sucesso. Agora voce pode entrar no sistema.');
    }
}
