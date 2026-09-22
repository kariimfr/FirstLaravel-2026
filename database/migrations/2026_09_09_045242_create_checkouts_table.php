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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            // memdeteksi user/pengguna yang melakukan cheoutnya
            $table->foreignId("user_id")->contraineed("users")->onDelete("cascade");
            // enum: tipe data opsi, isinya hanya boleh sesuai pilihan yang di arr []
            $table->enum("payment_method", ['Free', 'Virtual_account', 'QRIS']);
            $table->integer("total_book");
            $table->integer("total_book_price");
            $table->integer("total_price"); //harga total termasuk ppn
            $table->enum("status", ["pending", "done"]); // status pembayaran user/pengguna
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
