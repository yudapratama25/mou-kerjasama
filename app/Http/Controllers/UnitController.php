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
        $units = Unit::where('year_id', session('selected_year_id'))->orderBy('name', 'asc')->get();
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

        Unit::create(['name' => $request->name, 'year_id' => session('selected_year_id')]);

        createLog("Create Data Unit Kerja | Nama unit : $request->name");

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

        $from_name = $unit->name;

        $unit->update(['name' => $request->name]);

        createLog("Update Data Unit Kerja | Dari nama unit : $from_name , Ke nama unit : $request->name");

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

        $unit = Unit::where('year_id', session('selected_year_id'))->where('id', $request->id)->first();

        if ($unit != null) {
            $unit_name = $unit->name;
            $unit->delete();
            createLog("Delete Data Unit Kerja | Nama unit : $unit_name");
        }

        $request->session()->flash('success', 'Data unit kerja berhasil dihapus');

        return response()->json(['status' => true, 'message' => "Data unit kerja berhasil dihapus"]);
    }
}
