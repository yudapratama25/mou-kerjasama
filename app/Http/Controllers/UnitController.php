<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::orderBy('name', 'asc')->get();
        return view('unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.create');
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
            'name' => 'required|string|max:250'
        ]);

        Unit::create(['name' => $request->name]);

        return redirect()->route('unit.index')->with('success', 'Data unit kerja berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        if (!$unit) {
            return redirect()->route('dashboard');
        }

        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        if (!$unit) {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name' => 'required|string|max:250'
        ]);

        $unit->update(['name' => $request->name]);

        return redirect()->route('unit.index')->with('success', 'Data unit kerja berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, ['id' => 'required|numeric']);

        Unit::where('id', $request->id)->delete();

        $request->session()->flash('success', 'Data unit kerja berhasil dihapus');

        return response()->json(['status' => true, 'message' => "Data unit kerja berhasil dihapus"]);
    }
}
