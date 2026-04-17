<?php

namespace Domain\Contracts;

use Illuminate\Http\UploadedFile;

interface ProductImageStorageInterface
{
    public function upload(UploadedFile $image): string;

    public function url(string $path): string;

    public function delete(?string $path): void;
}
