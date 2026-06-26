<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Chat dengan {{ $user->name }} — {{ $book->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto space-y-4">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- KARTU PRODUK --}}
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                @if($book->images->first())
                    <img
                        src="{{ asset('storage/'.$book->images->first()->image) }}"
                        class="w-16 h-20 object-cover rounded-lg">
                @endif

                <div class="flex-1">
                    <a href="{{ route('books.show', $book) }}" class="font-bold hover:underline">
                        {{ $book->title }}
                    </a>
                    <p class="text-blue-600 font-bold">
                        Rp{{ number_format($book->price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs mt-1">
                        @if($book->status == 'tersedia')
                            <span class="text-green-600 font-semibold">● Tersedia</span>
                        @elseif($book->status == 'diproses')
                            <span class="text-yellow-600 font-semibold">● Diproses</span>
                        @else
                            <span class="text-red-600 font-semibold">● Terjual</span>
                        @endif
                    </p>
                </div>

                {{-- AKSI TRANSAKSI --}}
                <div>
                    @php $isOwner = auth()->id() == $book->user_id; @endphp

                    @if(!$isOwner)
                        {{-- Sudut pandang PEMBELI --}}
                        @if($transaction && $transaction->buyer_id == auth()->id() && $transaction->status == 'pending')
                            <form action="{{ route('chat.complete', [$book->id, $user->id]) }}" method="POST"
                                onsubmit="return confirm('Sudah ketemu & terima bukunya dari penjual? Ini akan menandai transaksi selesai.');">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap">
                                    ✅ Tandai Selesai
                                </button>
                            </form>
                        @elseif($transaction && $transaction->buyer_id == auth()->id() && $transaction->status == 'completed')
                            <span class="text-sm text-green-600 font-semibold">✅ Sudah Dibeli</span>
                        @elseif($book->status == 'tersedia')
                            <form action="{{ route('chat.buy', [$book->id, $user->id]) }}" method="POST"
                                onsubmit="return confirm('Ajukan pembelian buku ini? Status buku akan berubah jadi Diproses.');">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm whitespace-nowrap">
                                    🛒 Ajukan Beli
                                </button>
                            </form>
                        @elseif($book->status == 'diproses')
                            <span class="text-sm text-gray-500">Sedang dinego pembeli lain</span>
                        @else
                            <span class="text-sm text-gray-500">Buku sudah terjual</span>
                        @endif
                    @else
                        {{-- Sudut pandang PENJUAL --}}
                        @if($transaction && $transaction->status == 'pending')
                            <span class="text-sm text-yellow-600 font-semibold">⏳ Menunggu konfirmasi pembeli</span>
                        @elseif($transaction && $transaction->status == 'completed')
                            <span class="text-sm text-green-600 font-semibold">✅ Transaksi Selesai</span>
                        @endif
                    @endif
                </div>
            </div>

            {{-- KOTAK CHAT --}}
            <div class="bg-white rounded-xl shadow flex flex-col h-[520px]">
                <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-3">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                                <p class="text-sm">{{ $message->body }}</p>
                                <p class="text-[10px] opacity-70 mt-1">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <form id="chat-form" class="p-4 border-t flex gap-2">
                    <input type="text" id="chat-input" placeholder="Tulis pesan..."
                        class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const bookId = {{ $book->id }};
        const authId = {{ auth()->id() }};
        const otherId = {{ $user->id }};
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');

        function appendMessage(msg, isMine) {
            const wrapper = document.createElement('div');
            wrapper.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;
            wrapper.innerHTML = `
                <div class="max-w-xs px-4 py-2 rounded-lg ${isMine ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'}">
                    <p class="text-sm">${msg.body}</p>
                    <p class="text-[10px] opacity-70 mt-1">${msg.created_at}</p>
                </div>`;
            chatBox.appendChild(wrapper);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const body = chatInput.value.trim();
            if (!body) return;
            const response = await fetch(`/chat/${bookId}/${otherId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ body }),
            });
            const message = await response.json();
            appendMessage(message, true);
            chatInput.value = '';
        });

        window.Echo.private(`chat.${bookId}.${Math.min(authId, otherId)}.${Math.max(authId, otherId)}`)
            .listen('MessageSent', (e) => appendMessage(e, false));

        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</x-app-layout>