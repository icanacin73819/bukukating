@if(auth()->check() && auth()->user()->role === 'admin')
<x-admin-layout title="Detail Buku">

    <div class="mb-4">
        <a href="{{ route('admin.books.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke Kelola Buku</a>
    </div>

    @include('books._detail', ['isAdmin' => true])

</x-admin-layout>
@else
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">Detail Buku</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto">
            @include('books._detail', ['isAdmin' => false])
        </div>
    </div>

</x-app-layout>
@endif