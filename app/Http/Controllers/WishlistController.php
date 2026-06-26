<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Tampilkan daftar buku yang di-wishlist oleh user yang sedang login.
     */
    public function index()
    {
        $wishlists = Wishlist::with(['book.images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Tambah atau hapus buku dari wishlist (toggle).
     */
    public function toggle(Book $book)
    {
        // Penjual tidak bisa wishlist buku miliknya sendiri
        abort_if($book->user_id == Auth::id(), 403);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Buku dihapus dari wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return back()->with('success', 'Buku ditambahkan ke wishlist.');
    }
}