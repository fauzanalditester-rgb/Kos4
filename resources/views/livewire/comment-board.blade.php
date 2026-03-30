<div wire:poll.5s class="max-w-3xl mx-auto">
    <!-- Comment Form -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 sm:p-8 mb-8">
        <form wire:submit="submit" class="space-y-4">
            <div>
                <input type="text" wire:model="user_name" placeholder="Nama Anda"
                    class="w-full bg-slate-50 border-0 border-b-2 border-transparent focus:bg-white focus:border-amber-400 focus:ring-0 px-4 py-3 rounded-t-xl text-sm text-slate-900 font-medium transition-colors">
                @error('user_name') <span class="text-xs text-red-500 font-medium mt-1 pl-4">{{ $message }}</span> @enderror
            </div>
            <div>
                <textarea wire:model="text" rows="3" placeholder="Tulis komentar atau tanya sesuatu..."
                    class="w-full bg-slate-50 border-0 border-b-2 border-transparent focus:bg-white focus:border-amber-400 focus:ring-0 px-4 py-3 rounded-t-xl text-sm text-slate-900 transition-colors resize-none"></textarea>
                @error('text') <span class="text-xs text-red-500 font-medium mt-1 pl-4">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-8 py-3 bg-slate-900 text-white rounded-full text-sm font-bold tracking-wide hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse($comments as $comment)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-bold text-slate-600">{{ strtoupper(substr($comment->user_name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="text-sm font-extrabold text-slate-900">{{ $comment->user_name }}</span>
                            <span class="text-xs font-medium text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed mb-1">{{ $comment->text }}</p>

                        <!-- Admin Replies -->
                        @foreach($comment->replies as $reply)
                            <div class="mt-4 bg-slate-50 rounded-2xl p-4 border border-slate-100 relative">
                                <div class="absolute -left-2 top-4 w-4 h-4 bg-slate-50 border-l border-b border-slate-100 transform rotate-45"></div>
                                <div class="relative z-10">
                                    <div class="flex items-baseline gap-2 mb-1.5">
                                        <span class="text-sm font-extrabold text-slate-900">{{ $reply->user_name }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wide bg-amber-100 text-amber-700 uppercase">
                                            Owner
                                        </span>
                                        <span class="text-[10px] font-medium text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700 leading-relaxed">{{ $reply->text }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 px-6 border-2 border-dashed border-slate-200 rounded-3xl bg-white">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                </div>
                <h4 class="text-sm font-bold text-slate-700 mb-1">Belum ada diskusi</h4>
                <p class="text-xs text-slate-500">Mulai percakapan dengan menanyakan apapun mengenai fasilitas atau ketersediaan.</p>
            </div>
        @endforelse
    </div>
</div>
