<?php

namespace Presentation\Http\Controllers\User;

use Application\UseCases\User\FindRegisteredUserUseCase;
use Domain\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Presentation\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ShowUserAvatarController extends Controller
{
    public function execute(
        FindRegisteredUserUseCase $findRegisteredUserUseCase,
        UserRepositoryInterface $userRepository,
    ): StreamedResponse|RedirectResponse {
        $registeredUser = $findRegisteredUserUseCase->execute(auth()->user(), $userRepository, true);

        $path = (string) ($registeredUser?->avatar_path ?? '');

        if ($path !== '') {
            try {
                return Storage::disk('s3')->response($path);
            } catch (Throwable) {
                // fallback handled below
            }
        }

        $fallbackUrl = (string) (
            data_get(auth()->user(), 'picture')
            ?? $registeredUser?->avatar_url
            ?? data_get(auth()->user(), 'avatar_url')
            ?? ''
        );

        if ($fallbackUrl !== '' && filter_var($fallbackUrl, FILTER_VALIDATE_URL)) {
            return redirect()->away($fallbackUrl);
        }

        abort(404);
    }
}
