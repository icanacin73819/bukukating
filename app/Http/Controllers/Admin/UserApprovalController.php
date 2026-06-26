<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang menunggu verifikasi.
     */
    public function index()
    {
        // Hanya mengambil user dengan role mahasiswa DAN status pending
        $users = User::where('role', 'mahasiswa')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.users.pending', compact('users'));
    }

    /**
     * Menyetujui akun mahasiswa.
     */
    public function approve(User $user)
    {
        $user->update([
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Mahasiswa berhasil disetujui.');
    }

    /**
     * Menolak akun mahasiswa.
     */
    public function reject(User $user)
    {
        $user->update([
            'status' => 'ditolak',
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditolak.');
    }
}