<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_orders', function (Blueprint $table) {

            $table->id();

            // pemilik promosi
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // buku yang dipromosikan
            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();

            // paket promosi
            $table->integer('duration_days');

            // harga paket
            $table->unsignedBigInteger('price');

            // metode pembayaran
            $table->enum('payment_method', [
                'seabank',
                'bri',
                'bsi',
                'dana',
                'gopay',
            ]);

            // bukti transfer
            $table->string('payment_proof')->nullable();

            // status
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            // masa tayang
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_orders');
    }
};