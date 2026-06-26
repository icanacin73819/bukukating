<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Wishlist Saya
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($wishlists->isEmpty())
            <div class="bg-white rounded-xl shadow p-10 text-center text-gray-500">
                Belum ada buku di wishlist kamu. Yuk jelajahi
                <a href="{{ route('marketplace') }}" class="text-blue-600 underline">Marketplace</a>.
            </div>
        @else
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($wishlists as $item)
                    @php $book = $item->book; @endphp

                    @if($book)
                        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col justify-between">
                            <div>
                                @if($book->images->first())
                                    <img
                                        src="{{ asset('storage/'.$book->images->first()->image) }}"
                                        class="w-full h-64 object-cover">
                                @endif
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
                                    <p class="mt-2">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $book->status == 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 pt-0 flex gap-2">
                                <a
                                    href="{{ route('books.show', $book) }}"
                                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                                    Lihat Detail
                                </a>
                                <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        title="Hapus dari wishlist"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                                        💔
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>