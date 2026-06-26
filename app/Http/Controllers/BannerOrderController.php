<?php

namespace App\Http\Controllers;

use App\Models\BannerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerOrderController extends Controller
{
    /**
     * Halaman pembayaran promosi
     */
    public function payment(BannerOrder $bannerOrder)
    {
        abort_if($bannerOrder->user_id != auth()->id(), 403);

        return view('banner.payment', compact('bannerOrder'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadProof(Request $request, BannerOrder $bannerOrder)
    {
        abort_if($bannerOrder->user_id != auth()->id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('payment_proof')
            ->store('payment-proofs', 'public');

        $bannerOrder->update([
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Silakan tunggu verifikasi admin.'
            );
    }
}