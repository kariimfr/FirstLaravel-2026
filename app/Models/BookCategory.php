<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookCategory extends Model
{
    protected $fillable = ['name']; // Gunakan cara standar ini untuk fillable agar lebih aman

    // yang menghubungkan satu kategori ke banyak data buku.
    // Relasi inilah yang bikin Laravel tahu buku mana 
    // saja yang masuk ke kategori tertentu
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'book_category_id', 'id');
        // Ubah 'book_category_id' sesuai nama kolom foreign key di tabel books kamu jika berbeda
    }
}
