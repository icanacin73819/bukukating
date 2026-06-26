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
        // 1. Ubah kolom status di tabel books dari enum -> string,
        //    supaya nanti bisa diisi nilai baru ('diproses') tanpa migration lagi.
        Schema::table('books', function (Blueprint $table) {
            $table->string('status')->default('tersedia')->change();
        });

        // 2. Lengkapi tabel transactions supaya sesuai dengan Model Transaction
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('buyer_id')
                  ->nullable()
                  ->after('seller_id')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('method')->nullable()->after('price');
            $table->text('meeting_location')->nullable()->after('method');
            $table->string('expedition')->nullable()->after('meeting_location');
            $table->string('tracking_number')->nullable()->after('expedition');
            $table->text('note')->nullable()->after('tracking_number');
            $table->string('status')->default('pending')->after('note');
            $table->timestamp('completed_at')->nullable()->after('status');

            // Kolom lama ini sekarang tidak wajib diisi (datanya bisa
            // diambil dari relasi ke Book, jadi tidak perlu disimpan dobel).
            $table->string('book_title')->nullable()->change();
            $table->decimal('price', 12, 2)->nullable()->change();
            $table->timestamp('sold_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropColumn([
                'buyer_id',
                'method',
                'meeting_location',
                'expedition',
                'tracking_number',
                'note',
                'status',
                'completed_at',
            ]);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia')->change();
        });
    }
};
