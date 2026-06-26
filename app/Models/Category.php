<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Category extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', // Biasanya diperlukan untuk URL yang SEO-friendly
    ];

    /**
     * Relasi ke model Book (Satu kategori memiliki banyak buku)
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}