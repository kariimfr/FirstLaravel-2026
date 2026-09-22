<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("cover");
            $table->string("title");
            $table->integer("price");

            // nullable: data boleh dikosongkan
            $table->text("description")->nullable();
            $table->string("language");
            $table->string("publisher");
            $table->string("writer");
            $table->date("release_date");
            $table->integer("page_of_book"); // Bisa juga diubah ke integer('pages') agar lebih natural

            // Foreign Key: mengambil data dari tabel lain (format: nama_tabel_tunggal_id)
            // - constrained: tabel tujuan
            // - onDelete: jika data kategori dihapus, data buku juga ikut terhapus
            $table->foreignId("book_category_id")->constrained("book_categories")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
