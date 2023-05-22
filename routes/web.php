<?php

use App\Models\Mou;
use App\Models\Unit;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MouController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Models\Log;

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

Route::middleware(['auth','validity_period'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        $countUnit = Unit::where('year_id', session('selected_year_id'))->count();
        $countMou = Mou::where('year_id', session('selected_year_id'))->count();

        return view('dashboard', ['countUnit' => $countUnit, 'countMou' => $countMou]);
    })->name('dashboard');

    Route::resource('unit', UnitController::class);
    Route::get('mou/export', [MouController::class, 'export'])->name('mou.export');
    Route::get('mou/download-file/{file}', [MouController::class, 'downloadFile'])->name('mou.download-file');
    Route::get('mou/export-pdf/{id}', [MouController::class, 'exportPdf'])->name('mou.export-pdf');
    Route::post('mou/upload-mou-file', [MouController::class, 'uploadFile'])->name('mou.uploadFile');
    Route::resource('mou', MouController::class);

    Route::post('user/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::resource('user', UserController::class);

    Route::post('change-year', function(Request $request) {
        $selected_year = Year::where('id', $request->year_id)->first();

        session(['selected_year_id' => $request->year_id, 'selected_year' => $selected_year->year]);

        return response()->json(['status' => true, 'message' => 'pergantian tahun berhasil'], 200);
    })->name('change-year');

    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::patch('profile', [UserController::class, 'updateProfile'])->name('user.update-profile');

    Route::get('log', function() {
        if (Auth::user()->role === "user") {
            return redirect('/');
        }

        $logs = Log::with('user')->where('year_id', session('selected_year_id'))->orderBy('created_at', 'desc')->paginate(50);

        return view('log', compact('logs'));
    })->name('log');
});