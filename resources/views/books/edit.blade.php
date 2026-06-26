<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-8">

                <h3 class="text-2xl font-bold mb-6 text-gray-800">
                    Edit Buku
                </h3>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Judul Buku --}}
                        <div>
                            <label class="font-medium text-gray-700">Judul Buku</label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm @error('title') border-red-500 @enderror">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Penulis --}}
                        <div>
                            <label class="font-medium text-gray-700">Penulis</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm @error('author') border-red-500 @enderror">
                            @error('author') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="font-medium text-gray-700">Harga</label>
                            <input type="number" name="price" value="{{ old('price', $book->price) }}" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm @error('price') border-red-500 @enderror">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Format Buku --}}
                        <div>
                            <label class="font-medium text-gray-700">Format Buku</label>
                            <select name="format" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="fisik" {{ old('format', $book->format) == 'fisik' ? 'selected' : '' }}>Fisik</option>
                                <option value="ebook" {{ old('format', $book->format) == 'ebook' ? 'selected' : '' }}>E-Book</option>
                            </select>
                        </div>

                        {{-- Kondisi --}}
                        <div>
                            <label class="font-medium text-gray-700">Kondisi</label>
                            <select name="condition" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="sangat_bagus" {{ old('condition', $book->condition) == 'sangat_bagus' ? 'selected' : '' }}>Sangat Bagus</option>
                                <option value="bagus" {{ old('condition', $book->condition) == 'bagus' ? 'selected' : '' }}>Bagus</option>
                                <option value="cukup" {{ old('condition', $book->condition) == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="kurang" {{ old('condition', $book->condition) == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                <option value="digital" {{ old('condition', $book->condition) == 'digital' ? 'selected' : '' }}>Digital</option>
                            </select>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="font-medium text-gray-700">Kategori</label>
                            <select name="category_id" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fakultas --}}
                        <div>
                            <label class="font-medium text-gray-700">Fakultas</label>
                            <select name="faculty_id" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id', $book->faculty_id) == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="font-medium text-gray-700">Program Studi</label>
                            <select name="study_program_id" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->id }}" {{ old('study_program_id', $book->study_program_id) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Catatan Kondisi --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="font-medium text-gray-700">Catatan Kondisi</label>
                            <textarea name="condition_note" rows="2" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">{{ old('condition_note', $book->condition_note) }}</textarea>
                        </div>

                        {{-- Kota & WA --}}
                        <div>
                            <label class="font-medium text-gray-700">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $book->city) }}" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $book->whatsapp) }}" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">
                        </div>

                        {{-- Lokasi COD --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="font-medium text-gray-700">Detail Lokasi COD</label>
                            <textarea name="location_note" rows="2" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">{{ old('location_note', $book->location_note) }}</textarea>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mt-6">
                        <label class="font-medium text-gray-700">Deskripsi Buku</label>
                        <textarea name="description" rows="4" class="w-full mt-2 border-gray-300 rounded-lg shadow-sm">{{ old('description', $book->description) }}</textarea>
                    </div>

                    {{-- FOTO SAAT INI --}}
                    <div class="mt-8">
                        <label class="font-medium text-gray-700 block mb-3">Foto Saat Ini</label>

                        @if($book->images->isEmpty())
                            <p class="text-sm text-gray-400">Belum ada foto untuk buku ini.</p>
                        @else
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                                @foreach($book->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/'.$image->image) }}"
                                             class="w-full h-28 object-cover rounded-lg border">
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-400 mt-2">
                                Mau hapus salah satu foto? Klik tombol 🗑️ di bawah masing-masing foto.
                            </p>
                        @endif
                    </div>

                    {{-- TOMBOL HAPUS PER FOTO (form terpisah karena beda action) --}}
                    @if($book->images->isNotEmpty())
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 -mt-2 mb-6">
                            @foreach($book->images as $image)
                                <form action="{{ route('book-images.destroy', $image) }}" method="POST"
                                      onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-xs bg-red-50 hover:bg-red-100 text-red-600 py-1.5 rounded-lg border border-red-200">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @endif

                    {{-- TAMBAH FOTO BARU --}}
                    <div class="mt-2">
                        <label class="font-medium text-gray-700">Tambah Foto Baru</label>
                        <input
                            type="file"
                            name="images[]"
                            multiple
                            class="block w-full mt-2 border border-gray-300 rounded-lg p-2 @error('images') border-red-500 @enderror">
                        <small class="text-gray-500">
                            Foto baru akan ditambahkan, bukan menggantikan foto lama. Kamu bisa pilih lebih dari satu.
                        </small>
                        @error('images')
                            <br><span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="mt-8 flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Update Buku</button>
                        <a href="{{ route('books.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>