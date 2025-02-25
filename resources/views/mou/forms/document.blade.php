@php
    $is_old_data = false;
@endphp

@if ($is_old_data)

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
    @foreach (['pks', 'tor', 'rab', 'sptjm', 'mou', 'bank_transfer_proceeds', 'sk_uls', 'sk_pengelola_kerjasama', 'ia'] as $item)
        <div class="col">
            <div class="custom-control custom-checkbox small">
                <input
                    type="checkbox"
                    name="document_{{ $item }}"
                    class="custom-control-input"
                    id="kd-{{ $item }}"
                    value="1" @checked(old('document_'.$item) == 1)>
                <label class="custom-control-label" for="kd-{{ $item }}">
                    @if ($item == "bank_transfer_proceeds")
                        Bukti Transfer Bank
                    @elseif ($item == "ia")
                        Implementation of Agreement (IA)
                    @elseif ($item == "sk_uls")
                        SK Pendirian ULS
                    @elseif ($item == "sk_pengelola_kerjasama")
                        SK Pengelola Kerjasama
                    @else
                        {{ strtoupper($item) }}
                    @endif
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
        </tr>
        @endforeach
    </tbody>
</table>

@endif
