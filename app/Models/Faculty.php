<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudyProgram;
use App\Models\Book;

class Faculty extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relasi ke model StudyProgram (Satu fakultas membawahi banyak prodi)
     */
    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    /**
     * Relasi ke model Book (Satu fakultas memiliki banyak buku)
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}