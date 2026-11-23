<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageUser;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\SubscriptionPlansExport;
use Maatwebsite\Excel\Facades\Excel;



class SubscriptionPackageController extends Controller
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
                        </form>' . "<a href='" . route('admin.subscription-packages.books', $row->id) . "'
                    class='btn btn-sm btn-primary'>pilih buku</a>";
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

    public function checkoutPage($id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);
        $code = $subscriptionPackage->id . '-' . Auth::id();
        return view('user.subscription-packages.checkout', compact('subscriptionPackage', 'code'));
    }

    public function checkout(Request $request, $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        SubscriptionPackageUser::create([
            'subscription_package_id' => $subscriptionPackage->id,
            'user_id' => Auth::id(),
            // 30 hari dari sekarang, format tahun-bulan-tanggal
            'expired_date' => now()->addDays(30)->format('Y-m-d'),
        ]);

        return redirect()->route('home')->with('success', 'Pembayaran berhasil. Terima kasih telah berlangganan!');
    }

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

    public function export()
    {
        return Excel::download(new SubscriptionPlansExport, 'data_paket_langganan.xlsx');
    }
}
