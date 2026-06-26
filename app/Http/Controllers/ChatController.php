<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Book;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $threads = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('book')
            ->latest()
            ->get()
            ->groupBy(function ($m) use ($userId) {
                $otherId = $m->sender_id == $userId ? $m->receiver_id : $m->sender_id;
                return $m->book_id . '-' . $otherId;
            })
            ->map(function ($group) use ($userId) {
                $lastMessage = $group->first();
                $otherId = $lastMessage->sender_id == $userId ? $lastMessage->receiver_id : $lastMessage->sender_id;
                return [
                    'book' => $lastMessage->book,
                    'other_user' => User::find($otherId),
                    'last_message' => $lastMessage,
                ];
            })
            ->values();

        return view('chat.index', compact('threads'));
    }

    public function show(Book $book, User $user)
    {
        $authId = Auth::id();
        abort_if($authId == $user->id, 403);

        $messages = Message::where('book_id', $book->id)
            ->where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })
            ->oldest()
            ->get();

        Message::where('book_id', $book->id)
            ->where('sender_id', $user->id)
            ->where('receiver_id', $authId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Cek apakah ada transaksi (pending/completed) untuk buku ini
        // antara pasangan chat yang sedang dibuka (siapa pun yang jadi pembeli).
        $transaction = Transaction::where('book_id', $book->id)
            ->where(function ($q) use ($authId, $user) {
                $q->where('buyer_id', $authId)->orWhere('buyer_id', $user->id);
            })
            ->latest()
            ->first();

        return view('chat.show', compact('book', 'user', 'messages', 'transaction'));
    }

    public function store(Request $request, Book $book, User $user)
    {
        $validated = $request->validate(['body' => 'required|string|max:1000']);

        $message = Message::create([
            'book_id' => $book->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $validated['body'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id' => $message->id,
            'body' => $message->body,
            'sender_id' => $message->sender_id,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    /**
     * Pembeli mengajukan pembelian buku dari dalam chat.
     * Buku akan berubah status menjadi 'diproses' (belum terjual sepenuhnya).
     */
    public function buy(Book $book, User $user)
    {
        $authId = Auth::id();

        abort_if($authId == $user->id, 403);
        abort_if($authId == $book->user_id, 403, 'Penjual tidak bisa membeli bukunya sendiri.');
        abort_if($user->id != $book->user_id, 403, 'Lawan chat ini bukan penjual buku ini.');

        if ($book->status !== 'tersedia') {
            return back()->with('error', 'Buku ini sudah tidak tersedia untuk dibeli.');
        }

        Transaction::create([
            'book_id'           => $book->id,
            'seller_id'         => $book->user_id,
            'buyer_id'          => $authId,
            'method'            => 'cod',
            'meeting_location'  => $book->location_note,
            'note'              => 'Pembeli mengajukan pembelian melalui chat.',
            'status'            => 'pending',
        ]);

        $book->update(['status' => 'diproses']);

        $message = Message::create([
            'book_id'     => $book->id,
            'sender_id'   => $authId,
            'receiver_id' => $user->id,
            'body'        => '📦 Saya mengajukan pembelian buku ini. Yuk atur waktu & lokasi COD!',
        ]);
        broadcast(new MessageSent($message))->toOthers();

        return back()->with('success', 'Pengajuan beli terkirim! Lanjutkan obrolan untuk atur COD dengan penjual.');
    }

    /**
     * Pembeli menandai transaksi selesai setelah COD selesai dilakukan.
     * Buku berubah status menjadi 'terjual' secara final.
     */
    public function complete(Book $book, User $user)
    {
        $authId = Auth::id();
        abort_if($authId == $user->id, 403);

        $transaction = Transaction::where('book_id', $book->id)
            ->where('buyer_id', $authId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        abort_if(!$transaction, 404, 'Tidak ada transaksi yang menunggu konfirmasi untuk buku ini.');

        $transaction->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        $book->update(['status' => 'terjual']);

        $message = Message::create([
            'book_id'     => $book->id,
            'sender_id'   => $authId,
            'receiver_id' => $user->id,
            'body'        => '✅ Transaksi selesai! Saya sudah menerima bukunya. Terima kasih!',
        ]);
        broadcast(new MessageSent($message))->toOthers();

        return back()->with('success', 'Transaksi ditandai selesai. Terima kasih sudah berbelanja!');
    }
}