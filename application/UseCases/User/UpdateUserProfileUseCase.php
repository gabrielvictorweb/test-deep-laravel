<?php

namespace Application\UseCases\User;

use Domain\Contracts\Auth0UserProfileSyncInterface;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\User;
use Illuminate\Http\UploadedFile;

class UpdateUserProfileUseCase
{
    public function execute(
        User $user,
        array $payload,
        ?UploadedFile $avatar,
        UserRepositoryInterface $userRepository,
        UserAvatarStorageInterface $avatarStorage,
        Auth0UserProfileSyncInterface $auth0UserProfileSync,
    ): User {
        $localPayload = [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ];

        if (isset($payload['password']) && is_string($payload['password']) && $payload['password'] !== '') {
            $localPayload['password'] = $payload['password'];
        }

        $auth0Payload = [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ];

        $oldAvatarPath = $user->avatar_path;

        if ($avatar !== null) {
            $avatarPath = $avatarStorage->upload($avatar);
            $avatarUrl = $avatarStorage->url($avatarPath);
            $localPayload['avatar_path'] = $avatarPath;
            $localPayload['avatar_url'] = $avatarUrl;
            $auth0Payload['picture'] = $avatarUrl;
        }

        if (is_string($user->auth_identifier) && $user->auth_identifier !== '') {
            $auth0UserProfileSync->sync($user->auth_identifier, $auth0Payload);
        }

        $updatedUser = $userRepository->update($user, $localPayload);

        if ($avatar !== null) {
            $avatarStorage->delete($oldAvatarPath);
        }

        return $updatedUser;
    }
}
