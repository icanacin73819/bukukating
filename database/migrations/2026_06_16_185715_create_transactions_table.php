<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('book_id')->constrained()->cascadeOnDelete();

            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();

            $table->string('book_title');

            $table->decimal('price', 12, 2);

            $table->timestamp('sold_at');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};