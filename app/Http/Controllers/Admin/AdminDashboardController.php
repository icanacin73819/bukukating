<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\BannerOrder;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Summary Cards ──────────────────────────────────────
        $totalUsers      = User::where('role', 'mahasiswa')->count();
        $totalBooks      = Book::count();
        $availableBooks  = Book::where('status', 'tersedia')->count();
        $soldBooks       = Book::where('status', 'terjual')->count();
        $pendingUsers    = User::where('status', 'pending')->count();
        $pendingBanners  = BannerOrder::where('status', 'pending')->count();
        $activeBanners   = BannerOrder::where('status', 'approved')
                            ->where('ends_at', '>=', now())->count();
        $totalBannerRevenue = BannerOrder::where('status', 'approved')->sum('price');

        // ── Grafik Transaksi per Bulan (12 bulan terakhir) ─────
        $transactionChart = Transaction::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // ── Grafik Buku Terdaftar per Bulan (12 bulan terakhir) ─
        $bookChart = Book::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // ── Isi bulan yang kosong dengan 0 ────────────────────
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $transactionData = $months->map(fn($m) => $transactionChart[$m] ?? 0);
        $bookData        = $months->map(fn($m) => $bookChart[$m] ?? 0);

        // Label bulan dalam Bahasa Indonesia
        $monthLabels = $months->map(function ($m) {
            $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            [$y, $mo] = explode('-', $m);
            return $bulan[(int)$mo - 1] . ' ' . substr($y, 2);
        });

        return view('admin.dashboard', compact(
            'totalUsers', 'totalBooks', 'availableBooks', 'soldBooks',
            'pendingUsers', 'pendingBanners', 'activeBanners', 'totalBannerRevenue',
            'transactionData', 'bookData', 'monthLabels'
        ));
    }
}