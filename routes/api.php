<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // ===== AUTENTICACIÓN =====
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
        Route::put('profile', [AuthController::class, 'updateProfile'])->middleware('auth:api');
         Route::post('/upload-image', [ImageController::class, 'upload'])->middleware('auth:api');
    });

    // ===== CATÁLOGO =====
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/featured', [ProductController::class, 'featured']);
    Route::get('products/search', [ProductController::class, 'search']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('products/{id}/related', [ProductController::class, 'related']);
    Route::get('product/{slug}', [ProductController::class, 'showBySlug']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('categories/slug/{slug}', [CategoryController::class, 'showBySlug']);
    Route::get('categories/{slug}/products', [CategoryController::class, 'products']);

    // ===== CARRITO (con middleware web para sesión) =====
    Route::middleware(['web'])->group(function () {
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart/add', [CartController::class, 'add']);
        Route::put('cart/update', [CartController::class, 'update']);
        Route::delete('cart/remove/{itemId}', [CartController::class, 'remove']);
        Route::delete('cart/clear', [CartController::class, 'clear']);
    });

    // ===== RUTAS PROTEGIDAS (Admin) =====
    Route::middleware(['auth:api'])->group(function () {
        Route::post('admin/products', [ProductController::class, 'store']);
        Route::put('admin/products/{id}', [ProductController::class, 'update']);
        Route::delete('admin/products/{id}', [ProductController::class, 'destroy']);

        Route::post('admin/categories', [CategoryController::class, 'store']);
        Route::put('admin/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('admin/categories/{id}', [CategoryController::class, 'destroy']);
    });
});