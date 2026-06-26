@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow p-8">
    <div class="grid md:grid-cols-2 gap-10">

        {{-- Gambar --}}
        <div>
            @if($book->images->first())
                <img src="{{ asset('storage/'.$book->images->first()->image) }}"
                     class="w-full rounded-lg shadow">
            @endif
        </div>

        {{-- Informasi --}}
        <div>
            <h1 class="text-3xl font-bold">{{ $book->title }}</h1>
            <p class="text-gray-500 mt-2">{{ $book->author }}</p>
            <p class="text-blue-600 text-3xl font-bold mt-5">
                Rp{{ number_format($book->price, 0, ',', '.') }}
            </p>

            {{-- Kartu Penjual --}}
            @if($book->user)
                <div class="mt-5 bg-gray-50 border border-gray-100 rounded-lg p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                        {{ strtoupper(substr($book->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Dijual oleh</p>
                        <p class="font-semibold text-gray-800">{{ $book->user->name }}</p>
                    </div>
                </div>
            @endif

            <hr class="my-6">

            <p><strong>Kategori :</strong> {{ $book->category?->name ?? '-' }}</p>
            <p class="mt-2"><strong>Fakultas :</strong> {{ $book->faculty?->name ?? '-' }}</p>
            <p class="mt-2"><strong>Program Studi :</strong> {{ $book->studyProgram?->name ?? '-' }}</p>
            <p class="mt-2"><strong>Kondisi :</strong> {{ ucfirst(str_replace('_', ' ', $book->condition)) }}</p>
            <p class="mt-2"><strong>Lokasi :</strong> {{ $book->city }}</p>
            <p class="mt-2"><strong>Dilihat :</strong> {{ $book->views }}</p>
            <p class="mt-2">
                <strong>Status :</strong>
                @if($book->status === 'tersedia')
                    <span class="text-green-600 font-semibold">Tersedia</span>
                @elseif($book->status === 'diproses')
                    <span class="text-yellow-600 font-semibold">Sedang Diproses</span>
                    <span class="text-gray-400 text-sm">(ada pembeli yang sedang bernegosiasi)</span>
                @else
                    <span class="text-red-600 font-semibold">Terjual</span>
                @endif
            </p>

            {{-- Tombol Aksi — sembunyikan untuk admin --}}
            @if(!$isAdmin)
            <div class="mt-8">
                @if(auth()->check() && auth()->id() == $book->user_id)
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('books.edit', $book->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-lg">
                            ✏️ Edit Buku
                        </a>
                        @if($book->status === 'tersedia')
                            <form action="{{ route('books.sold', $book->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                                    ✅ Tandai Terjual
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="flex flex-wrap gap-3 mt-4">
                        @if($book->status !== 'terjual')
                            <a href="{{ route('chat.show', [$book->id, $book->user_id]) }}"
                               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">
                                💬 Chat &amp; Beli
                            </a>
                        @endif
                        <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 rounded-lg {{ $isWishlisted ? 'bg-pink-600 hover:bg-pink-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                                {{ $isWishlisted ? '💔 Hapus Wishlist' : '🤍 Wishlist' }}
                            </button>
                        </form>
                        @if($book->status === 'terjual')
                            <span class="inline-flex items-center bg-gray-200 text-gray-500 px-6 py-3 rounded-lg">
                                Buku Sudah Terjual
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-400 mt-3">
                        Proses beli & nego dilakukan langsung di dalam chat dengan penjual ya 😊
                    </p>
                @endif
            </div>
            @else
            {{-- Khusus admin: hanya info, tidak ada tombol aksi user --}}
            <div class="mt-6 p-3 bg-yellow-50 border border-yellow-100 rounded-lg">
                <p class="text-xs text-yellow-700">
                    👁 Kamu melihat halaman ini sebagai Admin. Tombol chat & wishlist disembunyikan.
                </p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-10">
        <h2 class="font-bold text-xl mb-3">Deskripsi</h2>
        <p class="text-gray-700 leading-7">{{ $book->description }}</p>
    </div>
</div>