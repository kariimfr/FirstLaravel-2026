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
        Schema::create('subscriptions_packages_users', function (Blueprint $table) {
            $table->id();

            // mendeteksi siapa saja oengguan yang sudah membeli paket tersebut
            $table->foreignId("subscription_package_id")->contrained("subscription_packages")->onDelete("cascade");
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->date("expired_date");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions_packages_users');
    }
};
