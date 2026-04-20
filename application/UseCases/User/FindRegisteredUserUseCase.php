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
        $nameClaim = (string) ($authenticatedUser?->name ?? '');
        $nicknameClaim = (string) ($authenticatedUser?->nickname ?? '');
        $givenNameClaim = (string) ($authenticatedUser?->given_name ?? '');
        $emailClaim = (string) ($authenticatedUser?->email ?? '');
        $pictureClaim = $authenticatedUser?->picture;
        $emailFromName = $nameClaim !== '' && filter_var($nameClaim, FILTER_VALIDATE_EMAIL) ? $nameClaim : '';
        $isLocalFallbackEmail = static fn (string $value): bool => str_ends_with(strtolower($value), '@local.invalid');

        $email = (!$isLocalFallbackEmail($emailClaim) && $emailClaim !== '')
            ? $emailClaim
            : ((!$isLocalFallbackEmail($emailFromName) && $emailFromName !== '') ? $emailFromName : '');

        if ($authIdentifier !== '') {
            $byAuthIdentifier = $userRepository->findByAuthIdentifier($authIdentifier);

            if ($byAuthIdentifier !== null) {
                if ($email !== '' && $byAuthIdentifier->email !== $email) {
                    $userWithAuthEmail = $userRepository->findByEmail($email);

                    if ($userWithAuthEmail === null || $userWithAuthEmail->id === $byAuthIdentifier->id) {
                        return $userRepository->update($byAuthIdentifier, ['email' => $email]);
                    }
                }

                return $byAuthIdentifier;
            }

            if ($email === '' && $createWhenMissing && $authenticatedUser !== null) {
                $resolvedEmail = 'auth-' . substr(sha1($authIdentifier), 0, 16) . '@local.invalid';
                $resolvedName = (string) (
                    ($nameClaim !== '' ? $nameClaim : null)
                    ?? ($nicknameClaim !== '' ? $nicknameClaim : null)
                    ?? ($givenNameClaim !== '' ? $givenNameClaim : null)
                    ?? 'Usuario'
                );

                $resolvedPicture = is_string($pictureClaim) ? $pictureClaim : null;

                return $userRepository->create([
                    'name' => $resolvedName,
                    'email' => $resolvedEmail,
                    'auth_identifier' => $authIdentifier,
                    'password' => Str::random(40),
                    'avatar_url' => is_string($resolvedPicture) && $resolvedPicture !== '' ? $resolvedPicture : null,
                ]);
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
                ($nameClaim !== '' ? $nameClaim : null)
                ?? ($nicknameClaim !== '' ? $nicknameClaim : null)
                ?? explode('@', $resolvedEmail)[0]
                ?? 'Usuario'
            );

            $resolvedPicture = is_string($pictureClaim) ? $pictureClaim : null;

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
