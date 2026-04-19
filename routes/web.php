<?php

use Illuminate\Support\Facades\Route;
use Presentation\Http\Controllers\Dashboard\ShowDashboardController;
use Presentation\Http\Controllers\Product\CreateProductController;
use Presentation\Http\Controllers\Product\DeleteProductController;
use Presentation\Http\Controllers\Product\ShowCreateProductController;
use Presentation\Http\Controllers\Product\ShowEditProductController;
use Presentation\Http\Controllers\Product\ShowProductGalleryImageController;
use Presentation\Http\Controllers\Product\ListProductsController;
use Presentation\Http\Controllers\Product\ShowProductImageController;
use Presentation\Http\Controllers\Product\UpdateProductController;
use Presentation\Http\Controllers\User\ShowUserAvatarController;
use Presentation\Http\Controllers\User\ShowUserProfileController;
use Presentation\Http\Controllers\User\ShowUserRegistrationController;
use Presentation\Http\Controllers\User\StoreUserRegistrationController;
use Presentation\Http\Controllers\User\UpdateUserProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios/cadastro', [ShowUserRegistrationController::class, 'execute'])->name('users.create');
Route::post('/usuarios/cadastro', [StoreUserRegistrationController::class, 'execute'])->name('users.store');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [ShowDashboardController::class, 'execute'])->name('dashboard');
    Route::get('/perfil', [ShowUserProfileController::class, 'execute'])->name('profile.edit');
    Route::get('/perfil/avatar', [ShowUserAvatarController::class, 'execute'])->name('profile.avatar');
    Route::put('/perfil', [UpdateUserProfileController::class, 'execute'])->name('profile.update');

    Route::get('/produtos', [ListProductsController::class, 'execute'])->name('products.index');
    Route::get('/produtos/novo', [ShowCreateProductController::class, 'execute'])->name('products.create');
    Route::get('/produtos/{product}/editar', [ShowEditProductController::class, 'execute'])->name('products.edit');
    Route::get('/produtos/{product}/imagem', [ShowProductImageController::class, 'execute'])->name('products.image');
    Route::get('/produtos/{product}/imagens/{image}', [ShowProductGalleryImageController::class, 'execute'])->name('products.gallery-image');
    Route::post('/produtos', [CreateProductController::class, 'execute'])->name('products.store');
    Route::put('/produtos/{product}', [UpdateProductController::class, 'execute'])->name('products.update');
    Route::delete('/produtos/{product}', [DeleteProductController::class, 'execute'])->name('products.destroy');
});
