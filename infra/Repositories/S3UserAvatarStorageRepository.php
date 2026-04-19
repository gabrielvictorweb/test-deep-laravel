<?php

namespace Infra\Repositories;

use Domain\Contracts\UserAvatarStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class S3UserAvatarStorageRepository implements UserAvatarStorageInterface
{
    public function upload(UploadedFile $image): string
    {
        $path = Storage::disk('s3')->putFile('avatars', $image, ['visibility' => 'private']);

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('Nao foi possivel enviar a foto de perfil para o S3.');
        }

        return $path;
    }

    public function url(string $path): string
    {
        return Storage::disk('s3')->url($path);
    }

    public function delete(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        Storage::disk('s3')->delete($path);
    }
}
