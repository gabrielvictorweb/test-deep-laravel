<?php

namespace Infra\Repositories;

use Auth0\Laravel\Facade\Auth0;
use Domain\Contracts\Auth0UserRegistrationInterface;
use RuntimeException;
use Throwable;

class Auth0UserRegistrationRepository implements Auth0UserRegistrationInterface
{
    public function register(string $name, string $email, string $password): string
    {
        try {
            $response = Auth0::management()
                ->users()
                ->create($this->resolveConnectionName(), [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'verify_email' => true,
                ]);
        } catch (Throwable $exception) {
            throw new RuntimeException('Nao foi possivel criar a conta no Auth0. Verifique a configuracao e tente novamente.');
        }

        $statusCode = $response->getStatusCode();
        $payload = json_decode((string) $response->getBody(), true);

        if ($statusCode === 409) {
            throw new RuntimeException('Ja existe uma conta no Auth0 com este email. Use "Entrar na conta" para autenticar.');
        }

        if ($statusCode !== 201) {
            $message = is_array($payload) ? (string) ($payload['message'] ?? '') : '';
            throw new RuntimeException($message !== ''
                ? 'Falha ao criar conta no Auth0: ' . $message
                : 'Falha ao criar conta no Auth0.');
        }

        $authIdentifier = is_array($payload) ? (string) ($payload['user_id'] ?? '') : '';

        if ($authIdentifier === '') {
            throw new RuntimeException('Conta criada no Auth0 sem identificador de usuario.');
        }

        return $authIdentifier;
    }

    private function resolveConnectionName(): string
    {
        $connection = trim((string) env('AUTH0_DB_CONNECTION', 'Username-Password-Authentication'));

        if ($connection === '') {
            throw new RuntimeException('A conexao AUTH0_DB_CONNECTION nao foi configurada.');
        }

        return $connection;
    }
}
