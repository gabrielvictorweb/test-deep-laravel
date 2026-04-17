<?php

namespace Application\UseCases\User;

use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\User;
use Illuminate\Http\UploadedFile;

class RegisterUserUseCase
{
    public function execute(
        array $payload,
        ?UploadedFile $avatar,
        ?string $authIdentifier,
        UserRepositoryInterface $userRepository,
        UserAvatarStorageInterface $avatarStorage,
    ): User {
        $attributes = [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password'],
            'auth_identifier' => $authIdentifier,
        ];

        if ($avatar !== null) {
            $avatarPath = $avatarStorage->upload($avatar);
            $attributes['avatar_path'] = $avatarPath;
            $attributes['avatar_url'] = $avatarStorage->url($avatarPath);
        }

        return $userRepository->create($attributes);
    }
}
