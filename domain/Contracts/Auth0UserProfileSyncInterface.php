<?php

namespace Domain\Contracts;

interface Auth0UserProfileSyncInterface
{
    public function sync(string $authIdentifier, array $profile): void;
}
