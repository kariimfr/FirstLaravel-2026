<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

                ->addColumn('category_name', function ($row) {
                    return $row->bookCategory
                        ? $row->bookCategory->name
                        : '-';
                })

                ->addColumn('action', function ($row) {
                    $btnDetail = '
                        <button type="button"
                            class="btn btn-info btn-sm btn-detail"
                            data-cover="' . e($row->cover ? asset($row->cover) : '') . '"
                            data-title="' . e($row->title ?? '-') . '"
                            data-category="' . e($row->bookCategory->name ?? '-') . '"
                            data-price="Rp ' . number_format($row->price ?? 0, 0, ',', '.') . '"
                            data-writer="' . e($row->writer ?? '-') . '"
                            data-publisher="' . e($row->publisher ?? '-') . '"
                            data-language="' . e($row->language ?? '-') . '"
                            data-release="' . e($row->release_date ? date('d M Y', strtotime($row->release_date)) : '-') . '"
                            data-pages="' . e($row->page_of_book ?? '-') . '"
                            data-description="' . e($row->description ?? '-') . '">
                            <i class="bi bi-eye"></i> Detail
                        </button>
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

        return view('admin.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.create', compact('bookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover'            => ['required', 'image', 'mimes:jpg,jpeg,png,svg'],
            'title'            => ['required', 'min:3'],
            'writer'           => ['required', 'min:3'],
            'publisher'        => ['required', 'min:3'],
            'release_date'     => ['required', 'date'],
            'page_of_book'     => ['required', 'numeric'],
            'price'            => ['required', 'numeric'],
            'language'         => ['required', 'min:3'],
            'description'      => ['required', 'min:3'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
        ]);

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $name = time() . '-' . $cover->getClientOriginalName();

            Storage::disk('public')->putFileAs('covers', $cover, $name);

            $validatedData['cover'] = Storage::url('covers/' . $name);
        }

        Book::create($validatedData);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Berhasil menambahkan data buku!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('bookCategory')->findOrFail($id);

        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $bookCategories = BookCategory::all();

        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'cover'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg'],
            'title'            => ['required', 'min:3'],
            'writer'           => ['required', 'min:3'],
            'publisher'        => ['required', 'min:3'],
            'release_date'     => ['required', 'date'],
            'page_of_book'     => ['required', 'numeric'],
            'page_of_book'     => ['required', 'numeric'],
            'price'            => ['required', 'numeric'],
            'language'         => ['required', 'min:3'],
            'description'      => ['required', 'min:3'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                $oldImagePath = str_replace('/storage/', '', $book->cover);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $coverImage = $request->file('cover');
            $coverImageName = time() . '-' . $coverImage->getClientOriginalName();

            Storage::disk('public')->putFileAs(
                'covers',
                $coverImage,
                $coverImageName
            );

            $validatedData['cover'] = Storage::url('covers/' . $coverImageName);
        }

        $book->update($validatedData);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover) {
            $oldImagePath = str_replace('/storage/', '', $book->cover);

            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil dihapus!');
    }
}
