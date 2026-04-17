<?php

namespace Application\UseCases\User;

use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

class FindRegisteredUserUseCase
{
    public function execute(
        ?Authenticatable $authenticatedUser,
        UserRepositoryInterface $userRepository,
        bool $createWhenMissing = false,
    ): ?User {
        $authIdentifier = (string) ($authenticatedUser?->getAuthIdentifier() ?? '');
        $email = (string) (data_get($authenticatedUser, 'email') ?? '');

        if ($authIdentifier !== '') {
            $byAuthIdentifier = $userRepository->findByAuthIdentifier($authIdentifier);

            if ($byAuthIdentifier !== null) {
                return $byAuthIdentifier;
            }
        }

        if ($email === '') {
            return null;
        }

        $byEmail = $userRepository->findByEmail($email);

        if ($byEmail === null) {
            if (!$createWhenMissing || $authenticatedUser === null) {
                return null;
            }

            $fallbackKey = $authIdentifier !== '' ? $authIdentifier : (string) Str::uuid();
            $resolvedEmail = $email !== ''
                ? $email
                : 'auth-' . substr(sha1($fallbackKey), 0, 16) . '@local.invalid';

            $resolvedName = (string) (
                data_get($authenticatedUser, 'name')
                ?? data_get($authenticatedUser, 'nickname')
                ?? explode('@', $resolvedEmail)[0]
                ?? 'Usuario'
            );

            $resolvedPicture = data_get($authenticatedUser, 'picture');

            return $userRepository->create([
                'name' => $resolvedName,
                'email' => $resolvedEmail,
                'auth_identifier' => $authIdentifier !== '' ? $authIdentifier : null,
                'password' => Str::random(40),
                'avatar_url' => is_string($resolvedPicture) && $resolvedPicture !== '' ? $resolvedPicture : null,
            ]);
        }

        if ($authIdentifier !== '' && ($byEmail->auth_identifier === null || $byEmail->auth_identifier === '')) {
            return $userRepository->update($byEmail, ['auth_identifier' => $authIdentifier]);
        }

        return $byEmail;
    }
}
