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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Judul banner (misal: "Promo Buku Kuliah")
            $table->string('title');

            // Deskripsi singkat (misal: "Diskon up to 50% khusus minggu ini")
            $table->string('subtitle')->nullable();

            // Gambar banner (path file gambar)
            $table->string('image');

            // Link tujuan ketika diklik (misal: url ke kategori atau buku tertentu)
            $table->string('link')->nullable();

            // Urutan tampil (semakin kecil nilainya, semakin di depan)
            $table->integer('sort_order')->default(0);

            // Status aktif / tidak
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};