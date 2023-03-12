<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MouController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('submit-login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('unit', UnitController::class);

    Route::get('mou/export', [MouController::class, 'export'])->name('mou.export');
    Route::get('mou/download-file/{file}', [MouController::class, 'downloadFile'])->name('mou.download-file');
    Route::resource('mou', MouController::class);
});

