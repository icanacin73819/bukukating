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

            // Pemilik buku (penjual)
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Kategori
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Fakultas
            $table->foreignId('faculty_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Program Studi
            $table->foreignId('study_program_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Data Buku
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price');

            // Format
            $table->enum('format', [
                'fisik',
                'ebook'
            ]);

            // Kondisi
            $table->enum('condition', [
                'sangat_bagus',
                'bagus',
                'cukup',
                'kurang',
                'digital'
            ]);
            $table->text('condition_note')->nullable();

            // Lokasi
            $table->string('city');
            $table->text('location_note');

            // Nomor WA penjual (opsional jika berbeda dari profil)
            $table->string('whatsapp')->nullable();

            // Status
            $table->enum('status', [
                'tersedia',
                'terjual'
            ])->default('tersedia');

            // View counter
            $table->unsignedInteger('views')
                  ->default(0);

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