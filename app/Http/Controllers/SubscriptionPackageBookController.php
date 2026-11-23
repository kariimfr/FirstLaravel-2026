<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;



class SubscriptionPackageBookController extends Controller
{

    public function index(Request $request, $id)
    {
        $subscriptionPackage = subscriptionPackage::findOrFail($id);

        if ($request->ajax()) {
            $books = Book::with('bookCategory');

            return DataTables::of($books)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    // Pastikan 'name' di bawah ini sesuai dengan nama kolom kategori di database kamu (misal: 'name' atau 'category_name')
                    return $row->bookCategory ? $row->bookCategory->name : '-';
                })

                ->editColumn('cover', function ($row) {
                    if ($row->cover) {
                        return '<img src="' . e(asset($row->cover)) . '"
                            alt="' . e($row->title) . '"
                            class="img-thumbnail"
                            style="max-height: 60px;">';
                    }

                    return '<span class="badge bg-secondary">No Cover</span>';
                })

                ->editColumn('price', function ($row) {
                    return 'Rp ' . number_format($row->price, 0, ',', '.');
                })

                ->addColumn('action', function ($row) {
                    $btnDetail = '

                    ';

                    $btnEdit = '
                        <a href="' . route('admin.books.edit', $row->id) . '"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    ';

                    $btnDelete = '
                        <form action="' . route('admin.books.destroy', $row->id) . '"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    ';

                    return '<div class="d-flex align-items-center gap-2 flex-wrap">'
                        . $btnDetail
                        . $btnEdit
                        . $btnDelete
                        . '</div>';
                })

                ->addColumn('checkbox', function ($row) use ($subscriptionPackage) {
                    // yang akan di kirim de ceklis id bukunya (value=$row->id)tionPa
                    $subscriptionPackageBook = $subscriptionPackage->subscriptionPackageBooks->pluck('book_id')->toArray();

                    if (in_array($row->id, $subscriptionPackageBook)) {
                        return '';
                    }
                    return '<input type="checkbox" class="book-checkbox" value="' . $row->id . '">';
                })

                ->rawColumns(['cover', 'checkbox', 'action'])
                ->make(true);
        }

        $subscriptionPackage = SubscriptionPackage::findOrFail($id);
        return view('admin.subscription-package-books.index', compact('subscriptionPackage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if (!$request->has('book_id')) {
            return redirect()->back()->with('error', 'tidak ada buku yang dipilih.');
        }

        $bookIds = array_unique($request->input('book_id'));
        foreach ($bookIds as $key => $value) {
            SubscriptionPackageBook::create([
                'subscription_package_id' => $id,
                'book_id' => $value,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan buku ke paket langganan');
    }
    /**
     * Display the specified resource.
     */
    public function showUserDetail($id)
    {
        $subscriptionPackage = SubscriptionPackage::with(['subscriptionPackageBooks.book', 'subscriptionPackageBooks.book.bookCategory'])->findOrFail($id);

        return view('admin.subscription-package-books.detail', compact('subscriptionPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
