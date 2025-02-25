<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

function createLog($action) {
    Log::create([
        'year_id' => session('selected_year_id'),
        'user_id' => Auth::id(),
        'action'  => $action
    ]);
}

function rupiah($value) {
    $nilai = intval($value);
    return number_format($nilai, 0, ',', '.');
}

function snakeCase(string $string) {
    return strtolower(str_replace(' ', '-', $string));
}
