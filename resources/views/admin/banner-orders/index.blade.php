<x-admin-layout title="Kelola Banner Promosi">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kelola Banner Promosi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Approval pengajuan banner dari mahasiswa</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemilik</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bannerOrders as $banner)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5 font-medium text-gray-800">{{ $banner->book->title }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $banner->user->name }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $banner->duration_days }} Hari</td>
                    <td class="px-5 py-3.5 text-gray-800">Rp{{ number_format($banner->price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ strtoupper($banner->payment_method) }}</td>
                    <td class="px-5 py-3.5">
                        @if($banner->status === 'pending')
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                        @elseif($banner->status === 'approved')
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Approved</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-600">Rejected</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        @if($banner->payment_proof)
                            <a href="{{ asset('storage/' . $banner->payment_proof) }}" target="_blank"
                               class="text-blue-600 hover:underline text-xs">Lihat</a>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-2 justify-center">
                            @if($banner->status === 'pending')
                                <form action="{{ route('admin.banner-orders.approve', $banner) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.banner-orders.reject', $banner) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 text-xs bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                        Reject
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-gray-400">Belum ada pengajuan banner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($bannerOrders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $bannerOrders->links() }}
        </div>
        @endif
    </div>

</x-admin-layout>