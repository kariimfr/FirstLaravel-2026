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
        Schema::create('subscriptions_packages_books', function (Blueprint $table) {
            $table->id();
            // mendeteksi daftar buku yang bisa di beli dengan paket lamgganan 
            $table->foreignId("subsciption_package_id")->contrained("subcription_packages")->onDelete("cascade");
            $table->foreignId("book_id")->constrained("books")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions_packages_books');
    }
};
