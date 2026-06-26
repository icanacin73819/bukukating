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
        Schema::create('wa_logs', function (Blueprint $table) {
            $table->id();

            // User yang melakukan klik tombol WA
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Buku/Penjual yang dihubungi
            $table->foreignId('book_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // IP Address pengakses untuk deteksi spam tingkat lanjut
            $table->ipAddress('ip_address')->nullable();

            // Informasi browser/perangkat pengguna
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_logs');
    }
};