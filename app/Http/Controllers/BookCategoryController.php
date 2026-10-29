<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource using Yajra DataTables.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = BookCategory::query();

            return DataTables::eloquent($model)
                // Menambahkan penomoran otomatis (kolom 'DT_RowIndex')
                ->addIndexColumn()
                // Menambahkan kolom tombol Aksi (Edit & Hapus)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.book-categories.edit', $row->id);
                    $destroyUrl = route('admin.book-categories.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $destroyUrl . '" method="POST" class="d-inline">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kategori ini?\')">Hapus</button>
                        </form>
                    ';
                })
                // Memberitahu Yajra bahwa kolom 'action' mengandung tag HTML
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.book-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        BookCategory::create($validatedData);

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $bookCategory->update($validatedData);

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $bookCategory->delete();

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil dihapus.');
    }

    public function show(Request $request, $id)
    {
        $category = BookCategory::findOrFail($id);
        $query = $category->books();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('writer', 'like', "%{$search}%");
            });
        }

        // Fitur Sorting
        $sort = $request->input('sort', 'latest'); // Default-nya 'latest'

        if ($sort == 'cheapest') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'expensive') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // Terbaru
        }

        // paginate : 
        $books = $query->paginate(12);

        return view('category-books', compact('category', 'books'));
    }
}
