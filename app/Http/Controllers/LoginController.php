<?php
 
namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember_me = $request->has('remember_me') ? true : false;
 
        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            $selected_year = Year::where('year', date('Y'))->first();

            session([
                'years' => Year::orderBy('year')->get()->pluck('year', 'id'),
                'selected_year_id' => $selected_year->id,
                'selected_year' => $selected_year->year
            ]);

            createLog("Login Berhasil");

            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Data user tidak ditemukan'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        createLog("Logout Berhasil");

        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}