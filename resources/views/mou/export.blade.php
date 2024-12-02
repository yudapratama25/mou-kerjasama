<table>
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
            <td rowspan="2">NO.</td>
            <td rowspan="2">UNIT KERJA</td>
            <td rowspan="2">NO. SURAT</td>
            <td rowspan="2">TANGGAL TERIMA SURAT</td>
            <td rowspan="2">PERIHAL SURAT</td>
            <td rowspan="2">NO MOU</td>
            <td colspan="2">JANGKA WAKTU MOU</td>
            <td rowspan="2">STATUS MOU</td>
            <td rowspan="2">NO. PKS</td>
            <td colspan="2">JANGKA WAKTU PKS</td>
            <td rowspan="2">STATUS PKS</td>
            <td rowspan="2">NAMA KEGIATAN PKS</td>
            <td rowspan="2">NILAI KONTRAK DI PKS</td>
            <td rowspan="2">HASIL TRANSFER BANK</td>
            <td rowspan="2">SELISIH</td>
            <td rowspan="2">NAMA MITRA</td>
            <td colspan="2">NAMA DAN JABATAN PENANDATANGAN</td>
            <td colspan="9">KELENGKAPAN DOKUMEN</td>
            <td colspan="4">PARAF</td>
            <td rowspan="2">KETERANGAN</td>
        </tr>
        <tr>
            <td>MULAI</td>
            <td>BERAKHIR</td>
            <td>MULAI</td>
            <td>BERAKHIR</td>
            <td>PIHAK 1</td>
            <td>PIHAK 2</td>
            <td>P K S</td>
            <td>T O R</td>
            <td>R A B</td>
            <td>S P T J M</td>
            <td>M O U</td>
            <td>BUKTI TRANSFER BANK</td>
            <td>SK PENDIRIAN ULS</td>
            <td>SK PENGELOLA KERJASAMA</td>
            <td>SK IA</td>
            <td>SUB / KOOR KERJAMA</td>
            <td>PPK PNBP</td>
            <td>S P I</td>
            <td>BAGREN</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($mous as $mou)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mou->unit->name ?? '-' }}</td>
                <td>{{ $mou->letter_number }}</td>
                <td>{{ ($mou->letter_receipt_date != null) ? \Carbon\Carbon::parse($mou->letter_receipt_date)->format('d/m/Y') : '-' }}</td>
                <td>{{ $mou->regarding_letters }}</td>
                <td>{{ $mou->mou_number }}</td>
                <td>{{ ($mou->mou_start != null) ? \Carbon\Carbon::parse($mou->mou_start)->format('d/m/Y') : '-' }}</td>
                <td>{{ ($mou->mou_end != null) ? \Carbon\Carbon::parse($mou->mou_end)->format('d/m/Y') : '-' }}</td>
                <td>{{ $mou->mou_status }}</td>
                <td>{{ $mou->pks_number }}</td>
                <td>{{ ($mou->pks_start != null) ? \Carbon\Carbon::parse($mou->pks_start)->format('d/m/Y') : '-' }}</td>
                <td>{{ ($mou->pks_end != null) ? \Carbon\Carbon::parse($mou->pks_end)->format('d/m/Y') : '-' }}</td>
                <td>{{ $mou->pks_status }}</td>
                <td>{{ $mou->pks_regarding }}</td>
                <td>Rp {{ number_format($mou->pks_contract_value, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->bank_transfer_proceeds, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->nominal_difference, 0, ',', '.') }}</td>
                <td>{{ $mou->partner_name }}</td>
                <td>{{ $mou->signature_part_1 }}</td>
                <td>{{ $mou->signature_part_2 }}</td>
                <td>{{ ($mou->document_pks == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_tor == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_rab == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_sptjm == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_mou == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_bank_transfer_proceeds == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_sk_uls == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_sk_pengelola_kerjasama == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td>{{ ($mou->document_ia == 1) ? 'ADA' : 'TIDAK ADA' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $mou->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
