<x-admin-layout title="Riwayat Transaksi">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua transaksi yang telah terjadi</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Penjual</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3.5 font-medium text-gray-800">{{ $trx->book?->title ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $trx->seller?->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ strtoupper($trx->method) }}</td>
                    <td class="px-5 py-3.5">
                        @php
                            $statusColor = match($trx->status) {
                                'completed' => 'bg-green-100 text-green-700',
                                'pending'   => 'bg-yellow-100 text-yellow-700',
                                'cancelled' => 'bg-red-100 text-red-600',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-400 text-xs">
                        {{ optional($trx->completed_at)->format('d M Y H:i') ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>