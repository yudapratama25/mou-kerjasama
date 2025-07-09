@php
    $is_old_data = ($mou->created_at != null) ? (\Carbon\Carbon::parse($mou->created_at)->lessThan(\Carbon\Carbon::parse('2025-03-04'))) : false;
@endphp

<input type="hidden" name="is_old_data" id="is-old-data" value="{{ $is_old_data ? 1 : 0 }}" required>

@if ($is_old_data && $is_form_create == false)
    <div class="form-group">
        <label class="text-dark font-weight-bold">Upload File Kelengkapan Dokumen</label>

        <input type="hidden" name="old_files" id="old-files" value="{{ json_encode($mou->files) }}">

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
        @foreach (\App\Enums\DocumentEnum::array() as $key => $item)
            <div class="col">
                <div class="custom-control custom-checkbox small">
                    <input
                        type="checkbox"
                        name="document_{{ $key }}"
                        class="custom-control-input"
                        id="kd-{{ $key }}"
                        value="1" @checked($mou->{'document_'.$key} == 1)>
                    <label class="custom-control-label" for="kd-{{ $key }}">
                        {{ $item }}
                    </label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@else
    <h6 class="font-weight-bold">Perhatian:</h6>
    <ul class="pl-3">
        <li>Ekstensi file yang diperbolehkan: pdf, jpg, jpeg, png, doc, docx, xls, xlsx, ppt, pptx</li>
        <li>Ukuran tiap file maksimal 10 MB</li>
    </ul>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Dokumen</th>
                @if (!$is_form_create)
                <th>Status</th>
                @endif
                <th>Unggah File</th>
                <th>Hardcopy</th>
            </tr>
        </thead>
        <tbody>

            @foreach (\App\Enums\DocumentEnum::array() as $key => $document)
            <tr>
                <td class="align-middle">
                    {{ $document }}
                </td>
                @if (!$is_form_create)
                <td class="align-middle">
                    <p class="m-0">
                        @if (isset($mou->documents[$key]))
                            Ada - <a href="{{ route('mou.download-file', $mou->documents[$key]['filename']) }}" target="_blank">Unduh File</a>
                        @else
                            Tidak Ada
                        @endif
                    </p>
                </td>
                @endif
                <td class="align-middle">
                    <div class="input-group">
                        <div class="form-input-file">
                            <input type="file" id="upload-file-{{ $key }}" aria-describedby="upload-file-{{ $key }}" name="files[{{ $key }}]">
                        </div>
                    </div>
                </td>
                <td class="align-middle">
                    <div class="custom-control custom-switch">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="hardcopy-{{ $key }}"
                            value="1"
                            name="hardcopy[{{ $key }}]" {{ (!$is_form_create && $mou->hardcopy_files !== NULL && in_array($key, $mou->hardcopy_files) ? 'checked' : '') }}>
                        <label class="custom-control-label" for="hardcopy-{{ $key }}" name="hardcopy[{{ $key }}]">Ada</label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
