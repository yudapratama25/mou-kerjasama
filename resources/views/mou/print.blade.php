<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        table {
            /* border-collapse: collapse; */
            width: 100% !important;
        }
        td {
            padding: 8px;
            text-align: left;
            vertical-align: baseline;
            /* border: 1px solid black; */
        }
        * {
            font-size: 11px;
        }

        caption {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .w-5 {
            width: 5% !important;
        }

        .w-20 {
            width: 20% !important;
        }
        
        .w-15 {
            width: 15% !important;
        }
    </style>
</head>
<body>
    <table>
        <caption>DATA DOKUMEN KERJASAMA</caption>
        <tbody>
            <tr>
                <td class=w-5>1</td>
                <td class="w-20">NO</td>
                <td class=w-5>:</td>
                <td></td>


                <td class=w-5></td>

                <td class=w-5>11</td>
                <td class="w-20">NO PKS</td>
                <td class=w-5>:</td>
                <td>{{ $mou['pks_number'] }}</td>
            </tr>
            <tr>
                <td class="w-5">2</td>
                <td class="w-20">UNIT KERJA</td>
                <td class=w-5>:</td>
                <td>{{ $mou['unit']['name'] }}</td>


                <td class=w-5></td>

                <td class=w-5>12</td>
                <td class="w-20">JANGKA WAKTU MULAI PKS</td>
                <td class=w-5>:</td>
                <td>{{ \Carbon\Carbon::parse($mou['pks_start'])->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="w-5">3</td>
                <td class="w-20">NO SURAT</td>
                <td class=w-5>:</td>
                <td>{{ $mou['letter_number'] }}</td>


                <td class=w-5></td>

                <td class=w-5>13</td>
                <td class="w-20">JANGKA WAKTU BERAKHIR PKS</td>
                <td class=w-5>:</td>
                <td>{{ \Carbon\Carbon::parse($mou['pks_end'])->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="w-5">4</td>
                <td>TANGGAL TERIMA SURAT</td>
                <td class=w-5>:</td>
                <td>{{ \Carbon\Carbon::parse($mou['letter_receipt_date'])->isoFormat('D MMMM Y') }}</td>


                <td class=w-5></td>

                <td class=w-5>14</td>
                <td class="w-20">STATUS PKS</td>
                <td class=w-5>:</td>
                <td>{{ $mou['mou_status'] }}</td>
            </tr>
            <tr>
                <td class="w-5">5</td>
                <td class="w-20">PERIHAL SURAT</td>
                <td class=w-5>:</td>
                <td>{{ $mou['regarding_letters'] }}</td>


                <td class=w-5></td>

                <td class=w-5>15</td>
                <td class="w-20">NAMA KEGIATAN PKS</td>
                <td class=w-5>:</td>
                <td>{{ $mou['pks_regarding'] }}</td>
            </tr>
            <tr>
                <td class="w-5">6</td>
                <td class="w-20">NO MOU</td>
                <td class=w-5>:</td>
                <td>{{ $mou['mou_number'] }}</td>


                <td class=w-5></td>

                <td class=w-5>16</td>
                <td class="w-20">NILAI KONTRAK DI PKS</td>
                <td class=w-5>:</td>
                <td>Rp {{ number_format($mou['pks_contract_value'], 0, '', '.') }}</td>
            </tr>
            <tr>
                <td class="w-5">7</td>
                <td class="w-20">JANGKA WAKTU MULAI MOU</td>
                <td class=w-5>:</td>
                <td>{{ \Carbon\Carbon::parse($mou['mou_start'])->isoFormat('D MMMM Y') }}</td>


                <td class=w-5></td>

                <td class=w-5>17</td>
                <td class="w-20">NILAI TRANSFER BANK</td>
                <td class=w-5>:</td>
                <td>Rp {{ number_format($mou['bank_transfer_proceeds'], 0, '', '.') }}</td>
            </tr>
            <tr>
                <td class="w-5">8</td>
                <td class="w-20">JANGKA WAKTU BERAKHIR MOU</td>
                <td class=w-5>:</td>
                <td>{{ \Carbon\Carbon::parse($mou['mou_end'])->isoFormat('D MMMM Y') }}</td>


                <td class=w-5></td>

                <td class=w-5>18</td>
                <td class="w-20">SELISIH NILAI</td>
                <td class=w-5>:</td>
                <td>Rp {{ number_format($mou['nominal_difference'], 0, '', '.') }}</td>
            </tr>
            <tr>
                <td class="w-5">9</td>
                <td class="w-20">STATUS MOU</td>
                <td class=w-5>:</td>
                <td>{{ $mou['mou_status'] }}</td>


                <td class=w-5></td>

                <td class=w-5>19</td>
                <td class="w-20">NAMA MITRA</td>
                <td class=w-5>:</td>
                <td>{{ $mou['partner_name'] }}</td>
            </tr>
            <tr>
                <td class=w-5>10</td>
                <td colspan="3">NAMA & JABATAN PENANDATANGAN MOU</td>

                <td class=w-5></td>

                <td>20</td>
                <td colspan="3">NAMA & JABATAN PENANDATANGAN PKS</td>
            </tr>
            <tr>
                <td></td>
                <td>NAMA (PIHAK I)</td>
                <td class=w-5>:</td>
                <td></td>


                <td class=w-5></td>

                <td></td>
                <td>NAMA (PIHAK I)</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">JABATAN (PIHAK I)</td>
                <td class=w-5>:</td>
                <td></td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">JABATAN (PIHAK I)</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">NAMA (PIHAK II)</td>
                <td class=w-5>:</td>
                <td></td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">NAMA (PIHAK II)</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">JABATAN (PIHAK II)</td>
                <td class=w-5>:</td>
                <td></td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">JABATAN (PIHAK II)</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <hr>

    <table>
        <tbody>
            <tr>
                <td class=w-5>1</td>
                <td colspan="3" class="">KELENGKAPAN DOKUMEN</td>

                <td class=w-5></td>

                <td class="w-5">3</td>
                <td colspan="3">VERIFIKASI BERKAS/TANDA TERIMA</td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">MOU</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_mou'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">SUB KOOR KERJASAMA</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">PKS</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_pks'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">KOOR KERJASAMA</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">TOR</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_tor'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">PPK KERJASAMA</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">RAB</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_rab'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">SPI</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">SPTJM</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_sptjm'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>


                <td class=w-5></td>

                <td></td>
                <td class="w-20">BAGREN</td>
                <td class=w-5>:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="w-20">BUKTI TRANSFER BANK</td>
                <td class=w-5>:</td>
                <td>{{ ($mou['document_bank_transfer_proceeds'] == '1') ? 'ADA' : 'TIDAK ADA' }}</td>
            </tr>
            <tr>
                <td class="w-5">2</td>
                <td class="w-20">KETERANGAN</td>
                <td class=w-5>:</td>
                <td>{{ $mou['description'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>