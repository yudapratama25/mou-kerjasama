@php
    $total_mou = 0;
    $grand_total_pks_contract_value = 0;
    $grand_total_bank_transfer_proceeds = 0;
    $grand_total_nominal_difference = 0;
@endphp

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
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="6">
                <p style="text-align: center;font-weight: bold;font-size: 24px;">
                    REKAPITULASI PKS PERIODE {{ $periode }}<br/>
                    BAGIAN KERJA SAMA
                </p>
            </td>
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
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>NO.</td>
            <td>UNIT KERJA</td>
            <td>JUMLAH PKS</td>
            <td>TOTAL NILAI KONTRAK</td>
            <td>TOTAL HASIL TRANSFER BANK</td>
            <td>TOTAL SELISIH</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($mous as $mou)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mou->unit->name ?? '-' }}</td>
                <td>{{ $mou->count_mou }}</td>
                <td>Rp {{ number_format($mou->total_pks_contract_value, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->total_bank_transfer_proceeds, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($mou->total_nominal_difference, 0, ',', '.') }}</td>
            </tr>

            @php
                $total_mou += $mou->count_mou;
                $grand_total_pks_contract_value += $mou->total_pks_contract_value;
                $grand_total_bank_transfer_proceeds += $mou->total_bank_transfer_proceeds;
                $grand_total_nominal_difference += $mou->total_nominal_difference;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2">
                TOTAL
            </td>
            <td>{{ $total_mou }}</td>
            <td>Rp {{ number_format($grand_total_pks_contract_value, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($grand_total_bank_transfer_proceeds, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($grand_total_nominal_difference, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
