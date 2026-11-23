<?php

namespace App\Exports;

use App\Models\BookCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BookCategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    private $no = 0;

    /**
     * @return \Illuminate\Support\Collection
     */
    // enumerable: kategori besar (induk) dari semua jenis data kumpulan di Laravel
    // collection: mengambil dan mengatur data isi excel 
    public function collection(): Collection
    {
        return BookCategory::withCount('books')->get();
    }

    /**
     * @param mixed $bookCategory
     * @return array
     */
    // map($bookCategory): Mengatur isi tiap baris data di Excel. 
    // Di sini nomor urut ditambah (++$this->no), 
    // lalu diambil nama kategorinya ($bookCategory->name) dan
    // jumlah bukunya ($bookCategory->books_count—tanpa
    // tanda kurung karena ini properti/atribut, bukan 
    public function map($bookCategory): array
    {
        return [
            ++$this->no,
            $bookCategory->name,
            $bookCategory->books_count,
        ];
    }


    // menentukan judul table pada excel 
    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Jumlah Buku',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $totalRows = $this->collection()->count() + 1;

        return [
            1 => ['font' => ['bold' => true]],

            "A1:C{$totalRows}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
