<?php

namespace Infra\Repositories;

use Domain\Contracts\UserRepositoryInterface;
use Domain\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByAuthIdentifier(string $authIdentifier): ?User
    {
        return User::query()
            ->where('auth_identifier', $authIdentifier)
            ->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function create(array $attributes): User
    {
        return User::query()->create($attributes);
    }

    public function update(User $user, array $attributes): User
    {
        $user->fill($attributes);
        $user->save();

        return $user->refresh();
    }
}
