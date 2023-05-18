<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ValidityPeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === "user") {
            $now       = strtotime(date('Y-m-d') . " 00:00:00");
            $from_date = Auth::user()->from_date;
            $end_date  = Auth::user()->end_date;
            $from_time = strtotime($from_date . " 00:00:00");
            $end_time  = strtotime($end_date . " 00:00:00");

            if ($now < $from_time || $now > $end_time) {
                Auth::logout();

                $request->session()->invalidate();
     
                $request->session()->regenerateToken();
            
                return redirect('/')->withErrors([
                    'masa_aktif' => 'Anda hanya dapat login dari tanggal <strong>' . Carbon::parse($from_date)->format('d M Y') . '</strong> sampai <strong>' . Carbon::parse($end_date)->format('d M Y') . '</strong>'
                ]);
            }
        }

        if (session('years') == null) {
            Auth::logout();
            session()->flush();
        }

        return $next($request);
    }
}
