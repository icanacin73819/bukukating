<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Pesan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow divide-y">
                @forelse($threads as $thread)
                    <a href="{{ route('chat.show', [$thread['book']->id, $thread['other_user']->id]) }}"
                        class="flex items-center justify-between p-4 hover:bg-gray-50">
                        <div>
                            <p class="font-semibold">{{ $thread['other_user']->name }}</p>
                            <p class="text-sm text-gray-500">{{ $thread['book']->title }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($thread['last_message']->body, 60) }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $thread['last_message']->created_at->diffForHumans() }}</span>
                    </a>
                @empty
                    <p class="p-6 text-gray-500">Belum ada percakapan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>