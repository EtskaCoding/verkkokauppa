<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProductsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('order');
Route::get('/product/{id}', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('product.show');
Route::post('/product/order', [ProductController::class, 'order'])->middleware(['auth', 'verified'])->name('product.order');
Route::get('/invoice/success', [InvoiceController::class, 'success'])->middleware(['auth', 'verified'])->name('invoice.success');
Route::get('/invoices/', [InvoiceController::class, 'index'])->middleware(['auth', 'verified'])->name('invoices');
Route::post('/invoice/pay/', [InvoiceController::class, 'pay'])->middleware(['auth', 'verified'])->name('invoice.pay');
Route::get('/user_products', [UserProductsController::class, 'index'])->middleware(['auth', 'verified'])->name('user_products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
