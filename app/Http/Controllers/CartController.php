<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPackageUser;


class CartController extends Controller
{

    //   Proses penyimpanan data ke buku ke keranjang 
    // - Menyaring seluruh opsi langganan yang ada di keranjang untuk 
    //   menentukan mana saja paket yang belum diaktifkan atau belum dibeli
    //   oleh pengguna. Agar nantinya ada notifikasi di ringkasan pembelian bahwa
    //   paket tersebut belum dibeli pengguna.
    // - Mengatur harga yang berlaku untuk setiap item secara dinamis—mengutamakan
    //   tarif paket langganan jika tersedia, atau tarif standar jika tidak—sekaligus 
    //   menandai item mana yang membutuhkan pembelian paket baru.
    public function index()
    {
        $userId = Auth::id();

        $carts = Cart::with(['book', 'subscriptionPackage'])
            ->where('user_id', $userId)
            ->latest() // mengurutkan secara desc
            ->get();

        // paket langganan aktif milik pengguna
        $activePackageIds = SubscriptionPackageUser::where('user_id', $userId)
            ->whereDate('expired_date', '>', today())
            ->pluck('subscription_package_id');

        // paket di keranjang yang belum dibeli pengguna
        $packageUserNotBought = $carts
            ->whereNotNull('subscription_package_id') // jangan ambil yg subscription_package_id nya null (buku satuan)
            ->pluck('subscription_package_id')
            ->unique() // subscription_package_id diambil unik (tidak duplikat)
            ->diff($activePackageIds) // membandingkan subscription_package_id yg belum ada di $activePackageIds (paket yg uda dibeli)
            ->values(); // ambil ulang collection yg sudah disesuaikan (filter)

        // menambahkan attribute baru ke data $carts
        $carts->each(function ($cart) use ($packageUserNotBought) {
            // untuk menyesuaikan harga yg ditampilkan : dari paket langganan atau satuan buku
            $cart->display_price = $cart->subscriptionPackage ? $cart->subscriptionPackage->price : $cart->book->price;
            // contains() mengembalikan true/false apakah $cart->subscription_package_id item ini ada di $packageUserNotBought (paket yg belum dibeli pengguna)
            $cart->needs_package = $packageUserNotBought->contains($cart->subscription_package_id);
        });

        // total harga dari semua item di keranjang
        $totalPrice = $carts->sum('display_price');

        return view('user.carts.index', compact('carts', 'totalPrice'));
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
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'purchase_option' => ['required'],
            'action' => ['required', 'in:add_to_cart,buy_now'],
        ]);

        if ($request->action === 'buy_now') {
            // penyesuaian berikutnya untuk proses pembelian langsung tanpa menambahkan ke keranjang
        } else {
            // menggunakan updateOrCreate agar jika pengguna id yg sedang login saat ini sudah pernah menambahkan buku ini ke keranjang
            // maka data keranjang akan diperbarui bagian opsi pilihan pembayaran (subscription_package_id / none)
            Cart::updateOrCreate([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
            ], [
                // input radio purchase_option memiliki value antara none (untuk satuan) atau id dari subscription_package
                'subscription_package_id' => $request->purchase_option != "none" ? $request->purchase_option : NULL
            ]);
        }

        return redirect()->route('carts')->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    // proses hapus pada 
    public function destroy($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->route('carts')->with('success', 'Buku berhasil dihapus dari keranjang.');
    }
}
