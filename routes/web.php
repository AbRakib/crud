<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/brands', [BrandController::class, 'index'])->name('brands');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brand/edit', [BrandController::class, 'edit'])->name('brands.edit');
Route::post('/brand/update', [BrandController::class, 'update'])->name('brands.update');
Route::get('/brand/delete', [BrandController::class, 'destroy'])->name('brands.delete');
