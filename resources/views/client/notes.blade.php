<x-client-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl font-extrabold text-gray-950 dark:text-white tracking-tight">Papan Komunikasi & Catatan WO</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kirim catatan, masukan, dan berkas referensi/inspirasi dekorasi/acara langsung kepada tim WO.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Message Stream List -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col h-[500px]">
                <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/10">
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm">Riwayat Catatan & Komunikasi</h3>
                </div>

                <!-- Notes Stream -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    @forelse($notes as $note)
                        @php
                            $isMe = $note->user_id === auth()->id();
                        @endphp
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] space-y-1">
                                <!-- Sender details -->
                                <span class="text-[10px] text-gray-400 block {{ $isMe ? 'text-right' : 'text-left' }}">
                                    {{ $note->user->name }} ({{ strtoupper($note->user->role) }}) • {{ $note->created_at->format('d M H:i') }}
                                </span>
                                
                                <!-- Message bubble -->
                                <div class="p-3.5 rounded-2xl text-xs shadow-sm 
                                    {{ $isMe ? 'bg-purple-600 text-white rounded-tr-none' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-tl-none' }}">
                                    <p class="leading-relaxed whitespace-pre-wrap">{{ $note->message }}</p>

                                    <!-- Attached Reference File -->
                                    @if($note->file_path)
                                        <div class="mt-2.5 pt-2.5 border-t {{ $isMe ? 'border-purple-500' : 'border-gray-200 dark:border-gray-600' }} flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-1.5 min-w-0">
                                                <svg class="w-4 h-4 shrink-0 {{ $isMe ? 'text-purple-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                <span class="truncate block font-bold text-[10px] {{ $isMe ? 'text-purple-100' : 'text-gray-500' }}">{{ $note->file_name ?? 'Attachment' }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $note->file_path) }}" target="_blank" class="shrink-0 text-[10px] font-bold underline {{ $isMe ? 'text-white hover:text-purple-200' : 'text-purple-600 dark:text-purple-400' }}">Unduh</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 text-gray-400 text-xs">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-655 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Belum ada pesan/catatan terkirim. Tulis catatan Anda di form sebelah kanan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Send New Note Form -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm h-fit space-y-4">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm border-b border-gray-50 dark:border-gray-700/50 pb-3">Kirim Catatan Baru</h3>
                
                <form method="POST" action="{{ route('client.notes.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">Pesan / Catatan</label>
                        <textarea name="message" required placeholder="Tulis masukan, ide, request lagu, menu makanan, perubahan alamat, dll..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none text-gray-900 dark:text-white transition-all h-32 resize-none"></textarea>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1.5">File Referensi / Inspirasi (Opsional)</label>
                        <input type="file" name="reference_file" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                        <p class="text-[9px] text-gray-400 mt-1">Format didukung: Gambar, PDF, Dokumen (Max 5MB).</p>
                    </div>

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2.5 px-5 rounded-xl shadow-md transition-all">
                        Kirim Catatan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-client-layout>
