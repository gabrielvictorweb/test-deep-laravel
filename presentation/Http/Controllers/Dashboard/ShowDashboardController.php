<?php

namespace Presentation\Http\Controllers\Dashboard;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Presentation\Http\Controllers\Controller;

class ShowDashboardController extends Controller
{
    public function execute(
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): View
    {
        $authenticatedUser = auth()->user();
        $registeredUser = $findRegisteredUserUseCase->execute($authenticatedUser, $userRepository, true);
        $authEmail = (string) ($authenticatedUser?->email ?? '');
        $authName = (string) ($authenticatedUser?->name ?? '');
        $authNickname = (string) ($authenticatedUser?->nickname ?? '');
        $authGivenName = (string) ($authenticatedUser?->given_name ?? '');
        $authNameLooksLikeEmail = $authName !== '' && filter_var($authName, FILTER_VALIDATE_EMAIL);
        $authEmailFromName = $authNameLooksLikeEmail ? $authName : '';
        $isLocalFallbackEmail = static fn (string $value): bool => str_ends_with(strtolower($value), '@local.invalid');
        $resolvedAuthEmail = (!$isLocalFallbackEmail($authEmail) && $authEmail !== '')
            ? $authEmail
            : ((!$isLocalFallbackEmail($authEmailFromName) && $authEmailFromName !== '') ? $authEmailFromName : '');
        $normalizedAuthName = $authNameLooksLikeEmail
            ? ($authNickname !== '' ? $authNickname : $authGivenName)
            : $authName;

        $displayName = (string) (
            ($registeredUser?->name ?? null)
            ?? ($normalizedAuthName !== '' ? $normalizedAuthName : null)
            ?? ($authGivenName !== '' ? $authGivenName : null)
            ?? ($resolvedAuthEmail !== '' ? explode('@', $resolvedAuthEmail)[0] : null)
            ?? ($registeredUser?->email ?? null)
            ?? 'Usuário autenticado'
        );

        $displayEmail = (string) (
            ($resolvedAuthEmail !== '' ? $resolvedAuthEmail : null)
            ?? ($registeredUser?->email ?? null)
            ?? 'email@example.com'
        );

        return view('dashboard.index', [
            'displayName' => $displayName,
            'displayEmail' => $displayEmail,
        ]);
    }
}
