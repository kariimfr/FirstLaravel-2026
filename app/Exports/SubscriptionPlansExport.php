<?php

namespace App\Exports;

use App\Http\Controllers\SubscriptionPackageController;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubscriptionPlansExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithCustomStartCell
{
    private int $no = 0;

    public function startCell(): string
    {
        // Header tabel mulai di A2 karena A1 dipakai untuk judul
        return 'A2';
    }

    public function collection(): Enumerable
    {
        return SubscriptionPackage::all();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Paket Langganan',
            'Harga',
            'Jumlah Buku',
            'Pelanggan Aktif',
        ];
    }

    public function map($plan): array
    {
        $price = (int) ($plan->price ?? 0);
        $formattedPrice = $price === 0
            ? 'Rp 0'
            : 'Rp ' . number_format($price, 0, ',', '.');

        return [
            ++$this->no,
            $plan->name_package ?? '-',
            $formattedPrice,
            $plan->books_count ?? 0,
            $plan->active_users_count ?? 0,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        // Set judul di atas tabel
        $sheet->setCellValue('A1', 'Data Paket Langganan dengan Buku dan Pengguna');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16, // Mirip ukuran heading h2
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn(); // E

        // Style Header Tabel (Baris 2, A2:E2)
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
        ]);

        // Border seluruh tabel mulai dari baris header (A2:E{lastRow})
        $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}
