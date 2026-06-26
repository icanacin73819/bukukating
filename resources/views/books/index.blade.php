<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buku Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header section --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Daftar Buku Saya
                </h1>

                <a href="{{ route('books.create') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition duration-150">
                    + Jual Buku
                </a>
            </div>

            {{-- Alert Flash Message Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($books->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-500">
                    <span class="text-4xl block mb-3">📖</span>
                    <p class="font-medium">Kamu belum memiliki buku yang dijual.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($books as $book)
                        @php $pending = $pendingTransactions->get($book->id); @endphp

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between group hover:shadow-md transition duration-200">
                            
                            <div>
                                @if($book->images->first())
                                    <img src="{{ asset('storage/'.$book->images->first()->image) }}"
                                         alt="{{ $book->title }}"
                                         class="h-60 w-full object-cover group-hover:scale-102 transition duration-200">
                                @else
                                    <div class="h-60 w-full bg-gray-100 flex items-center justify-center text-gray-400">
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

                                    <p class="text-gray-500 text-sm mt-1 flex items-center gap-1">
                                        📍 {{ $book->city }}
                                    </p>

                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="text-sm text-gray-500">Status:</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            @if($book->status === 'tersedia') bg-green-50 text-green-600
                                            @elseif($book->status === 'diproses') bg-yellow-50 text-yellow-600
                                            @else bg-red-50 text-red-600
                                            @endif">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </div>

                                    @if($book->status === 'diproses' && $pending)
                                        <p class="text-xs text-yellow-600 mt-2">
                                            ⏳ Menunggu konfirmasi dari
                                            <strong>{{ $pending->buyer->name ?? 'pembeli' }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Section Tombol Aksi --}}
                            <div class="px-5 pb-5 space-y-2">
                                <a href="{{ route('books.show', $book) }}"
                                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2 rounded-lg font-medium transition duration-150">
                                    Lihat Detail
                                </a>

                                @if($book->status == 'tersedia')
                                    <form action="{{ route('books.sold', $book) }}" method="POST" class="block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('Yakin buku ini sudah terjual?')"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded-lg transition duration-150 shadow-sm">
                                            ✔ Tandai Terjual
                                        </button>
                                    </form>
                                @elseif($book->status == 'diproses' && $pending)
                                    <a href="{{ route('chat.show', [$book->id, $pending->buyer_id]) }}"
                                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition duration-150">
                                        💬 Lihat Chat
                                    </a>

                                    <form action="{{ route('transactions.cancel', $pending) }}" method="POST" class="block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('Batalkan proses transaksi ini? Buku akan kembali berstatus tersedia.')"
                                                class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 rounded-lg transition duration-150 border border-red-200">
                                            ✕ Batalkan Proses
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Edit --}}
                                <a href="{{ route('books.edit', $book) }}"
                                   class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition duration-150">
                                    ✏ Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>