<?php

namespace Domain\Contracts;

interface Auth0UserRegistrationInterface
{
    public function register(string $name, string $email, string $password): string;
}
