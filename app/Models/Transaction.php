<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\User;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'book_id',
        'seller_id',
        'buyer_id',
        'method',
        'meeting_location',
        'expedition',
        'tracking_number',
        'note',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($transaction) {
            $transaction->update([
                'code' => 'BK-' . $transaction->created_at->format('Ymd') . '-' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}