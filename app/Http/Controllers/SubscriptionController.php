<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource using Yajra DataTables.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = SubscriptionPackage::query();

            return DataTables::eloquent($model)
                //  Method untuk nomor urut otomatis
                ->addIndexColumn()
                // menambahkan kolom buatan
                ->addColumn('color', function ($row) {
                    return $row->color;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.subscriptions.edit', $row->id);
                    $destroyUrl = route('admin.subscriptions.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $destroyUrl . '" method="POST" class="d-inline">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus paket ini?\')">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    // Logika ini -> memanggil file view 'admin.subscriptions.create'
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    // Validasi inputan dari form tambah data
    {
        $validatedData = $request->validate([
            // Validate Memastikan Aturan Data Terpenuh
            'name_package' => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric'],
            'color'        => ['required', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
        ]);

        // Memasukkan/menyimpan data baru ke dalam database
        SubscriptionPackage::create($validatedData);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);

        $validatedData = $request->validate([
            'name_package' => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric'],
            'color'        => ['required', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
        ]);

        $subscription->update($validatedData);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subscription = SubscriptionPackage::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
