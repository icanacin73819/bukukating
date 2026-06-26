<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Book;
use App\Models\Wishlist;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\WaLog;
use App\Models\Message;
// Tambahan namespace untuk BannerOrder:
use App\Models\BannerOrder;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'nim',
        'university',
        'ktm',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Book (Buku yang diupload oleh user)
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Relasi ke model Wishlist
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Relasi ke model Report (Laporan pelanggaran yang dibuat user)
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Relasi ke model WaLog (Log klik WhatsApp yang dilakukan user)
     */
    public function waLogs()
    {
        return $this->hasMany(WaLog::class);
    }

    /**
     * Relasi ke model Transaction sebagai Penjual
     */
    public function soldTransactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    /**
     * Relasi ke model Transaction sebagai Pembeli
     */
    public function boughtTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    /**
     * Relasi ke model Message sebagai Pengirim
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relasi ke model Message sebagai Penerima
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Relasi ke BannerOrder
     */
    public function bannerOrders()
    {
        return $this->hasMany(BannerOrder::class);
    }
}