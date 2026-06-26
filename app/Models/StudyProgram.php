<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;
use App\Models\Book;

class StudyProgram extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'name',
        'slug',
    ];

    /**
     * Relasi balik ke model Faculty (Satu prodi merujuk ke satu fakultas induk)
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Relasi ke model Book (Satu prodi memiliki banyak buku)
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}