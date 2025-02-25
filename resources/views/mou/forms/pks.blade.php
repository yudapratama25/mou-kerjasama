<div class="form-group">
    <label class="text-dark font-weight-bold">Nomor PKS<span class="text-danger">*</span></label>
    <input type="text" name="pks_number" value="{{ $mou->pks_number ?? old('pks_number') }}" placeholder="Masukan nomor PKS" class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Tanggal PKS</label>

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Mulai</span>
        </div>

        @include('mou.forms.util.datepicker', ['field' => 'pks_start', 'placeholder' => 'Pilih tanggal mulai'])

        <div class="input-group-prepend">
            <span class="input-group-text">Berakhir</span>
        </div>

        @include('mou.forms.util.datepicker', ['field' => 'pks_end', 'placeholder' => 'Pilih tanggal berakhir'])
    </div>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Status PKS<span class="text-danger">*</span></label>
    <select name="pks_status" class="form-control" required>
        @foreach ($mou_pks_status as $status)
        <option value="{{ $status }}" @selected($mou->pks_status == $status || old('pks_status') == $status)>{{ $status }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Nama Kegiatan PKS<span class="text-danger">*</span></label>
    <textarea name="pks_regarding" class="form-control" placeholder="Masukan nama kegiatan" rows="3" required>{{ $mou->pks_regarding ?? old('pks_regarding') }}</textarea>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Nilai Kontrak (Rp)<span class="text-danger">*</span></label>
    <input type="text" name="pks_contract_value" value="{{ $mou->pks_contract_value ?? old('pks_contract_value') }}" placeholder="Masukan nominal" id="nilai-kontrak" onkeyup="ketikNominal(this)" class="form-control" required>
</div>
<div class="form-group">
    <label class="text-dark font-weight-bold">Hasil Transfer Bank (Rp)<span class="text-danger">*</span></label>
    <input type="text" name="bank_transfer_proceeds" value="{{ $mou->bank_transfer_proceeds ?? old('bank_transfer_proceeds') }}" placeholder="Masukan nominal" id="hasil-transfer-bank" onkeyup="ketikNominal(this)" class="form-control" required>
</div>
<div class="form-group">
    <label class="text-dark font-weight-bold">Selisih (Rp)</label>
    <input type="text" name="nominal_difference" value="{{ $mou->nominal_difference ?? old('nominal_difference') }}" id="selisih" class="form-control" readonly required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Penandatangan PKS Pihak 1<span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Nama</span>
        </div>
        <input type="text" name="signature_pks_part_1" value="{{ $mou->signature_pks_part_1 ?? old('signature_pks_part_1') }}" placeholder="Masukan nama pihak 1" class="form-control" required>

        <div class="input-group-prepend">
            <span class="input-group-text">Jabatan</span>
        </div>
        <input type="text" name="position_pks_part_1" value="{{ $mou->position_pks_part_1 ?? old('position_pks_part_1') }}" placeholder="Masukan jabatan pihak 1" class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Penandatangan PKS Pihak 2<span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Nama</span>
        </div>
        <input type="text" name="signature_pks_part_2" value="{{ $mou->signature_pks_part_2 ?? old('signature_pks_part_2') }}" placeholder="Masukan nama pihak 2" class="form-control" required>

        <div class="input-group-prepend">
            <span class="input-group-text">Jabatan</span>
        </div>
        <input type="text" name="position_pks_part_2" value="{{ $mou->position_pks_part_2 ?? old('position_pks_part_2') }}" placeholder="Masukan jabatan pihak 2" class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Kontak Pengelola Kegiatan<span class="text-danger">*</span></label>
    <input type="text" name="manager_contact" value="{{ $mou->manager_contact ?? old('manager_contact') }}" placeholder="Masukan kontak pengelola kegiatan" class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Kriteria Kerja Sama<span class="text-danger">*</span></label>
    <select name="cooperation_criteria" class="form-control" required>
        @foreach (['pemerintahan dalam negeri', 'pihak swasta dalam negeri', 'pemerintahan luar negeri', 'pihak swasta luar negeri'] as $item)
            <option value="{{ ucwords($item) }}" @selected($mou->cooperation_criteria == ucwords($item) || old('cooperation_criteria') == ucwords($item))>
                {{ ucwords($item) }}
            </option>
        @endforeach
    </select>
</div>
