<div class="form-group">
    <label class="text-dark font-weight-bold">Nomor MOU<span class="text-danger">*</span></label>
    <input type="text" name="mou_number" value="{{ $mou->mou_number ?? old('mou_number') }}" placeholder="Masukan nomor MOU" class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Tanggal MOU</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Mulai</span>
        </div>

        @include('mou.forms.util.datepicker', ['field' => 'mou_start', 'placeholder' => 'Pilih tanggal mulai'])

        <div class="input-group-prepend">
            <span class="input-group-text">Berakhir</span>
        </div>

        @include('mou.forms.util.datepicker', ['field' => 'mou_end', 'placeholder' => 'Pilih tanggal berakhir'])
    </div>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Status MOU<span class="text-danger">*</span></label>
    <select name="mou_status" class="form-control" required>
        @foreach ($mou_pks_status as $status)
        <option value="{{ $status }}" @selected($mou->mou_status == $status || old('mou_status') == $status)>{{ $status }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Penandatangan MOU Pihak 1<span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Nama</span>
        </div>
        <input type="text" name="signature_mou_part_1" value="{{ $mou->signature_mou_part_1 ?? old('signature_mou_part_1') }}" placeholder="Masukan nama pihak 1" class="form-control" required>
        <div class="input-group-prepend">
            <span class="input-group-text">Jabatan</span>
        </div>
        <input type="text" name="position_mou_part_1" value="{{ $mou->position_mou_part_1 ?? old('position_mou_part_1') }}" placeholder="Masukan jabatan pihak 1" class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Penandatangan MOU Pihak 2<span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Nama</span>
        </div>
        <input type="text" name="signature_mou_part_2" value="{{ $mou->signature_mou_part_2 ?? old('signature_mou_part_2') }}" placeholder="Masukan nama pihak 2" class="form-control" required>
        <div class="input-group-prepend">
            <span class="input-group-text">Jabatan</span>
        </div>
        <input type="text" name="position_mou_part_2" value="{{ $mou->position_mou_part_2 ?? old('position_mou_part_2') }}" placeholder="Masukan jabatan pihak 2" class="form-control" required>
    </div>
</div>
