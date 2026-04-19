<?php

namespace Infra\Repositories;

use Domain\Contracts\ProductImageStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class S3ProductImageStorageRepository implements ProductImageStorageInterface
{
    public function upload(UploadedFile $image): string
    {
        $path = Storage::disk('s3')->putFile('products', $image, ['visibility' => 'private']);

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('Nao foi possivel enviar a imagem para o S3.');
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
