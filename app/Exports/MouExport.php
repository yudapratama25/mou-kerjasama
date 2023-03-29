<?php

namespace App\Exports;

use App\Models\Mou;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MouExport implements FromView, WithColumnWidths, WithStyles, WithEvents
{
    use Exportable;
    
    public function view(): View
    {
        $mous = Mou::with(['unit:id,name'])
                    ->where('year_id', session('selected_year_id'))
                    ->orderBy('unit_id', 'asc')
                    ->get();

        return view('mou.export', compact('mous'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'C' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            '5:6' => [
                'font' => ['bold' => true],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
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
            'AA' => 21,
            'AB' => 20,
            'AC' => 20,
            'AD' => 20,
            'AE' => 20,
            'AF' => 40,
            'AG' => 19,
        ];

        // for ($i = 'C'; $i !== 'AH'; $i++) {
        //     $columns[$i] = 8;
        // }

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

