<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class BookImage extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'image',
    ];

    /**
     * Relasi balik ke model Book (Satu foto merujuk ke satu buku induk)
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}