<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\BookImage;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\Wishlist;
// Tambahan namespace untuk BannerOrder:
use App\Models\BannerOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class BookController extends Controller
{
    /**
     * Tampilkan daftar buku milik user yang sedang login.
     */
    public function index()
    {
        $books = Book::with('images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $pendingTransactions = Transaction::with('buyer')
            ->whereIn('book_id', $books->pluck('id'))
            ->where('status', 'pending')
            ->get()
            ->keyBy('book_id');

        return view('books.index', compact('books', 'pendingTransactions'));
    }

    /**
     * Tampilkan halaman marketplace dengan daftar buku yang tersedia/diproses.
     */
    public function marketplace()
    {
        $books = Book::with('images')
            ->whereIn('status', ['tersedia', 'diproses'])
            ->latest()
            ->get();

        $wishlistedBookIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('book_id')->toArray()
            : [];

        return view('marketplace', compact('books', 'wishlistedBookIds'));
    }

    /**
     * Tampilkan detail buku.
     */
    public function show(Book $book)
    {
        $book->increment('views');

        $book->load([
            'images',
            'user',
            'category',
            'faculty',
            'studyProgram',
        ]);

        $isWishlisted = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->where('book_id', $book->id)->exists()
            : false;

        return view('books.show', compact('book', 'isWishlisted'));
    }

    /**
     * Ubah status buku menjadi terjual secara langsung oleh PENJUAL.
     */
    public function markAsSold(Book $book)
    {
        abort_if($book->user_id != auth()->id(), 403);

        if ($book->status === 'terjual') {
            return back()->with('info', 'Buku sudah ditandai terjual.');
        }

        $book->update([
            'status' => 'terjual',
        ]);

        Transaction::create([
            'book_id'           => $book->id,
            'seller_id'         => auth()->id(),
            'method'            => 'cod',
            'meeting_location'  => $book->location_note,
            'expedition'        => null,
            'tracking_number'   => null,
            'note'              => 'Ditandai terjual oleh penjual.',
            'status'            => 'completed',
            'completed_at'      => now(),
        ]);

        return back()->with(
            'success',
            'Buku berhasil ditandai sebagai terjual.'
        );
    }

    /**
     * Batalkan proses transaksi yang masih pending (dilakukan oleh PENJUAL).
     */
    public function cancelTransaction(Transaction $transaction)
    {
        abort_if($transaction->seller_id != Auth::id(), 403);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah tidak bisa dibatalkan.');
        }

        $transaction->update(['status' => 'cancelled']);

        $book = $transaction->book;
        if ($book && $book->status === 'diproses') {
            $book->update(['status' => 'tersedia']);
        }

        if ($book && $transaction->buyer_id) {
            $message = Message::create([
                'book_id'     => $book->id,
                'sender_id'   => Auth::id(),
                'receiver_id' => $transaction->buyer_id,
                'body'        => '❌ Penjual membatalkan proses transaksi ini. Buku kembali berstatus tersedia.',
            ]);
            broadcast(new MessageSent($message))->toOthers();
        }

        return back()->with('success', 'Proses transaksi dibatalkan, buku kembali berstatus tersedia.');
    }

    /**
     * Tampilkan halaman form edit data buku.
     */
    public function edit(Book $book)
    {
        abort_if($book->user_id != auth()->id(), 403);

        $book->load('images');

        $categories = Category::all();
        $faculties = Faculty::all();
        $studyPrograms = StudyProgram::all();

        return view('books.edit', compact(
            'book',
            'categories',
            'faculties',
            'studyPrograms'
        ));
    }

    /**
     * Memperbarui data buku di database (termasuk menambah foto baru jika ada).
     */
    public function update(Request $request, Book $book)
    {
        abort_if($book->user_id != auth()->id(), 403);

        $request->validate([
            'category_id'      => 'nullable|exists:categories,id',
            'faculty_id'       => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'title'            => 'required',
            'author'           => 'required',
            'description'      => 'nullable',
            'price'            => 'required|numeric',
            'format'           => 'required',
            'condition'        => 'required',
            'condition_note'   => 'nullable',
            'city'             => 'required',
            'location_note'    => 'required',
            'whatsapp'         => 'nullable',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $book->update($request->only([
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
        ]));

        // Foto baru ditambahkan, foto lama tetap ada (kecuali dihapus manual lewat tombol Hapus)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('book-images', 'public');
                BookImage::create(['book_id' => $book->id, 'image' => $path]);
            }
        }

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Hapus satu foto buku.
     */
    public function deleteImage(BookImage $image)
    {
        abort_if($image->book->user_id != Auth::id(), 403);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * Menghapus data buku dari database.
     */
    public function destroy(Book $book)
    {
        abort_if($book->user_id != auth()->id(), 403);

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Tampilkan halaman form jual buku.
     */
    public function create()
    {
        $categories = Category::all();
        $faculties = Faculty::all();
        $studyPrograms = StudyProgram::all();

        return view('books.create', compact(
            'categories',
            'faculties',
            'studyPrograms'
        ));
    }

    /**
     * Simpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'      => 'nullable|exists:categories,id',
            'faculty_id'       => 'nullable|exists:faculties,id',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'format'           => 'required|in:fisik,ebook',
            'condition'        => 'required|in:sangat_bagus,bagus,cukup,kurang,digital',
            'condition_note'   => 'nullable|string',
            'city'             => 'required|string|max:255',
            'location_note'    => 'required|string',
            'whatsapp'         => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $book = Book::create([
                'user_id'          => Auth::id(),
                'category_id'      => $request->category_id,
                'faculty_id'       => $request->faculty_id,
                'study_program_id' => $request->study_program_id,
                'title'            => $request->title,
                'author'           => $request->author,
                'description'      => $request->description,
                'price'            => $request->price,
                'format'           => $request->format,
                'condition'        => $request->condition,
                'condition_note'   => $request->condition_note,
                'city'             => $request->city,
                'location_note'    => $request->location_note,
                'whatsapp'         => $request->whatsapp,
                'status'           => 'tersedia',
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('book-images', 'public');
                    BookImage::create(['book_id' => $book->id, 'image' => $path]);
                }
            }

            // Jika user memilih promosi
            if ($request->promotion == 1) {

                $harga = match ((int) $request->duration_days) {
                    3 => 10000,
                    7 => 20000,
                    30 => 50000,
                    default => 10000,
                };

                $bannerOrder = BannerOrder::create([
                    'user_id'        => Auth::id(),
                    'book_id'        => $book->id,
                    'duration_days'  => $request->duration_days,
                    'price'          => $harga,
                    'payment_method' => $request->payment_method,
                    'status'         => 'pending',
                ]);
            }

            DB::commit();

            if ($request->promotion == 1) {
                return redirect()->route(
                    'banner.payment',
                    $bannerOrder->id
                );
            }

            return redirect()
                ->route('dashboard')
                ->with('success', 'Buku berhasil dipublikasikan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function adminIndex()
    {
        $books = Book::with(['user', 'category'])->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function adminDestroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil deleted.');
    }
}