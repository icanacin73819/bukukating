<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jual Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-8">

                <h3 class="text-2xl font-bold mb-6">
                    Tambahkan Buku Baru
                </h3>

                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">

                        {{-- Judul Buku --}}
                        <div>
                            <label class="font-medium">Judul Buku</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('title') border-red-500 @enderror"
                                placeholder="Contoh: Pemrograman Web Laravel">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Penulis --}}
                        <div>
                            <label class="font-medium">Penulis</label>
                            <input
                                type="text"
                                name="author"
                                value="{{ old('author') }}"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('author') border-red-500 @enderror"
                                placeholder="Nama penulis">
                            @error('author') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="font-medium">Harga</label>
                            <input
                                type="number"
                                name="price"
                                value="{{ old('price') }}"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('price') border-red-500 @enderror"
                                placeholder="50000">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Format Buku --}}
                        <div>
                            <label class="font-medium">Format Buku</label>
                            <select name="format" class="w-full mt-2 border-gray-300 rounded-lg @error('format') border-red-500 @enderror">
                                <option value="fisik" {{ old('format') == 'fisik' ? 'selected' : '' }}>Fisik</option>
                                <option value="ebook" {{ old('format') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                            </select>
                            @error('format') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Kondisi --}}
                        <div>
                            <label class="font-medium">Kondisi</label>
                            <select name="condition" class="w-full mt-2 border-gray-300 rounded-lg @error('condition') border-red-500 @enderror">
                                <option value="sangat_bagus" {{ old('condition') == 'sangat_bagus' ? 'selected' : '' }}>Sangat Bagus</option>
                                <option value="bagus" {{ old('condition') == 'bagus' ? 'selected' : '' }}>Bagus</option>
                                <option value="cukup" {{ old('condition') == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="kurang" {{ old('condition') == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                <option value="digital" {{ old('condition') == 'digital' ? 'selected' : '' }}>Digital</option>
                            </select>
                            @error('condition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Kategori Buku --}}
                        <div>
                            <label class="font-medium">Kategori Buku</label>
                            <select name="category_id" class="w-full mt-2 border-gray-300 rounded-lg @error('category_id') border-red-500 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Fakultas --}}
                        <div>
                            <label class="font-medium">Fakultas</label>
                            <select name="faculty_id" class="w-full mt-2 border-gray-300 rounded-lg @error('faculty_id') border-red-500 @enderror">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('faculty_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="font-medium">Program Studi</label>
                            <select name="study_program_id" class="w-full mt-2 border-gray-300 rounded-lg @error('study_program_id') border-red-500 @enderror">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->id }}" {{ old('study_program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('study_program_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Catatan Kondisi --}}
                        <div class="col-span-2">
                            <label class="font-medium">Catatan Kondisi</label>
                            <textarea
                                name="condition_note"
                                rows="3"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('condition_note') border-red-500 @enderror"
                                placeholder="Contoh: Ada sedikit lipatan di pojok kanan bawah...">{{ old('condition_note') }}</textarea>
                            @error('condition_note') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Kota --}}
                        <div>
                            <label class="font-medium">Kota</label>
                            <input
                                type="text"
                                name="city"
                                value="{{ old('city') }}"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('city') border-red-500 @enderror"
                                placeholder="Contoh: Malang">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label class="font-medium">Nomor WhatsApp</label>
                            <input
                                type="text"
                                name="whatsapp"
                                value="{{ old('whatsapp') }}"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('whatsapp') border-red-500 @enderror"
                                placeholder="Contoh: 081234567890">
                            @error('whatsapp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Detail Lokasi COD --}}
                        <div class="col-span-2">
                            <label class="font-medium">Detail Lokasi COD</label>
                            <textarea
                                name="location_note"
                                rows="3"
                                class="w-full mt-2 border-gray-300 rounded-lg @error('location_note') border-red-500 @enderror"
                                placeholder="Contoh: Depan Gerbang Utama Kampus 1, jam istirahat kuliah...">{{ old('location_note') }}</textarea>
                            @error('location_note') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    {{-- Deskripsi Buku --}}
                    <div class="mt-6">
                        <label class="font-medium">Deskripsi Buku</label>
                        <textarea
                            name="description"
                            rows="5"
                            class="w-full mt-2 border-gray-300 rounded-lg @error('description') border-red-500 @enderror"
                            placeholder="Deskripsi sinopsis atau info tambahan buku...">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Upload Foto Buku --}}
                    <div class="mt-6">
                        <label class="font-medium">Foto Buku</label>
                        <input
                            type="file"
                            name="images[]"
                            multiple
                            class="block w-full mt-2 border border-gray-300 rounded-lg p-2 @error('images') border-red-500 @enderror">
                        <small class="text-gray-500">
                            Kamu dapat memilih lebih dari satu gambar.
                        </small>
                        @error('images')
                            <br><span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Promosi Banner --}}
                    <div class="mt-8 border rounded-xl p-6 bg-blue-50">

                        <h3 class="text-lg font-bold text-blue-700 mb-2">
                            🚀 Promosikan Buku
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            Ingin buku kamu tampil di banner utama BukuKating?
                            Pilih paket promosi di bawah ini.
                        </p>

                        <div class="space-y-4">

                            <label class="flex items-center gap-2">
                                <input type="radio"
                                       name="promotion"
                                       value="0"
                                       checked
                                       onchange="togglePromotion()">
                                Tidak, saya tidak ingin promosi.
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio"
                                       name="promotion"
                                       value="1"
                                       onchange="togglePromotion()">
                                Ya, saya ingin promosi.
                            </label>

                        </div>

                        <div id="promotion-box" class="hidden mt-6">

                            <label class="font-medium">
                                Paket Promosi
                            </label>

                            <select
                                name="duration_days"
                                class="w-full mt-2 border-gray-300 rounded-lg">
                                <option value="3">3 Hari - Rp10.000</option>
                                <option value="7">7 Hari - Rp20.000</option>
                                <option value="30">30 Hari - Rp50.000</option>
                            </select>

                            <label class="font-medium block mt-4">
                                Metode Pembayaran
                            </label>

                            <select
                                name="payment_method"
                                class="w-full mt-2 border-gray-300 rounded-lg">
                                <option value="seabank">SeaBank</option>
                                <option value="bri">BRI</option>
                                <option value="bsi">BSI</option>
                                <option value="dana">DANA</option>
                                <option value="gopay">GoPay</option>
                            </select>

                        </div>

                    </div>

                    {{-- Tombol Submit --}}
                    <div class="mt-8">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                            Simpan Buku
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
    function togglePromotion() {

        let yes =
            document.querySelector(
                'input[name="promotion"][value="1"]'
            );

        let box =
            document.getElementById("promotion-box");

        if (yes.checked) {
            box.classList.remove("hidden");
        } else {
            box.classList.add("hidden");
        }

    }

    document.addEventListener("DOMContentLoaded", togglePromotion);
    </script>
</x-app-layout>