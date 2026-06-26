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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // User yang melaporkan (pelapor)
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Buku yang dilaporkan
            $table->foreignId('book_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Alasan pelaporan
            $table->text('reason');

            // Status moderasi oleh admin
            $table->enum('status', [
                'pending',
                'review',
                'resolved',
                'rejected'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};