<?php

namespace App\Http\Controllers;

use App\Exports\MouExport;
use App\Models\Mou;
use App\Models\MouFile;
use App\Models\Unit;
use App\Models\Year;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MouController extends Controller
{
    public function index()
    {
        $mous = Mou::with('unit')->where('year_id', session('selected_year_id'))->orderBy('created_at', 'desc')->get();
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
        $units = Unit::where('year_id', session('selected_year_id'))->orderBy('name', 'asc')->get();
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
            'files' => 'array',
            'files_size' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($input);
        }

        $input['user_id'] = Auth::id();

        $input['year_id'] = session('selected_year_id');

        $new_mou = Mou::create($input);

        if ($request->has('files')) {
            foreach ($input['files'] as $indexFile => $filename) {
                MouFile::create(['mou_id' => $new_mou->id, 'filename' => $filename, 'size' => $input['files_size'][$indexFile]]);
            }
        }

        createLog("Create Data MOU | No. Surat $new_mou->letter_number");

        return redirect()->route('mou.index')->with('success', 'Data MOU berhasil ditambahkan');
    }

    public function uploadFile(Request $request)
    {
        $path = public_path('upload/mou');

        $file = $request->file('file');

        $name = rand(100,999) . '_' . trim($file->getClientOriginalName());

        $name = str_replace('&', 'dan', $name);

        $size = $file->getSize();

        $file->move($path, $name);

        return response()->json([
            'status' => true,
            'message' => 'upload file successfully',
            'data' => [
                'uniq' => rand(100, 999),
                'name' => $name,
                'original_name' => $file->getClientOriginalName(),
                'size' => $size
            ]
        ]);
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
            'files' => 'array',
            'files_size' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($input);
        }

        foreach (['pks', 'tor', 'rab', 'sptjm', 'mou', 'bank_transfer_proceeds'] as $item) {
            if (!$request->has('document_'.$item)) {
                $input['document_'.$item] = 0;
            }
        }

        $mou->update($input);

        $update_files = $request->has('files') ? $input['files'] : [];

        foreach($mou->files as $old_file) {
            if (!in_array($old_file->filename, $update_files)) {
                if (file_exists(public_path('upload/mou/' . $old_file->filename))) {
                    unlink(public_path('upload/mou/' . $old_file->filename));   
                }

                MouFile::where('id', $old_file->id)->delete();
            } else {
                if (($key = array_search($old_file->filename, $update_files)) !== false) {
                    unset($update_files[$key]);
                }
            }
        }

        if (count($update_files) > 0) {
            foreach ($update_files as $key => $new_filename) {
                MouFile::create(['mou_id' => $mou->id, 'filename' => $new_filename, 'size' => $input['files_size'][$key]]);
            }
        }

        createLog("Update Data MOU | No. Surat $request->letter_number");

        return redirect()->route('mou.index')->with('success', 'Data MOU berhasil diubah');
    }

    public function destroy(Request $request, $id)
    {
        $this->validate($request, ['id' => 'required']);

        $mou = Mou::where('year_id', session('selected_year_id'))->where('id', $request->id)->first();

        if ($mou != null) {
            $letter_number = $mou->letter_number;
            $mou->delete();
            createLog("Delete Data MOU | No. Surat $letter_number");
        }

        $request->session()->flash('success', 'Data MOU berhasil dihapus');

        return response()->json(['status' => true, 'message' => "Data MOU berhasil dihapus"]);
    }

    public function export()
    {
        $year = Year::where('id', session('selected_year_id'))->first()->year;

        return Excel::download(new MouExport, 'DATA MOU & PKS TAHUN '. $year .'.xlsx');
    }
}
