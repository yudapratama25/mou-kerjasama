@extends('layout.master')

@section('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.css" type="text/css"/>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Data MOU & PKS</h1>
    <p>Edit Data</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit MOU & PKS</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('mou.update', $mou->id) }}" method="post" enctype="multipart/form-data" id="form-mou">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="font-weight-bold">Validasi Gagal</h5>
                        <ul class="mb-0 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Unit Kerja<span class="text-danger">*</span></label>
                        <select name="unit_id" class="form-control" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected($mou->unit_id == $unit->id)>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Nomor Surat<span class="text-danger">*</span></label>
                        <input type="text" name="letter_number" value="{{ $mou->letter_number }}" class="form-control" placeholder="Masukan nomor surat" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Tanggal Terima Surat</label>
                        <input type="text" name="letter_receipt_date_display" value="{{ \Carbon\Carbon::parse($mou->letter_receipt_date)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="letter_receipt_date_value" value="{{ $mou->letter_receipt_date }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-bold">Perihal Surat<span class="text-danger">*</span></label>
                    <textarea name="regarding_letters" class="form-control" placeholder="Masukan perihal surat" rows="5" required>{{ $mou->regarding_letters }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Nomor MOU<span class="text-danger">*</span></label>
                        <input type="text" name="mou_number" value="{{ $mou->mou_number }}" placeholder="Masukan nomor MOU" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Tanggal Mulai MOU</label>
                        <input type="text" name="mou_start_display" value="{{ \Carbon\Carbon::parse($mou->mou_start)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="mou_start_value" value="{{ $mou->mou_start }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Tanggal Berakhir MOU</label>
                        <input type="text" name="mou_end_display" value="{{ \Carbon\Carbon::parse($mou->mou_end)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="mou_end_value" value="{{ $mou->mou_end }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Status MOU<span class="text-danger">*</span></label>
                        <select name="mou_status" class="form-control" required>
                            <option disabled>-</option>
                            <option value="HIDUP" @selected($mou->mou_status == "HIDUP")>Hidup</option>
                            <option value="MATI" @selected($mou->mou_status == "MATI")>Mati</option>
                            <option value="DALAM PERPANJANGAN" @selected($mou->mou_status == "DALAM PERPANJANGAN")>Dalam Perpanjangan</option>
                            <option value="TIDAK ADA" @selected($mou->mou_status == "TIDAK ADA")>Tidak Ada</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Nomor PKS<span class="text-danger">*</span></label>
                        <input type="text" name="pks_number" value="{{ $mou->pks_number }}" placeholder="Masukan nomor PKS" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Tanggal Mulai PKS</label>
                        <input type="text" name="pks_start_display" value="{{ \Carbon\Carbon::parse($mou->pks_start)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="pks_start_value" value="{{ $mou->pks_start }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Tanggal Berakhir PKS</label>
                        <input type="text" name="pks_end_display" value="{{ \Carbon\Carbon::parse($mou->pks_end)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="pks_end_value" value="{{ $mou->pks_end }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark font-weight-bold">Status PKS<span class="text-danger">*</span></label>
                        <select name="pks_status" class="form-control" required>
                            <option disabled>-</option>
                            <option value="HIDUP" @selected($mou->pks_status == "HIDUP")>Hidup</option>
                            <option value="MATI" @selected($mou->pks_status == "MATI")>Mati</option>
                            <option value="DALAM PERPANJANGAN" @selected($mou->pks_status == "DALAM PERPANJANGAN")>Dalam Perpanjangan</option>
                            <option value="TIDAK ADA" @selected($mou->pks_status == "TIDAK ADA")>Tidak Ada</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="form-row">
                    <div class="form-group col">
                        <label class="text-dark font-weight-bold">Nama Dokumen</label>
                        <input type="text" name="document_name" value="{{ $mou->document_name }}" placeholder="Masukan nama dokumen" class="form-control">
                    </div>
                    <div class="form-group col">
                        <label class="text-dark font-weight-bold">Nomor Dokumen</label>
                        <input type="text" name="document_number" value="{{ $mou->document_number }}" placeholder="Masukan nomor dokumen" class="form-control">
                    </div>
                    <div class="form-group col">
                        <label class="text-dark font-weight-bold">Tanggal Mulai Dokumen</label>
                        <input type="text" name="document_start_display" value="{{ \Carbon\Carbon::parse($mou->document_start)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="document_start_value" value="{{ $mou->document_start }}">
                    </div>
                    <div class="form-group col">
                        <label class="text-dark font-weight-bold">Tanggal Berakhir Dokumen</label>
                        <input type="text" name="document_end_display" value="{{ \Carbon\Carbon::parse($mou->document_end)->isoFormat('D MMMM Y') }}" placeholder="Pilih tanggal" class="form-control datepicker">
                        <input type="hidden" name="document_end_value" value="{{ $mou->document_end }}">
                    </div>
                    <div class="form-group col">
                        <label class="text-dark font-weight-bold">Status Dokumen</label>
                        <select name="document_status" class="form-control">
                            <option disabled>-</option>
                            <option value="HIDUP" @selected($mou->document_status == "HIDUP")>Hidup</option>
                            <option value="MATI" @selected($mou->document_status == "MATI")>Mati</option>
                            <option value="DALAM PERPANJANGAN" @selected($mou->document_status == "DALAM PERPANJANGAN")>Dalam Perpanjangan</option>
                            <option value="TIDAK ADA" @selected($mou->document_status == "TIDAK ADA")>Tidak Ada</option>
                        </select>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label class="text-dark font-weight-bold">Nama Kegiatan PKS<span class="text-danger">*</span></label>
                    <textarea name="pks_regarding" class="form-control" placeholder="Masukan nama kegiatan" rows="5" required>{{ $mou->pks_regarding }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Nilai Kontrak (Rp)<span class="text-danger">*</span></label>
                        <input type="text" name="pks_contract_value" value="{{ $mou->pks_contract_value }}" placeholder="Masukan nominal" id="nilai-kontrak" onkeyup="ketikNominal(this)" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Hasil Transfer Bank (Rp)<span class="text-danger">*</span></label>
                        <input type="text" name="bank_transfer_proceeds" value="{{ $mou->bank_transfer_proceeds }}" placeholder="Masukan nominal" id="hasil-transfer-bank" onkeyup="ketikNominal(this)" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="text-dark font-weight-bold">Selisih (Rp)</label>
                        <input type="text" name="nominal_difference" value="{{ $mou->nominal_difference }}" id="selisih" class="form-control" readonly required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="text-dark font-weight-bold">Nama Mitra<span class="text-danger">*</span></label>
                    <input type="text" name="partner_name" value="{{ $mou->partner_name }}" placeholder="Masukan nama mitra" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Nama Penandatangan MOU Pihak 1<span class="text-danger">*</span></label>
                        <input type="text" name="signature_mou_part_1" value="{{ $mou->signature_mou_part_1 }}" placeholder="Masukan nama penandatangan MOU pihak 1" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Jabatan Penandatangan MOU Pihak 1<span class="text-danger">*</span></label>
                        <input type="text" name="position_mou_part_1" value="{{ $mou->position_mou_part_1 }}" placeholder="Masukan jabatan penandatangan MOU pihak 1" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Nama Penandatangan MOU Pihak 2<span class="text-danger">*</span></label>
                        <input type="text" name="signature_mou_part_2" value="{{ $mou->signature_mou_part_2 }}" placeholder="Masukan nama penandatangan MOU pihak 2" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Jabatan Penandatangan MOU Pihak 2<span class="text-danger">*</span></label>
                        <input type="text" name="position_mou_part_2" value="{{ $mou->position_mou_part_2 }}" placeholder="Masukan jabatan penandatangan MOU pihak 2" class="form-control" required>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Nama Penandatangan PKS Pihak 1<span class="text-danger">*</span></label>
                        <input type="text" name="signature_pks_part_1" value="{{ $mou->signature_pks_part_1 }}" placeholder="Masukan nama penandatangan PKS pihak 1" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Jabatan Penandatangan PKS Pihak 1<span class="text-danger">*</span></label>
                        <input type="text" name="position_pks_part_1" value="{{ $mou->position_pks_part_1 }}" placeholder="Masukan jabatan penandatangan PKS pihak 1" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Nama Penandatangan PKS Pihak 2<span class="text-danger">*</span></label>
                        <input type="text" name="signature_pks_part_2" value="{{ $mou->signature_pks_part_2 }}" placeholder="Masukan nama penandatangan PKS pihak 2" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Jabatan Penandatangan PKS Pihak 2<span class="text-danger">*</span></label>
                        <input type="text" name="position_pks_part_2" value="{{ $mou->position_pks_part_2 }}" placeholder="Masukan jabatan penandatangan PKS pihak 2" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Kontak Pengelola Kegiatan<span class="text-danger">*</span></label>
                        <input type="text" name="manager_contact" value="{{ $mou->manager_contact }}" placeholder="Masukan kontak pengelola kegiatan" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark font-weight-bold">Kriteria Kerja Sama<span class="text-danger">*</span></label>
                        <select name="cooperation_criteria" class="form-control" required>
                            @foreach (['pemerintahan dalam negeri', 'pihak swasta dalam negeri', 'pemerintahan luar negeri', 'pihak swasta luar negeri'] as $item)
                                <option value="{{ ucwords($item) }}" @selected($mou->cooperation_criteria == ucwords($item))>
                                    {{ ucwords($item) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-bold">Keterangan</label>
                    <textarea name="description" class="form-control" placeholder="Masukan keterangan" rows="5">{{ $mou->description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-bold">Upload File Kelengkapan Dokumen</label>
                    
                    <div class="dropzone dropzone-default dropzone-primary">
						<div class="dropzone-msg dz-message needsclick">
						    <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
						    <span class="dropzone-msg-desc">Upload up to 10 files</span>
						</div>
					</div>
                </div>
                
                <div class="form-group">
                    <label class="text-dark font-weight-bold">Kelengkapan Dokumen</label>
                    <div class="row row-cols-2 w-50">
                    @foreach (['pks', 'tor', 'rab', 'sptjm', 'mou', 'bank_transfer_proceeds'] as $item)
                        <div class="col">
                            <div class="custom-control custom-checkbox small">
                                <input 
                                    type="checkbox" 
                                    name="document_{{ $item }}" 
                                    class="custom-control-input" 
                                    id="kd-{{ $item }}" 
                                    value="1" @checked($mou->{'document_'.$item} == 1)>
                                <label class="custom-control-label" for="kd-{{ $item }}">
                                    @if ($item == "bank_transfer_proceeds")
                                        Bukti Transfer Bank
                                    @else
                                        {{ strtoupper($item) }}
                                    @endif
                                </label>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <hr>
                <p>
                    (<span class="text-danger">*</span>) Wajib Diisi
                </p>

                <button class="btn btn-primary" type="button" id="btn-submit">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;
    const nilaiKontrak = document.getElementById('nilai-kontrak');    
    const tfBank = document.getElementById('hasil-transfer-bank');   
    const selisih = document.getElementById('selisih');

    $(function() {
        @foreach (['letter_receipt_date','mou_start','mou_end','pks_start','pks_end','document_start','document_end'] as $value)
            $(`input[name={{ $value }}_display]`).datepicker({
                dateFormat: "d MM yy",
                altFormat: "yy-mm-dd",
                altField: `input[name={{ $value }}_value]`,
                dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ],
                monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
            });
        @endforeach

        ketikNominal(nilaiKontrak);
        ketikNominal(tfBank);
    });

    async function ketikNominal(e) {
        if (nilaiKontrak.value != "" && tfBank.value != "") {
            let nk = parseInt(nilaiKontrak.value.split('.').join(""));
            let tf = parseInt(tfBank.value.split('.').join(""));

            let sel =  nk - tf;
            let minus = (sel < 0) ? true : false;
            selisih.value = formatRupiah(sel.toString(), minus);
        } else {
            selisih.value = "";
        }

        e.value = await formatRupiah(e.value);
    }

    function formatRupiah(angka, minus = false) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? (minus) ? '-' + rupiah : rupiah : "";
    }

    var myDropZone = new Dropzone('.dropzone', {
        url: `{{ route('mou.uploadFile') }}`, // Set the url for your upload script location
        acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx",
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 10,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        autoQueue: false,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response){
            if (response.status == true) {
                $("#form-mou").append(`<input type="hidden" name="files['${response.data.uniq}']" value="${response.data.name}" required>`);
                $("#form-mou").append(`<input type="hidden" name="files_size['${response.data.uniq}']" value="${response.data.size}" required>`);
            }
        },
        removedfile: function (file) {
            if (this.options.dictRemoveFile) {
                return Dropzone.confirm("Are You Sure to "+this.options.dictRemoveFile, function() {
                    if (file.previewElement.id != "") {
                        var name = file.previewElement.id;
                    } else {
                        var name = file.name;
                    }

                    console.log(file.previewElement);
                
                    $('#form-mou').find('input[value="' + file.name + '"]').remove();

                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
                });
            }
        },
        init: function() {
            @foreach ($mou->files as $indexFile => $file)
                var file_{{ $indexFile }} = {name: `{{ $file->filename }}`, size: {{ $file->size }}};
                this.options.addedfile.call(this, file_{{ $indexFile }});
                // this.options.thumbnail.call(this, file_{{ $indexFile }}, `{{ asset('upload/mou/'.$file->filename) }}`);
                file_{{ $indexFile }}.previewElement.classList.add('dz-complete');
                $("#form-mou").append(`<input type="hidden" name="files['{{  $indexFile }}']" value="{{ $file->filename }}" required>`);

                @if ($loop->last)
                    this.emit("complete", file_{{ $indexFile }});
                @endif
            @endforeach
        },
        
    });

    $('#btn-submit').click(submitForm);

    function uploadFile(file, index) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                myDropZone.processFile(file);
                resolve();
            }, 500);
        });
    }

    async function submitForm() {
        var Form = document.getElementById('form-mou');
        if (Form.checkValidity() == false) {
            var list = Form.querySelectorAll(':invalid');
            for (var item of list) {
                item.focus();
                return false;
            }
        }
        console.log('submit form');
        Swal.fire({
            title: 'Mohon tunggu',
            text: 'Data sedang diproses',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        const acceptedFiles = myDropZone.getAcceptedFiles();
        console.log(acceptedFiles.length);
        if (acceptedFiles.length > 0) {
            console.log('upload file');
            for (let i = 0; i < acceptedFiles.length; i++) {
                console.log('file ke-'+(i+1));
                await uploadFile(acceptedFiles[i], i);
            }
        }
        console.log('duarrrr');
        setTimeout(() => {
            $('#form-mou').submit();
        }, 1100);
        Swal.close();
    }
</script>
@endsection