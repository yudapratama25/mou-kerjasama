<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('role', 'asc')->orderBy('name', 'asc')->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'email' => 'required|email',
            'from_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'from_date' => $request->from_date,
            'end_date' => $request->end_date,
        ]);

        createLog("Create Pengguna | Nama : $request->name");

        return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'email' => 'required|email',
            'from_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'from_date' => $request->from_date,
            'end_date' => $request->end_date,
        ]);

        createLog("Update Pengguna | Nama : $request->name");

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diubah');
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        
        $user->update([
            'password' => Hash::make('12345678')
        ]);

        createLog("Reset Password Pengguna | Nama : $user->name");

        $request->session()->flash('success', 'Password berhasil diubah menjadi "12345678"');

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah menjadi `12345678`'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        if ($request->has('password') && $request->password != "") {
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required|string|min:8';
        }

        if (Auth::user()->role !== "user") {
            $rules['name'] = 'required|string';
        }

        $this->validate($request, $rules);

        $data = $request->only(['email','name']);

        if ($request->has('password') && $request->password != "") {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', Auth::id())->update($data);

        createLog("Update Profile");

        return redirect()->route('user.profile')->with('success', 'Data akun berhasil diupdate');
    }
}
