<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($transactions->isEmpty())
                <div class="bg-white rounded-xl border border-dashed border-gray-200 p-12 text-center text-gray-500">
                    <span class="text-4xl block mb-3">📭</span>
                    <p class="font-medium">Belum ada transaksi.</p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peran</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Lawan Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transactions as $trx)
                                @php
                                    $isBuyer = $trx->buyer_id === Auth::id();
                                    $counterpart = $isBuyer ? $trx->seller : $trx->buyer;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-700">
                                        {{ $trx->code ?? 'BK-' . $trx->created_at->format('Ymd') . '-' . str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($trx->book && $trx->book->images->first())
                                                <img src="{{ asset('storage/'.$trx->book->images->first()->image) }}"
                                                     class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-lg">📖</div>
                                            @endif
                                            <span class="text-sm font-medium text-gray-800">
                                                {{ $trx->book?->title ?? $trx->book_title ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $isBuyer ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600' }}">
                                            {{ $isBuyer ? 'Pembeli' : 'Penjual' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $counterpart?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                        Rp{{ number_format($trx->book?->price ?? $trx->price ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = match($trx->status) {
                                                'completed' => 'bg-green-50 text-green-600',
                                                'pending'   => 'bg-yellow-50 text-yellow-600',
                                                'cancelled' => 'bg-red-50 text-red-600',
                                                default     => 'bg-gray-100 text-gray-600',
                                            };
                                            $statusLabel = match($trx->status) {
                                                'completed' => 'Selesai',
                                                'pending'   => 'Diproses',
                                                'cancelled' => 'Dibatalkan',
                                                default     => ucfirst($trx->status),
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $trx->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>