<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Application\UseCases\User\UpdateUserProfileUseCase;
use Domain\Contracts\Auth0UserProfileSyncInterface;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Presentation\Http\Controllers\Controller;

class UpdateUserProfileController extends Controller
{
    public function execute(
        Request $request,
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UpdateUserProfileUseCase $updateUserProfileUseCase,
        UserRepositoryInterface $userRepository,
        UserAvatarStorageInterface $avatarStorage,
        Auth0UserProfileSyncInterface $auth0UserProfileSync,
    ): RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        if ($registeredUser === null) {
            return redirect()
            ->route('dashboard')
            ->with('warning', 'Nao foi possivel atualizar seu perfil agora.');
        }

        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($registeredUser->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        $updateUserProfileUseCase->execute(
            $registeredUser,
            $payload,
            $request->file('avatar'),
            $userRepository,
            $avatarStorage,
            $auth0UserProfileSync,
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Perfil atualizado com sucesso.');
    }
}
