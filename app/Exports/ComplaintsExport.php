<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComplaintsExport implements FromCollection, WithHeadings, WithEvents, WithStyles
{
    use RegistersEventListeners;

    public function collection()
    {
        return Complaint::with(['customer', 'technician'])
            ->where('status', 'completed')
            ->get()
            ->map(function ($complaint) {
                return [
                    'Customer' => $complaint->customer->name ?? '',
                    'Subject' => $complaint->subject,
                    'Category' => $complaint->category,
                    'Priority' => ucfirst($complaint->priority),
                    'Status' => ucfirst($complaint->status),
                    'Technician' => $complaint->assignedTechnician->name ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Subject',
            'Category',
            'Priority',
            'Status',
            'Technician',
        ];
    }

    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        $highestRow = $sheet->getHighestRow();
        $sheet->fromArray([], null, 'A1', false, false);
        $sheet->setAutoFilter("A1:F{$highestRow}");

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '0073E6'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getStyle("A1:F{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A:F' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
