<div>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Moderasi Komentar</h1>

    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-3 flex-1">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-gray-600">{{ strtoupper(substr($comment->user_name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-900">{{ $comment->user_name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $comment->text }}</p>

                            <!-- Existing Replies -->
                            @foreach($comment->replies as $reply)
                                <div class="mt-3 ml-2 pl-4 border-l-2 border-amber-300 bg-amber-50/50 rounded-r-lg p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-bold text-amber-700">{{ $reply->user_name }}</span>
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Owner</span>
                                        <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $reply->text }}</p>
                                </div>
                            @endforeach

                            <!-- Reply Form -->
                            @if($replyingTo === $comment->id)
                                <div class="mt-3 flex gap-2">
                                    <input type="text" wire:model="replyText" wire:keydown.enter="submitReply" placeholder="Tulis balasan..."
                                        class="flex-1 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                    <button wire:click="submitReply" class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-semibold hover:bg-amber-600 transition">Balas</button>
                                    <button wire:click="cancelReply" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">Batal</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @if($replyingTo !== $comment->id)
                            <button wire:click="reply({{ $comment->id }})" class="text-amber-600 hover:text-amber-700 text-xs font-medium">Balas</button>
                        @endif
                        <button wire:click="delete({{ $comment->id }})" wire:confirm="Yakin hapus komentar ini beserta balasannya?" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                <p class="text-gray-500">Belum ada komentar</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</div>
