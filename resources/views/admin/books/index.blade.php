<x-admin-layout title="Kelola Buku">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kelola Buku</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua buku yang terdaftar di marketplace</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Penjual</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($books as $i => $book)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5 text-gray-400">{{ $books->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5 font-medium text-gray-800 max-w-xs truncate">{{ $book->title }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $book->user->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $book->category->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-800">Rp{{ number_format($book->price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3.5">
                        @if($book->status === 'tersedia')
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Tersedia</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-600">Terjual</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2 justify-center">
                            <a href="{{ route('books.show', $book->id) }}"
                               class="px-3 py-1.5 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                Lihat
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-gray-400">Belum ada buku terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($books->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $books->links() }}
        </div>
        @endif
    </div>

</x-admin-layout>