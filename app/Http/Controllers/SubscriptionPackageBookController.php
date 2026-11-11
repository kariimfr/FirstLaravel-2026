<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class SubscriptionPackageBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $books = Book::with('bookCategory');

            return DataTables::of($books)
                ->addIndexColumn()

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

                ->rawColumns(['cover', 'action'])
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
