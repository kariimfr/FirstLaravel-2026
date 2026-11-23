<?php

namespace App\Exports;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BooksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private int $no = 0;

    public function collection(): Enumerable
    {
        // Sesuaikan nama relasi kategori kalau di model Book namanya bukan 'category'
        // return Book::with('category')->get();
        return Book::with('bookCategory')->get();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Alamat Gambar Sampul Buku',
            'Nama Kategori Buku',
            'Judul Buku',
            'Penulis',
            'Penerbit',
            'Tanggal Rilis',
            'Jumlah Halaman',
            'Bahasa',
            'Harga',
        ];
    }

    public function map($book): array
    {
        $coverUrl = $book->cover
            ? (str_starts_with($book->cover, 'http') ? $book->cover : url(ltrim($book->cover, '/')))
            : '-';

        $releaseDate = $book->release_date
            ? Carbon::parse($book->release_date)->translatedFormat('d F Y')
            : '-';

        $price = (int) ($book->price ?? 0);
        $formattedPrice = $price === 0
            ? 'Rp 0'
            : 'Rp ' . number_format($price, 0, ',', '.');

        return [
            ++$this->no,
            $coverUrl,
            // $book->category->name ?? '-',
            $book->bookCategory->name ?? '-',
            $book->title ?? '-',
            $book->writer ?? '-',
            $book->bookCategory->name ?? '-',
            $book->publisher ?? '-',
            $releaseDate,
            $book->page_of_book ?? 0,
            $book->language ?? '-',
            $formattedPrice,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn(); // J

        // Style Header (Baris 1, A1:J1)
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
        ]);

        // Border seluruh tabel (A1:J{lastRow})
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
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
