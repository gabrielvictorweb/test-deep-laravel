<?php

namespace Domain\Contracts;

use Domain\Models\User;

interface UserRepositoryInterface
{
    public function findByAuthIdentifier(string $authIdentifier): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): User;
}
