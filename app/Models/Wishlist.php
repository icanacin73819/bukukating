<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;

class Wishlist extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
    ];

    /**
     * Relasi balik ke model User (Siapa yang menambah ke wishlist)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi balik ke model Book (Buku apa yang ada di dalam wishlist)
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}