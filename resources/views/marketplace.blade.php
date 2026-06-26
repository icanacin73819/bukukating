<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-8">
            Marketplace Buku
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($books as $book)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col justify-between">

                    <div class="relative">
                        @if($book->images->first())
                            <img
                                src="{{ asset('storage/'.$book->images->first()->image) }}"
                                class="w-full h-64 object-cover">
                        @endif

                        @if($book->status == 'diproses')
                            <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                Diproses
                            </span>
                        @endif

                        @auth
                            @if(auth()->id() != $book->user_id)
                                <form
                                    action="{{ route('wishlist.toggle', $book->id) }}"
                                    method="POST"
                                    class="absolute top-2 right-2">
                                    @csrf
                                    <button
                                        type="submit"
                                        title="{{ in_array($book->id, $wishlistedBookIds) ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-full shadow {{ in_array($book->id, $wishlistedBookIds) ? 'bg-pink-600' : 'bg-white/90' }} hover:scale-105 transition">
                                        {{ in_array($book->id, $wishlistedBookIds) ? '❤️' : '🤍' }}
                                    </button>
                                </form>
                            @endif
                        @endauth

                        <div class="p-4">
                            <h2 class="font-bold text-lg line-clamp-2">
                                {{ $book->title }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $book->author }}
                            </p>
                            <p class="text-blue-600 font-bold text-xl mt-3">
                                Rp{{ number_format($book->price, 0, ',', '.') }}
                            </p>
                            <p class="text-gray-500 text-sm mt-1">
                                📍 {{ $book->city }}
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <a
                            href="{{ route('books.show', $book) }}"
                            class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg mt-4">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>