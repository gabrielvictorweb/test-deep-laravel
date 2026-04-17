<?php

namespace Infra\Repositories;

use Auth0\Laravel\Facade\Auth0;
use Domain\Contracts\Auth0UserProfileSyncInterface;
use RuntimeException;

class Auth0UserProfileSyncRepository implements Auth0UserProfileSyncInterface
{
    public function sync(string $authIdentifier, array $profile): void
    {
        $response = Auth0::management()
            ->users()
            ->update($authIdentifier, $profile);

        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Nao foi possivel sincronizar o perfil no Auth0.');
        }
    }
}
