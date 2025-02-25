<div class="form-group">
    <label class="text-dark font-weight-bold">Unit Kerja<span class="text-danger">*</span></label>
    <select name="unit_id" class="form-control" required>
        @if ($is_form_create)
            <option {{ (old('unit_id') == "") ? 'selected' : null }} disabled>Pilih unit kerja</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>{{ $unit->name }}</option>
            @endforeach
        @else
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" @selected($mou->unit_id == $unit->id)>{{ $unit->name }}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Nomor Surat<span class="text-danger">*</span></label>
    <input type="text" name="letter_number" value="{{ $mou->letter_number ?? old('letter_number') }}" class="form-control" placeholder="Masukan nomor surat" required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Tanggal Terima Surat</label>

    @include('mou.forms.util.datepicker', ['field' => 'letter_receipt_date'])
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Nama Mitra<span class="text-danger">*</span></label>
    <input type="text" name="partner_name" value="{{ $mou->partner_name ?? old('partner_name') }}" placeholder="Masukan nama mitra" class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Perihal Surat<span class="text-danger">*</span></label>
    <textarea name="regarding_letters" class="form-control" placeholder="Masukan perihal surat" rows="5" required>{{ $mou->regarding_letters ?? old('regarding_letters') }}</textarea>
</div>

<div class="form-group">
    <label class="text-dark font-weight-bold">Keterangan / Catatan</label>
    <textarea name="description" class="form-control" placeholder="Masukan keterangan" rows="5">{{ $mou->description ?? old('description') }}</textarea>
</div>
