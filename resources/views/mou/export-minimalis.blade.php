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
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>NO.</td>
            <td>UNIT KERJA</td>
            <td>NO. PKS</td>
            <td>NAMA KEGIATAN PKS</td>
            <td>NILAI KONTRAK DI PKS</td>
            <td>HASIL TRANSFER BANK</td>
            <td>SELISIH</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($mous as $mou)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mou->unit->name ?? '-' }}</td>
                <td>{{ $mou->pks_number }}</td>
                <td>{{ $mou->pks_regarding }}</td>
                <td>Rp {{ number_format($mou->pks_contract_value, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->bank_transfer_proceeds, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->nominal_difference, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
