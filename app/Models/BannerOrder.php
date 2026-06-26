<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerOrder extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'duration_days',
        'price',
        'payment_method',
        'payment_proof',
        'status',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Relasi ke user (pemilik promosi)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke buku yang dipromosikan
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}