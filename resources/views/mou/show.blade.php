<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <strong>Unit Kerja</strong> <br/>
        {{ $mou->unit->name ?? '-' }}
    </li>
    <li class="list-group-item">
        <strong>Nomor Surat</strong> <br/>
        {{ $mou->letter_number }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Terima Surat</strong> <br/>
        {{ ($mou->letter_receipt_date != null) ? \Carbon\Carbon::parse($mou->letter_receipt_date)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Perihal Surat</strong> <br/>
        {{ $mou->regarding_letters }}
    </li>
    <li class="list-group-item">
        <strong>Nomor MOU</strong> <br/>
        {{ $mou->mou_number }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Mulai MOU</strong> <br/>
        {{ ($mou->mou_start != null) ? \Carbon\Carbon::parse($mou->mou_start)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Berakhir MOU</strong> <br/>
        {{ ($mou->mou_end != null) ? \Carbon\Carbon::parse($mou->mou_end)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Status MOU</strong> <br/>
        {{ $mou->mou_status }}
    </li>
    <li class="list-group-item">
        <strong>Nomor PKS</strong> <br/>
        {{ $mou->pks_number }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Mulai PKS</strong> <br/>
        {{ ($mou->pks_start != null) ? \Carbon\Carbon::parse($mou->pks_start)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Berakhir PKS</strong> <br/>
        {{ ($mou->pks_end != null) ? \Carbon\Carbon::parse($mou->pks_end)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Status PKS</strong> <br/>
        {{ $mou->pks_status }}
    </li>
    
    <li class="list-group-item">
        <strong>Nama Dokumen</strong> <br/>
        {{ $mou->document_name ?? '-' }}
    </li>
    <li class="list-group-item">
        <strong>Nomor Dokumen</strong> <br/>
        {{ $mou->document_number ?? '-' }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Mulai Dokumen</strong> <br/>
        {{ ($mou->document_start != null) ? \Carbon\Carbon::parse($mou->document_start)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Tanggal Berakhir Dokumen</strong> <br/>
        {{ ($mou->document_end != null) ? \Carbon\Carbon::parse($mou->document_end)->isoFormat('DD MMMM Y') : '-' }}
    </li>
    <li class="list-group-item">
        <strong>Status Dokumen</strong> <br/>
        {{ $mou->document_status ?? '-' }}
    </li>

    <li class="list-group-item">
        <strong>Nama Kegiatan</strong> <br/>
        {{ $mou->pks_regarding }}
    </li>
    <li class="list-group-item">
        <strong>Nilai Kontrak</strong> <br/>
        Rp {{ number_format($mou->pks_contract_value, 0, ',', '.') }}
    </li>
    <li class="list-group-item">
        <strong>Hasil Transfer Bank</strong> <br/>
        Rp {{ number_format($mou->bank_transfer_proceeds, 0, ',', '.') }}
    </li>
    <li class="list-group-item">
        <strong>Selisih</strong> <br/>
        Rp {{ number_format($mou->nominal_difference, 0, ',', '.') }}
    </li>
    <li class="list-group-item">
        <strong>Nama Mitra</strong> <br/>
        {{ $mou->partner_name }}
    </li>
    <li class="list-group-item">
        <strong>Penandatangan Pihak 1</strong> <br/>
        {{ $mou->signature_part_1 }}
    </li>
    <li class="list-group-item">
        <strong>Penandatangan Pihak 2</strong> <br/>
        {{ $mou->signature_part_2 }}
    </li>
    <li class="list-group-item">
        <strong>Kriteria Kerja Sama</strong> <br/>
        {{ $mou->cooperation_criteria ?? '-' }}
    </li>
    <li class="list-group-item">
        <strong>Keterangan</strong> <br/>
        {{ $mou->description ?? '-' }}
    </li>
    <li class="list-group-item">
        <strong>Kelengkapan Dokumen</strong> <br/>
        @foreach (['pks', 'tor', 'rab', 'sptjm', 'mou', 'bank_transfer_proceeds'] as $item)
        <span class="{{ ($mou->{'document_'.$item} == 1) ? 'text-success' : 'text-danger' }}">
            @if ($item == "bank_transfer_proceeds")
                Bukti Transfer Bank
            @else
                {{ strtoupper($item) }}
            @endif
        </span>
        @if (!$loop->last)
            -
        @endif
        @endforeach
    </li>
    <li class="list-group-item">
        <strong>File Kelengkapan Dokumen</strong> <br/>
        <ul class="pl-3">
            @forelse ($mou->files as $file)
                <li>
                    <a href="{{ route('mou.download-file', $file->filename) }}">
                        {{ $file->filename }}
                    </a>
                </li>
            @empty
                <li>
                    Tidak Ada
                </li>
            @endforelse
        </ul>
    </li>
    <li class="list-group-item">
        <strong>Ditambahkan Oleh</strong><br/>
        {{ $mou->user->name }} / {{ $mou->created_at }}
    </li>
</ul>