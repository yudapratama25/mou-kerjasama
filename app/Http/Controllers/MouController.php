<?php

namespace App\Http\Controllers;

use App\Exports\MouExport;
use App\Models\Mou;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MouController extends Controller
{
    public function index()
    {
        $mous = Mou::with('unit')->orderBy('created_at', 'desc')->get();
        return view('mou.index', compact('mous'));
    }

    public function show(Mou $mou)
    {
        if (!$mou) {
            return response()->json(['status' => false, 'message' => 'not found'], 404);
        }

        $html = view('mou.show', compact('mou'))->render();

        return response()->json(['status' => true, 'message' => 'berhasil mendapatkan data MOU', 'data' => ['html' => $html]], 200);
    }

    public function downloadFile($file)
    {
        return response()->download(public_path('upload/mou/'.$file));
    }

    public function create()
    {
        $units = Unit::orderBy('name', 'asc')->get();
        return view('mou.create', compact('units'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if ($request->has('pks_contract_value') && $request->has('bank_transfer_proceeds') && $request->has('nominal_difference')) {
            $input['pks_contract_value'] = str_replace('.', '', $request->pks_contract_value);
            $input['bank_transfer_proceeds'] = str_replace('.', '', $request->bank_transfer_proceeds);
            $input['nominal_difference'] = str_replace('.', '', $request->nominal_difference);
        }

        $validator = Validator::make($input, [
            'unit_id' => 'required|numeric|exists:units,id',
            'letter_number' => 'required|string|max:100',
            'letter_receipt_date' => 'required|date',
            'regarding_letters' => 'required|string',
            'mou_number' => 'required|string|max:100',
            'mou_start' => 'required|date',
            'mou_end' => 'required|date',
            'mou_status' => 'required|in:HIDUP,MATI',
            'pks_number' => 'required|string|max:100',
            'pks_start' => 'required|date',
            'pks_end' => 'required|date',
            'pks_status' => 'required|in:HIDUP,MATI',
            'pks_regarding' => 'required|string',
            'pks_contract_value' => 'required|numeric',
            'bank_transfer_proceeds' => 'required|numeric',
            'nominal_difference' => 'required|numeric',
            'partner_name' => 'required|string|max:250',
            'signature_part_1' => 'required|string|max:250',
            'signature_part_2' => 'required|string|max:250',
            'document_pks' => 'boolean',
            'document_tor' => 'boolean',
            'document_rab' => 'boolean',
            'document_sptjm' => 'boolean',
            'document_mou' => 'boolean',
            'document_bank_transfer_proceeds' => 'boolean',
            'description' => 'max:5000',
            'mou_file' => 'file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($input);
        }

        if ($request->hasFile('mou_file')) {
            $mou_file = $this->uploadFile("upload/mou", $request->file('mou_file'));
            $input['mou_file'] = $mou_file;
        }

        $input['user_id'] = Auth::id();

        Mou::create($input);

        return redirect()->route('mou.index')->with('success', 'Data MOU berhasil ditambahkan');
    }

    private function uploadFile($destination, $file, $oldFile = null)
    {
        $filename = date('dmy') . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($destination), $filename);

        // check jika sudah ada file sebelumnya, maka hapus dari storage
        if ($oldFile != NULL && file_exists(public_path($destination . '/' . $oldFile))) {
            unlink(public_path($destination . '/' . $oldFile));   
        }

        return $filename;
    }

    public function edit(Mou $mou)
    {
        if (!$mou) {
            return redirect()->route('mou.index');
        }

        $units = Unit::orderBy('name', 'asc')->get();

        return view('mou.edit', compact('mou', 'units'));
    }

    public function update(Request $request, Mou $mou)
    {
        if (!$mou) {
            return redirect()->route('mou.index');
        }

        $input = $request->all();

        if ($request->has('pks_contract_value') && $request->has('bank_transfer_proceeds') && $request->has('nominal_difference')) {
            $input['pks_contract_value'] = str_replace('.', '', $request->pks_contract_value);
            $input['bank_transfer_proceeds'] = str_replace('.', '', $request->bank_transfer_proceeds);
            $input['nominal_difference'] = str_replace('.', '', $request->nominal_difference);
        }

        $validator = Validator::make($input, [
            'unit_id' => 'required|numeric|exists:units,id',
            'letter_number' => 'required|string|max:100',
            'letter_receipt_date' => 'required|date',
            'regarding_letters' => 'required|string',
            'mou_number' => 'required|string|max:100',
            'mou_start' => 'required|date',
            'mou_end' => 'required|date',
            'mou_status' => 'required|in:HIDUP,MATI',
            'pks_number' => 'required|string|max:100',
            'pks_start' => 'required|date',
            'pks_end' => 'required|date',
            'pks_status' => 'required|in:HIDUP,MATI',
            'pks_regarding' => 'required|string',
            'pks_contract_value' => 'required|numeric',
            'bank_transfer_proceeds' => 'required|numeric',
            'nominal_difference' => 'required|numeric',
            'partner_name' => 'required|string|max:250',
            'signature_part_1' => 'required|string|max:250',
            'signature_part_2' => 'required|string|max:250',
            'document_pks' => 'boolean',
            'document_tor' => 'boolean',
            'document_rab' => 'boolean',
            'document_sptjm' => 'boolean',
            'document_mou' => 'boolean',
            'document_bank_transfer_proceeds' => 'boolean',
            'description' => 'max:5000',
            'mou_file' => 'file',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($input);
        }

        if ($request->hasFile('mou_file')) {
            $mou_file = $this->uploadFile("upload/mou", $request->file('mou_file'));
            $input['mou_file'] = $mou_file;
        }

        foreach (['pks', 'tor', 'rab', 'sptjm', 'mou', 'bank_transfer_proceeds'] as $item) {
            if (!$request->has('document_'.$item)) {
                $input['document_'.$item] = 0;
            }
        }

        $mou->update($input);

        return redirect()->route('mou.index')->with('success', 'Data MOU berhasil diubah');
    }

    public function destroy(Request $request, $id)
    {
        $this->validate($request, ['id' => 'required']);

        Mou::where('id', $request->id)->delete();

        $request->session()->flash('success', 'Data MOU berhasil dihapus');

        return response()->json(['status' => true, 'message' => "Data MOU berhasil dihapus"]);
    }

    public function export()
    {
        return Excel::download(new MouExport, 'DATA MOU & PKS.xlsx');
    }
}
