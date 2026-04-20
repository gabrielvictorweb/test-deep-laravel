<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\RegisterUserUseCase;
use Domain\Contracts\Auth0UserRegistrationInterface;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;
use Throwable;

class StoreUserRegistrationController extends Controller
{
    public function execute(
        Request $request,
        RegisterUserUseCase $registerUserUseCase,
        UserRepositoryInterface $userRepository,
        UserAvatarStorageInterface $avatarStorage,
        Auth0UserRegistrationInterface $auth0UserRegistration,
    ): RedirectResponse {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        $authIdentifier = auth()->check() ? (string) auth()->user()?->getAuthIdentifier() : null;

        if (!$request->user()) {
            try {
                $authIdentifier = $auth0UserRegistration->register(
                    $payload['name'],
                    $payload['email'],
                    $payload['password'],
                );
            } catch (Throwable $exception) {
                return back()
                    ->withInput($request->except(['password', 'password_confirmation']))
                    ->with('warning', $exception->getMessage());
            }
        }

        $registerUserUseCase->execute(
            $payload,
            $request->file('avatar'),
            $authIdentifier,
            $userRepository,
            $avatarStorage,
        );

        return redirect()
            ->route('users.create')
            ->with('success', 'Usuario cadastrado com sucesso. Agora voce pode entrar no sistema.');
    }
}
