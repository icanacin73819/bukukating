<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard Mahasiswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-8 text-white shadow-lg mb-8">
                <h1 class="text-3xl font-bold">
                    Halo, {{ Auth::user()->name }} 👋
                </h1>
                <p class="mt-2 text-blue-100">
                    Selamat datang di BukuKating. Semoga harimu menyenangkan!
                </p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                {{-- Card Buku Saya --}}
                <a href="{{ route('books.index') }}"
                   class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md hover:border-blue-200 transition duration-200 group">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium group-hover:text-blue-600 transition duration-200">Buku Saya</h3>
                        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalBooks }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg text-2xl">📚</div>
                </a>

                {{-- Card Wishlist --}}
                <a href="{{ route('wishlist.index') }}"
                   class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md hover:border-red-200 transition duration-200 group">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium group-hover:text-red-500 transition duration-200">Wishlist</h3>
                        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalWishlist }}</p>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg text-2xl">❤️</div>
                </a>

                {{-- Card Buku Terjual --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Buku Terjual</h3>
                        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalSold }}</p>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg text-2xl">💰</div>
                </div>

                {{-- Card Status Akun --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Status Akun</h3>
                        <p class="text-lg font-semibold mt-3 text-green-600 flex items-center gap-1">
                            <span class="h-2 w-2 rounded-full bg-green-500 inline-block animate-pulse"></span>
                            {{ ucfirst(Auth::user()->status) }}
                        </p>
                    </div>
                    <div class="p-3 bg-gray-50 text-gray-600 rounded-lg text-2xl">👤</div>
                </div>

            </div>

            {{-- Menu Cepat --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Menu Cepat</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('books.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 text-center font-semibold transition duration-150 shadow-sm block">
                        ➕ Jual Buku
                    </a>

                    <a href="{{ route('books.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl py-4 text-center font-semibold transition duration-150 block">
                        📚 Buku Saya
                    </a>

                    <a href="{{ route('wishlist.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl py-4 text-center font-semibold transition duration-150 block">
                        ❤️ Wishlist
                    </a>

                    <a href="{{ route('transactions.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl py-4 text-center font-semibold transition duration-150 block">
                        🧾 Transaksi
                    </a>
                </div>
            </div>

            {{-- Buku Terbaru Saya --}}
            <div class="mt-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Buku Terbaru Saya</h2>
                    <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                        Lihat Semua →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse(Auth::user()->books()->latest()->take(3)->get() as $book)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between group hover:shadow-md transition duration-200">
                            <div>
                                @if($book->images->first())
                                    <img src="{{ asset('storage/'.$book->images->first()->image) }}"
                                         alt="{{ $book->title }}"
                                         class="w-full h-60 object-cover group-hover:scale-102 transition duration-200">
                                @else
                                    {{-- Placeholder jika buku tidak memiliki gambar --}}
                                    <div class="w-full h-60 bg-gray-100 flex items-center justify-center text-gray-400">
                                        <span class="text-5xl">📖</span>
                                    </div>
                                @endif

                                <div class="p-5">
                                    <h3 class="font-bold text-lg text-gray-800 line-clamp-1">
                                        {{ $book->title }}
                                    </h3>

                                    <p class="text-blue-600 font-bold text-xl mt-2">
                                        Rp{{ number_format($book->price, 0, ',', '.') }}
                                    </p>

                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="text-sm text-gray-500">Status:</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold 
                                            {{ $book->status === 'terjual' || $book->status === 'sold' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-5 pb-5">
                                <a href="{{ route('books.show', $book) }}"
                                   class="block bg-gray-100 hover:bg-blue-600 text-gray-700 hover:text-white text-center py-2.5 rounded-lg font-medium transition duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        {{-- Keadaan jika mahasiswa belum mengupload buku sama sekali --}}
                        <div class="col-span-1 md:col-span-3 bg-white border border-dashed border-gray-200 rounded-xl p-12 text-center text-gray-500">
                            <span class="text-4xl block mb-3">📭</span>
                            <p class="font-medium">Kamu belum mengupload buku apa pun.</p>
                            <a href="{{ route('books.create') }}" class="mt-3 inline-block text-sm text-blue-600 font-semibold hover:underline">
                                Mulai jual buku pertamamu
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>