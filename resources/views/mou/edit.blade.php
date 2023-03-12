@extends('layout.master')

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css' integrity='sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==' crossorigin='anonymous'/>
<style>
    .dropify-wrapper .dropify-message p {
        font-size: .3em;
    }
</style>
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
            <form action="{{ route('mou.update', $mou->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6>Validasi Gagal</h6>
                        <ul class="mb-0 pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Unit Kerja</label>
                        <select name="unit_id" class="form-control" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected($mou->unit_id == $unit->id)>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nomor Surat</label>
                        <input type="text" name="letter_number" value="{{ $mou->letter_number }}" class="form-control" placeholder="Masukan nomor surat" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tanggal Terima Surat</label>
                        <input type="text" name="letter_receipt_date" value="{{ $mou->letter_receipt_date }}" placeholder="Pilih tanggal" class="form-control datepicker" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Perihal Surat</label>
                    <textarea name="regarding_letters" class="form-control" placeholder="Masukan perihal surat" rows="5" required>{{ $mou->regarding_letters }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Nomor MOU</label>
                        <input type="text" name="mou_number" value="{{ $mou->mou_number }}" placeholder="Masukan nomor MOU" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Mulai MOU</label>
                        <input type="text" name="mou_start" value="{{ $mou->mou_start }}" placeholder="Pilih tanggal" class="form-control datepicker" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Berakhir MOU</label>
                        <input type="text" name="mou_end" value="{{ $mou->mou_end }}" placeholder="Pilih tanggal" class="form-control datepicker" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Status MOU</label>
                        <select name="mou_status" class="form-control" required>
                            <option disabled>-</option>
                            <option value="HIDUP" @selected($mou->mou_status == "HIDUP")>HIDUP</option>
                            <option value="MATI" @selected($mou->mou_status == "MATI")>MATI</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Nomor PKS</label>
                        <input type="text" name="pks_number" value="{{ $mou->pks_number }}" placeholder="Masukan nomor PKS" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Mulai PKS</label>
                        <input type="text" name="pks_start" value="{{ $mou->pks_start }}" placeholder="Pilih tanggal" class="form-control datepicker" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Berakhir PKS</label>
                        <input type="text" name="pks_end" value="{{ $mou->pks_end }}" placeholder="Pilih tanggal" class="form-control datepicker" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Status PKS</label>
                        <select name="pks_status" class="form-control" required>
                            <option disabled>-</option>
                            <option value="HIDUP" @selected($mou->pks_status == "HIDUP")>HIDUP</option>
                            <option value="MATI" @selected($mou->pks_status == "MATI")>MATI</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Kegiatan PKS</label>
                    <textarea name="pks_regarding" class="form-control" placeholder="Masukan nama kegiatan PKS" rows="5" required>{{ $mou->pks_regarding }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Nilai Kontrak Di PKS (Rp)</label>
                        <input type="text" name="pks_contract_value" value="{{ $mou->pks_contract_value }}" placeholder="Masukan nominal" id="nilai-kontrak" onkeyup="ketikNominal(this)" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Hasil Transfer Bank (Rp)</label>
                        <input type="text" name="bank_transfer_proceeds" value="{{ $mou->bank_transfer_proceeds }}" placeholder="Masukan nominal" id="hasil-transfer-bank" onkeyup="ketikNominal(this)" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Selisih (Rp)</label>
                        <input type="text" name="nominal_difference" value="{{ $mou->nominal_difference }}" id="selisih" class="form-control" readonly required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Nama Mitra</label>
                        <input type="text" name="partner_name" value="{{ $mou->partner_name }}" placeholder="Masukan nama mitra" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nama Penandatangan Pihak 1</label>
                        <input type="text" name="signature_part_1" value="{{ $mou->signature_part_1 }}" placeholder="Masukan nama pihak 1" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Nama Penandatangan Pihak 2</label>
                        <input type="text" name="signature_part_2" value="{{ $mou->signature_part_2 }}" placeholder="Masukan nama pihak 2" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="description" class="form-control" placeholder="Masukan keterangan" rows="5">{{ $mou->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Upload File MOU</label>
                    <input 
                        type="file" 
                        name="mou_file" 
                        class="dropify" 
                        data-show-remove="false" 
                        data-height="100" @if($mou->mou_file != null) data-default-file="{{ asset('upload/mou/'.$mou->mou_file) }}" @endif>
                </div>
                
                <div class="form-group">
                    <label>Kelengkapan Dokumen</label>
                    <div class="row row-cols-2 w-50">
                    @foreach (['pks', 'tor', 'rab', 'sptjm', 'bank_transfer_proceeds'] as $item)
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

                <button class="btn btn-primary" type="submit">
                    Submit
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js' integrity='sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==' crossorigin='anonymous'></script>
<script>
    const nilaiKontrak = document.getElementById('nilai-kontrak');    
    const tfBank = document.getElementById('hasil-transfer-bank');   
    const selisih = document.getElementById('selisih');

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ],
            monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
        });

        $('.dropify').dropify();

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
        console.log(angka);
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
</script>
@endsection