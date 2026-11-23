<?php

namespace App\Http\Controllers;

use App\Exports\BookCategoriesExport;
use App\Models\User;
use App\Models\CheckoutBook;
use App\Models\Book;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;


// autentication
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // biar bisa ngambil dari ...
    public function register(Request $request)
    {
        // validasi
        $validatedData = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:12']
        ], [
            // custom error/ mengganti pesan error
            'name.required' => 'nama lengkap harus di isi',
            'name.min' => 'nama harus minimal 3 karakter',
            'email.required' => 'email wajib di isi',
            'email.unique' => 'email sudah terdaftar, gunakan email yang lain',
            'password.required' => 'wajib isi password',
            'password.min' => 'password di isi min 8',
            'password.max' => 'password di isi max 12',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],

            // hashing: ubah text biasa -> karakter ACAK (rahasia) 
            'password' => Hash::make($validatedData['password'])
        ]);

        // setelah data di simpan, halaman -> arahkan kemana?
        return redirect()->route('login')->with('success', 'Berhasil membuat akun. Silakan login!');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib di isi',
            'password.required' => 'Password wajib di isi',
        ]);

        // Pengecekan login & Multi Role (Admin / User)
        if (Auth::attempt($validatedData)) {
            // Regenerate session ID setelah login berhasil (Keamanan)
            $request->session()->regenerate();

            // Cek role user
            if (Auth::user()->role == "admin") {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            } else {
                return redirect()->route('home')->with('success', 'Login successful!');
            }
        } else {
            return redirect()->back()->with('error', 'Email dan Password tidak sesuai silahkan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        // auth::logout : menghapus sesi pengguna yang sedang login
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'logged out successfully');
    }

    public function home()
    {
        // orderby atribut asc desc mengurutkan data 
        // limit(angka) menentukan jumlah yang ingin di ambil
        $latestBooks = Book::orderBy('created_at', 'desc')->limit(10)->get();
        // mencari buku gratis
        $freeBooks = Book::where('price', 0)->orderBy('created_at', 'desc')->limit(6)->get();

        // ambil paket dari 3 ter atas
        $subscriptionPackages = SubscriptionPackage::latest()->limit(3)->get();
        return view('home', compact('latestBooks', 'freeBooks', 'subscriptionPackages'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        // like : mencari data yang mirip/mengandung kata yang di cari 
        $books = Book::where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('writer', 'LIKE', '%' . $query . '%')
            ->get();

        return view('search_results', compact('books', 'query'));
    }

    public function profile()
    {
        // ID user 
        $userId = Auth::id();

        // pembleian buku
        $bookCount = CheckoutBook::where('checkout_id', $userId)->count();

        // transaksi
        $subscriptionCount = SubscriptionPackageUser::where('user_id', $userId)->count();

        // riwayat
        $transactions = SubscriptionPackageUser::with('subscriptionPackage')
            ->where('user_id', $userId)
            ->get();

        // mengirim data dari Controller 
        return view('user.profile', compact('bookCount', 'subscriptionCount', 'transactions'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,mov,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru ke folder storage/app/public/profile-photos
        $path = $request->file('photo')->store('profile-photos', 'public');

        // Update database
        // Update database secara manual
        /** @var \App\Models\User $user */
        $user->update(['photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function createExcel()
    {
        // Tentukan nama file hasil download
        $file_name = 'laporan_data.xlsx'; // Bisa diganti '.csv' jika ingin format CSV

        return Excel::download(new BookCategoriesExport, $file_name);
    }
}
