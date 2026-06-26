<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $transactions = Transaction::with(['book.images', 'seller', 'buyer'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest()
            ->get();

        return view('transactions.index', compact('transactions'));
    }
}