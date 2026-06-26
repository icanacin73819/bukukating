<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard mahasiswa.
     */
    public function index()
    {
        $user = Auth::user();

        // Admin diarahkan ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Mahasiswa pending
        if ($user->status === 'pending') {
            return redirect()->route('waiting-approval');
        }

        // Mahasiswa ditolak
        if ($user->status === 'ditolak') {
            Auth::logout();

            return redirect('/login')->withErrors([
                'email' => 'Akun Anda ditolak oleh Admin.',
            ]);
        }

        // Statistik Dashboard
        $totalBooks = Book::where('user_id', $user->id)->count();

        $totalWishlist = Wishlist::where('user_id', $user->id)->count();

        $totalSold = Transaction::where('seller_id', $user->id)
            ->count();

        return view('dashboard', compact(
            'totalBooks',
            'totalWishlist',
            'totalSold'
        ));
    }
}