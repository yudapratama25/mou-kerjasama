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