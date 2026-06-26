<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan — BukuKating</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="BukuKating" class="h-14 w-auto"
                     onerror="this.style.display='none'">
            </div>

            {{-- Ilustrasi / Icon --}}
            <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            {{-- Heading --}}
            <h1 class="text-xl font-bold text-gray-800 mb-2">
                Akun Sedang Diverifikasi
            </h1>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                Terima kasih sudah mendaftar! Admin sedang meninjau data dan KTM kamu.
                Proses ini biasanya memakan waktu <span class="font-medium text-gray-700">1×24 jam</span>.
            </p>

            {{-- Steps --}}
            <div class="bg-gray-50 rounded-xl p-4 text-left space-y-3 mb-6">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Pendaftaran selesai</p>
                        <p class="text-xs text-gray-400">Data kamu sudah kami terima</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse block"></span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Verifikasi KTM</p>
                        <p class="text-xs text-gray-400">Admin sedang meninjau KTM kamu</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="w-2 h-2 bg-gray-300 rounded-full block"></span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Akun diaktifkan</p>
                        <p class="text-xs text-gray-300">Kamu bisa mulai jual beli buku</p>
                    </div>
                </div>
            </div>

            {{-- Info box --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-left flex gap-3">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-blue-600 leading-relaxed">
                    Kamu akan bisa login otomatis setelah admin menyetujui akunmu. Tidak perlu daftar ulang.
                </p>
            </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 mt-4">
            © {{ date('Y') }} BukuKating · Marketplace Buku Mahasiswa
        </p>
    </div>

</body>
</html>