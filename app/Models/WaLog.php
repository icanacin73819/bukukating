<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;

class WaLog extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relasi balik ke model User (Siapa yang melakukan klik WA)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi balik ke model Book (Buku mana yang dihubungi)
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}