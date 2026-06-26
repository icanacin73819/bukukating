<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerOrder;

class BannerOrderController extends Controller
{
    /**
     * Daftar pengajuan banner
     */
    public function index()
    {
        $bannerOrders = BannerOrder::with([
            'user',
            'book',
        ])
        ->latest()
        ->paginate(10);

        return view(
            'admin.banner-orders.index',
            compact('bannerOrders')
        );
    }

    /**
     * Approve banner
     */
    public function approve(BannerOrder $bannerOrder)
    {
        $bannerOrder->update([

            'status' => 'approved',

            'starts_at' => now(),

            'ends_at' => now()->addDays(
                $bannerOrder->duration_days
            ),

        ]);

        return back()->with(
            'success',
            'Banner berhasil disetujui.'
        );
    }

    /**
     * Reject banner
     */
    public function reject(BannerOrder $bannerOrder)
    {
        $bannerOrder->update([

            'status' => 'rejected',

        ]);

        return back()->with(
            'success',
            'Banner ditolak.'
        );
    }
}