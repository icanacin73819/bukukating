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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();

            // User yang menambahkan ke wishlist
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Buku yang di-wishlist
            $table->foreignId('book_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();

            // Mencegah duplikasi: 1 user hanya bisa nge-wishlist 1 buku yang sama sekali saja
            $table->unique([
                'user_id',
                'book_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};