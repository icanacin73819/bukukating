<x-admin-layout title="Dashboard">

    {{-- ── Summary Cards ─────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        @php
        $cards = [
            ['label' => 'Mahasiswa',        'value' => $totalUsers,        'color' => 'text-gray-800',   'bg' => 'bg-gray-50',   'icon' => '🎓'],
            ['label' => 'Total Buku',        'value' => $totalBooks,        'color' => 'text-gray-800',   'bg' => 'bg-gray-50',   'icon' => '📚'],
            ['label' => 'Buku Tersedia',     'value' => $availableBooks,    'color' => 'text-green-600',  'bg' => 'bg-green-50',  'icon' => '✅'],
            ['label' => 'Buku Terjual',      'value' => $soldBooks,         'color' => 'text-red-500',    'bg' => 'bg-red-50',    'icon' => '🛒'],
            ['label' => 'Pending Approval',  'value' => $pendingUsers,      'color' => 'text-yellow-600', 'bg' => 'bg-yellow-50', 'icon' => '⏳'],
            ['label' => 'Banner Pending',    'value' => $pendingBanners,    'color' => 'text-orange-500', 'bg' => 'bg-orange-50', 'icon' => '🕐'],
            ['label' => 'Banner Aktif',      'value' => $activeBanners,     'color' => 'text-blue-600',   'bg' => 'bg-blue-50',   'icon' => '📢'],
            ['label' => 'Pendapatan Banner', 'value' => 'Rp'.number_format($totalBannerRevenue,0,',','.'), 'color' => 'text-purple-600', 'bg' => 'bg-purple-50', 'icon' => '💰'],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-start gap-4">
            <div class="text-2xl {{ $card['bg'] }} w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0">
                {{ $card['icon'] }}
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">{{ $card['label'] }}</p>
                <p class="text-2xl font-bold {{ $card['color'] }} mt-0.5 leading-tight">{{ $card['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Charts ──────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Grafik Transaksi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Transaksi per Bulan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">12 bulan terakhir</p>
                </div>
                <span class="text-2xl">📈</span>
            </div>
            <canvas id="transactionChart" height="120"></canvas>
        </div>

        {{-- Grafik Buku --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Buku Terdaftar per Bulan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">12 bulan terakhir</p>
                </div>
                <span class="text-2xl">📖</span>
            </div>
            <canvas id="bookChart" height="120"></canvas>
        </div>
    </div>

    {{-- Chart.js Script --}}
    @push('scripts')
    <script>
        const labels = @json($monthLabels);
        const txData = @json($transactionData);
        const bkData = @json($bookData);

        const chartDefaults = {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: '#f3f4f6' }
                },
                x: { grid: { display: false } }
            }
        };

        new Chart(document.getElementById('transactionChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data: txData,
                    backgroundColor: 'rgba(59,130,246,0.15)',
                    borderColor: 'rgba(59,130,246,1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: chartDefaults
        });

        new Chart(document.getElementById('bookChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data: bkData,
                    borderColor: 'rgba(16,185,129,1)',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(16,185,129,1)',
                    pointRadius: 4,
                }]
            },
            options: chartDefaults
        });
    </script>
    @endpush

</x-admin-layout>