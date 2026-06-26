<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pembayaran Promosi
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8">

            <h1 class="text-2xl font-bold mb-2">
                Promosikan Buku
            </h1>

            <p class="text-gray-600 mb-6">
                Silakan transfer sesuai nominal berikut.
            </p>

            <div class="bg-blue-50 rounded-lg p-4 mb-6">

                <p>
                    <b>Judul Buku :</b>
                    {{ $bannerOrder->book->title }}
                </p>

                <p>
                    <b>Durasi :</b>
                    {{ $bannerOrder->duration_days }} Hari
                </p>

                <p class="text-xl font-bold text-blue-600 mt-3">
                    Rp{{ number_format($bannerOrder->price,0,',','.') }}
                </p>

            </div>

            <div class="space-y-3 mb-8">

                <div>
                    <b>SeaBank</b><br>
                    901234567890
                </div>

                <div>
                    <b>BRI</b><br>
                    1234567890
                </div>

                <div>
                    <b>BSI</b><br>
                    9876543210
                </div>

                <div>
                    <b>DANA</b><br>
                    081234567890
                </div>

                <div>
                    <b>GoPay</b><br>
                    081234567890
                </div>

            </div>

            <form
                method="POST"
                action="{{ route('banner.upload',$bannerOrder) }}"
                enctype="multipart/form-data">

                @csrf

                <label class="font-medium">
                    Upload Bukti Transfer
                </label>

                <input
                    type="file"
                    name="payment_proof"
                    class="block w-full mt-2 border rounded-lg p-2">

                @error('payment_proof')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <button
                    class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg">

                    Kirim Bukti Pembayaran

                </button>

            </form>

        </div>

    </div>

</x-app-layout>