<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Data Input (Termasuk File KTM)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'ktm' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048', // Maksimal 2MB
            ],
            'password' => [
    'required',
    'confirmed',
    Rules\Password::defaults(),
],
        ]);

        // 2. Upload File KTM ke folder 'storage/app/public/ktm'
        $ktmPath = $request->file('ktm')->store('ktm', 'public');

        // 3. Simpan data user ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'phone' => $request->phone,
            'ktm' => $ktmPath, // Menyimpan path/jalur file
            'role' => 'mahasiswa',
            'status' => 'pending',
            'university' => 'Universitas Islam Negeri Sumatera Utara',
        ]);

        // 4. Memicu Event Registered & Otomatis Login
        event(new Registered($user));

        Auth::login($user);

        // Karena akun baru masih pending verifikasi admin
        return redirect()->route('waiting-approval');
    }
}