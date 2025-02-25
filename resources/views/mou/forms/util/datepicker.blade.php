<input type="text" name="{{ $field }}_display" value="{{ ($mou->$field) ? \Carbon\Carbon::parse($mou->$field)->isoFormat('D MMMM Y') : old($field.'_display') }}" placeholder="{{ $placeholder ?? 'Pilih tanggal' }}" class="form-control datepicker">
<input type="hidden" name="{{ $field }}_value" value="{{ $mou->$field ?? old($field.'_value') }}">
