<?php

namespace App\Http\Controllers;

use App\Models\Mou;
use App\Models\Unit;
use App\Models\Year;
use App\Models\MouFile;
use App\Exports\MouExport;
use App\Enums\DocumentEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\MouRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MouController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mous = Mou::with('unit')
                        ->where('year_id', session('selected_year_id'))
                        ->orderBy('created_at', 'desc');

            if ($request->filled('unit_id') && $request->unit_id != 0) {
                $mous->where('unit_id', $request->unit_id);
            }

            if ($request->filled('regarding_letters')) {
                $mous->where('regarding_letters', 'like', '%' . $request->regarding_letters . '%');
            }

            if ($request->filled('letter_number')) {
                $mous->where('letter_number', 'like', '%' . $request->letter_number . '%');
            }

            if ($request->filled('letter_receipt_date')) {
                $mous->where('letter_receipt_date', $request->letter_receipt_date);
            }

            return DataTables::of($mous)
                            ->addIndexColumn()
                            ->editColumn('letter_receipt_date', function ($mou) {
                                return Carbon::parse($mou->letter_receipt_date)->format('d M Y');
                            })
                            ->editColumn('pks_contract_value', function ($mou) {
                                return rupiah($mou->pks_contract_value);
                            })
                            ->editColumn('nominal_difference', function ($mou) {
                                return rupiah($mou->nominal_difference);
                            })
                            ->editColumn('bank_transfer_proceeds', function ($mou) {
                                return rupiah($mou->bank_transfer_proceeds);
                            })
                            ->addColumn('action', function ($mou) {
                                return '<button class="btn btn-info btn-sm mr-1 show-extra" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <div class="btn-group" role="group">
                                            <button id="btnGroup-{{ $loop->index }}" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroup-{{ $loop->index }}">
                                                <a class="dropdown-item" href="#" onclick="showMou(`'. route('mou.show', $mou->id) .'`)">
                                                    Lihat
                                                </a>
                                                <a class="dropdown-item" href="'. route('mou.edit', $mou->id) .'">
                                                    Edit
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="deleteData(`'. $mou->id .'`, `'. route('mou.destroy', $mou->id) .'`)">
                                                    Hapus
                                                </a>
                                            </div>
                                        </div>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }

        $units = Unit::select(['id', 'name'])
                    ->where('year_id', session('selected_year_id'))
                    ->orderBy('name', 'asc')
                    ->get();

        return view('mou.index', compact('units'));
    }

    public function calculation(Request $request)
    {
        $mous = Mou::select(['pks_contract_value', 'nominal_difference', 'bank_transfer_proceeds'])
                        ->where('year_id', session('selected_year_id'));

        if ($request->filled('unit_id') && $request->unit_id != 0) {
            $mous->where('unit_id', $request->unit_id);
        }

        if ($request->filled('regarding_letters')) {
            $mous->where('regarding_letters', 'like', '%' . $request->regarding_letters . '%');
        }

        if ($request->filled('letter_number')) {
            $mous->where('letter_number', 'like', '%' . $request->letter_number . '%');
        }

        if ($request->filled('letter_receipt_date')) {
            $mous->where('letter_receipt_date', $request->letter_receipt_date);
        }

        $total_data             = $mous->count();
        $pks_contract_value     = $mous->sum('pks_contract_value');
        $nominal_difference     = $mous->sum('nominal_difference');
        $bank_transfer_proceeds = $mous->sum('bank_transfer_proceeds');

        return response()->json([
            'status' => true,
            'message' => 'berhasil mendapatkan data',
            'data' => [
                'total_data'             => rupiah($total_data),
                'pks_contract_value'     => rupiah($pks_contract_value),
                'bank_transfer_proceeds' => rupiah($bank_transfer_proceeds),
                'nominal_difference'     => rupiah($nominal_difference)
            ]
        ]);
    }

    public function show(Mou $mou)
    {
        if (!$mou) {
            return response()->json(['status' => false, 'message' => 'not found'], 404);
        }

        $html = view('mou.show', compact('mou'))->render();

        return response()->json(['status' => true, 'message' => 'berhasil mendapatkan data MOU', 'data' => ['html' => $html]], 200);
    }

    public function exportPdf($id)
    {
        $mou = Mou::with(['unit', 'year'])->where('id', $id)->first();

        if (!$mou) {
            return abort(404);
        }

        $nomor_urut = Mou::select('created_at')->where('year_id', $mou->year_id)->where('created_at', '<', $mou->created_at)->withTrashed()->count() + 1;

        $mou->documents = MouFile::select(['document_type'])
                                ->where('mou_id', $mou->id)
                                ->get()
                                ->pluck('document_type')
                                ->toArray();

        $pdf = Pdf::loadView('mou.print', compact('mou', 'nomor_urut'));

        $filename = "MOU " . $mou->unit->name . " - " . Str::limit($mou->regarding_letters, 25, '') . ".pdf";

        return $pdf->download($filename);
    }

    public function downloadFile($file)
    {
        return response()->download(public_path('upload/mou/'.$file));
    }

    public function create()
    {
        $units = Unit::where('year_id', session('selected_year_id'))->orderBy('name', 'asc')->get();

        $is_form_create = true;

        $mou = new Mou();

        return view('mou.create-update', compact('units', 'is_form_create', 'mou'));
    }

    public function store(MouRequest $request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::id();

        $input['year_id'] = session('selected_year_id');

        foreach (['letter_receipt_date','mou_start','mou_end','pks_start','pks_end','document_start','document_end'] as $date_value) {
            if ($request->filled($date_value . '_display')) {
                $input[$date_value] = $input[$date_value . '_value'];

                unset($input[$date_value . '_value'], $input[$date_value . '_display']);
            }
        }

        $input['hardcopy_files'] = ($request->filled('hardcopy') && is_array($request->hardcopy)) ? array_keys($request->hardcopy) : [];

        $new_mou = Mou::create($input);

        if ($request->has('files') && count($input['files']) > 0) {
            foreach ($input['files'] as $type => $file) {
                $uploaded_file = $this->uploadFileV2($file);

                MouFile::create([
                    'mou_id'        => $new_mou->id,
                    'document_type' => $type,
                    'filename'      => $uploaded_file['name'],
                    'size'          => $uploaded_file['size']]
                );
            }
        }

        createLog("Create Data MOU | No. Surat $new_mou->letter_number");

        return redirect()->route('mou.index')->with('success', 'Data MOU berhasil ditambahkan');
    }

    private function uploadFileV2(UploadedFile $file)
    {
        $path = public_path('upload/mou');

        $name = rand(100,999) . '_' . trim($file->getClientOriginalName());

        $name = str_replace('&', 'dan', $name);

        $size = $file->getSize();

        $file->move($path, $name);

        return [
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
            'size' => $size
        ];
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

        $mou->documents = MouFile::select(['id','filename','document_type'])
                                ->where('mou_id', $mou->id)
                                ->get()
                                ->groupBy('document_type')
                                ->map(fn ($item) => $item->first())
                                ->toArray();

        $units = Unit::where('year_id', session('selected_year_id'))->orderBy('name', 'asc')->get();

        $is_form_create = false;

        return view('mou.create-update', compact('mou', 'units', 'is_form_create'));
    }

    public function update(MouRequest $request, Mou $mou)
    {
        if (!$mou) {
            return redirect()->route('mou.index');
        }

        $input = $request->all();

        $is_old_data = ($request->filled('is_old_data') && $request->is_old_data == '1') ? true : false;

        if ($is_old_data) { // jika yang diupdate adalah data lama
            foreach (DocumentEnum::names() as $item) {
                if (!$request->has('document_'.$item)) {
                    $input['document_'.$item] = 0;
                }
            }
        }

        foreach (['letter_receipt_date','mou_start','mou_end','pks_start','pks_end','document_start','document_end'] as $date_value) {
            if ($request->filled($date_value . '_display')) {
                $input[$date_value] = $input[$date_value . '_value'];

                unset($input[$date_value . '_value'], $input[$date_value . '_display']);
            }
        }

        $input['hardcopy_files'] = ($request->filled('hardcopy') && is_array($request->hardcopy)) ? array_keys($request->hardcopy) : [];

        $mou->update($input);

        if ($is_old_data)
        {
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
        }
        else
        {
            if ($request->has('files') && count($input['files']) > 0)
            {
                foreach ($input['files'] as $type => $file)
                {
                    $mou_file = MouFile::where('mou_id', $mou->id)->where('document_type', $type)->first();

                    // hapus old file jika ada
                    if ($mou_file) {
                        if (file_exists(public_path('upload/mou/' . $mou_file->filename))) {
                            unlink(public_path('upload/mou/' . $mou_file->filename));
                        }
                    }

                    $uploaded_file = $this->uploadFileV2($file);

                    if ($mou_file) {
                        $mou_file->update(['filename' => $uploaded_file['name'], 'size' => $uploaded_file['size']]);
                    } else {
                        MouFile::create([
                            'mou_id'        => $mou->id,
                            'document_type' => $type,
                            'filename'      => $uploaded_file['name'],
                            'size'          => $uploaded_file['size']]
                        );
                    }
                }
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

    public function export(Request $request)
    {
        $is_minimalis = ($request->filled('is_minimalis')) ? $request->get('is_minimalis') : false;

        $is_rekapitulasi = ($request->filled('is_rekapitulasi')) ? $request->get('is_rekapitulasi') : false;

        $year = Year::where('id', session('selected_year_id'))->first()->year;

        $type = (!$is_minimalis) ? 'LENGKAP' : ($is_rekapitulasi ? 'REKAPITULASI' : 'SINGKAT');

        $filename = "DATA $type MOU & PKS TAHUN $year.xlsx";

        $data = [
            'is_minimalis' => $is_minimalis,
            'is_rekapitulasi' => $is_rekapitulasi,
            'unit_id' => ($request->filled('unit_id') && $request->unit_id != 0) ? $request->unit_id : null,
            'regarding_letters' => ($request->filled('regarding_letters')) ? $request->regarding_letters : null,
            'letter_number' => ($request->filled('letter_number')) ? $request->letter_number : null,
            'letter_receipt_date' => ($request->filled('letter_receipt_date')) ? $request->letter_receipt_date : null,
        ];

        return Excel::download(new MouExport($data), $filename);
    }
}
