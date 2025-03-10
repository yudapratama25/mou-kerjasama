<?php

namespace App\Exports;

use App\Models\Mou;
use App\Models\Year;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MouExport implements FromView, WithColumnWidths, WithStyles, WithEvents
{
    use Exportable;

    protected array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function view(): View
    {
        if ($this->data['is_rekapitulasi']) {
            $mous = Mou::with(['unit:id,name'])
                        ->select(['unit_id', DB::raw('COUNT(unit_id) as count_mou, SUM(pks_contract_value) as total_pks_contract_value, SUM(bank_transfer_proceeds) as total_bank_transfer_proceeds, SUM(nominal_difference) as total_nominal_difference')])
                        ->where('year_id', session('selected_year_id'))
                        ->orderBy('unit_id', 'asc')
                        ->groupBy('unit_id');
        } else {
            $mous = Mou::with(['unit:id,name'])
                        ->where('year_id', session('selected_year_id'))
                        ->orderBy('unit_id', 'asc');
        }

        if ($this->data['unit_id'] != null) {
            $mous->where('unit_id', $this->data['unit_id']);
        }

        if ($this->data['regarding_letters'] != null) {
            $mous->where('regarding_letters', 'like', '%' . $this->data['regarding_letters'] . '%');
        }

        if ($this->data['letter_number'] != null) {
            $mous->where('letter_number', 'like', '%' . $this->data['letter_number'] . '%');
        }

        if ($this->data['letter_receipt_date'] != null) {
            $mous->where('letter_receipt_date', $this->data['letter_receipt_date']);
        }

        $periode = Year::where('id', session('selected_year_id'))->first()->year;

        $view = ($this->data['is_minimalis']) ? 'mou.export-minimalis' : 'mou.export';

        $view = ($this->data['is_rekapitulasi']) ? 'mou.export-rekapitulasi' : $view;

        return view($view, ['mous' => $mous->get(), 'is_rekapitulasi' => $this->data['is_rekapitulasi'], 'periode' => $periode]);
    }

    public function styles(Worksheet $sheet)
    {
        $row_header = ($this->data['is_minimalis']) ? '5' : '5:6';

        $styles = [
            'C' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            $row_header => [
                'font' => ['bold' => true],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];

        if ($this->data['is_rekapitulasi']) {
            $styles['3'] = [
                'font' => ['bold' => true],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ];
        }

        if ($this->data['is_rekapitulasi']) {
            $styles['E'] = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ];
        }

        return $styles;
    }

    public function columnWidths(): array
    {
        if ($this->data['is_minimalis'] == false)
        {
            $columns = [
                'C' => 8,
                'D' => 35,
                'E' => 30, // nomor surat
                'F' => 22, // tanggal
                'G' => 40,
                'H' => 30,
                'I' => 22,
                'J' => 22,
                'K' => 15, // status
                'L' => 30,
                'M' => 22,
                'N' => 22,
                'O' => 15,
                'P' => 40,
                'Q' => 22,
                'R' => 22,
                'S' => 22,
                'T' => 35,
                'U' => 35,
                'V' => 35,
                'W' => 15,
                'X' => 15,
                'Y' => 15,
                'Z' => 15,
                'AA' => 15,
                'AB' => 15,
                'AC' => 15,
                'AD' => 15,
                'AE' => 15,
                'AF' => 20,
                'AG' => 20,
                'AH' => 20,
                'AI' => 20,
                'AJ' => 40, // keterangan
            ];
        }
        else if ($this->data['is_minimalis'] == true && $this->data['is_rekapitulasi'] == false)
        {
            $columns = [
                'C' => 8,
                'D' => 35, // unit kerja
                'E' => 30, // no pks
                'F' => 38, // kegiatan pks
                'G' => 26, // nilai kontrak
                'H' => 26, // transfer bank
                'I' => 26, // selisih
            ];
        } else {
            $columns = [
                'C' => 8,
                'D' => 35, // unit kerja
                'E' => 15, // kegiatan pks
                'F' => 26, // nilai kontrak
                'G' => 26, // transfer bank
                'H' => 26, // selisih
            ];
        }

        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'C5:'.$alphabet.$totalRow;

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ])->getAlignment()->setWrapText(true);
            },
        ];
    }
}

