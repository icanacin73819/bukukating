<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\BookImage;
use App\Models\Wishlist;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\WaLog;
use App\Models\Message;
// Tambahan namespace untuk BannerOrder:
use App\Models\BannerOrder;

class Book extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'faculty_id',
        'study_program_id',
        'title',
        'author',
        'description',
        'price',
        'format',
        'condition',
        'condition_note',
        'city',
        'location_note',
        'whatsapp',
        'status',
        'views',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'views' => 'integer',
        ];
    }

    /**
     * Relasi ke model User (Pemilik/Penjual buku)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Category (Kategori buku)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke model Faculty (Fakultas buku)
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Relasi ke model StudyProgram (Program Studi buku)
     */
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    /**
     * Relasi ke model BookImage (Foto-foto buku)
     */
    public function images()
    {
        return $this->hasMany(BookImage::class);
    }

    /**
     * Relasi ke model Wishlist
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Relasi ke model Report (Laporan terkait buku ini)
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Relasi ke model Transaction (Riwayat transaksi buku ini)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi ke model WaLog (Log klik WA pada buku ini)
     */
    public function waLogs()
    {
        return $this->hasMany(WaLog::class);
    }

    /**
     * Relasi ke model Message (Pesan yang terkait dengan buku ini)
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Relasi ke BannerOrder
     */
    public function bannerOrders()
    {
        return $this->hasMany(BannerOrder::class);
    }
}