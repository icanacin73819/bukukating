<x-admin-layout title="Approval Mahasiswa">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Approval Mahasiswa</h2>
            <p class="text-sm text-gray-400 mt-0.5">Daftar mahasiswa yang menunggu persetujuan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. WA</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">KTM</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $i => $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $user->email }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $user->nim ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-gray-500">{{ $user->phone ?? '-' }}</td>

                    {{-- KTM --}}
                    <td class="px-5 py-3.5 text-center">
                        @if($user->ktm)
                            <a href="{{ asset('storage/' . $user->ktm) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                                🪪 Lihat KTM
                            </a>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-3.5">
                        @if($user->status === 'pending')
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                        @elseif($user->status === 'aktif')
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-600">Ditolak</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-3.5">
                        <div class="flex justify-center gap-2">
                            @if($user->status === 'pending')
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                        ✔ Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-3 py-1.5 text-xs bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                        ✖ Reject
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
                    <td colspan="8" class="px-5 py-10 text-center text-gray-400">
                        Tidak ada mahasiswa yang menunggu approval.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>