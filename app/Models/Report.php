<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;

class Report extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'reason',
        'status',
    ];

    /**
     * Relasi balik ke model User (Pengguna yang mengirim laporan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi balik ke model Book (Buku yang dilaporkan)
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}