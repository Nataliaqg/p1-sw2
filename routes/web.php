<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

// Auth::routes();

Route::get('/', function () {
    return view('home');
});

Route::get('/graficas', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/recomendacion', [App\Http\Controllers\RecomendacionController::class, 'index'])->name('recomendacion');

Route::get('/tiendas-similares/{pdv_id}', [App\Http\Controllers\TiendaSimilarController::class, 'index'])->name('tiendaSimilar');

