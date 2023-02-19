<?php

use App\Http\Controllers\PerfumeController;
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



Route::get('/', [PerfumeController::class, 'index']);
Route::post('/create', [PerfumeController::class, 'create'])->name('create');
Route::get('/read', [PerfumeController::class, 'read'])->name('read');
Route::post('/update', [PerfumeController::class, 'update'])->name('update');
Route::delete('/delete', [PerfumeController::class, 'delete'])->name('delete');
Route::get('/edit', [PerfumeController::class, 'edit'])->name('edit');