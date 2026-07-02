<x-wo-layout>
    <div class="space-y-6" x-data="{
        tab: 'hero',
        portfolio: {{ json_encode($settings['portfolio'] ?? []) }},
        testimonials: {{ json_encode($settings['testimonials'] ?? []) }},
        addPortfolio() {
            this.portfolio.push({ title: '', category: 'Decoration', image: '' });
        },
        removePortfolio(index) {
            this.portfolio.splice(index, 1);
        },
        addTestimonial() {
            this.testimonials.push({ client_name: '', quote: '', wedding_date: '', rating: 5 });
        },
        removeTestimonial(index) {
            this.testimonials.splice(index, 1);
        }
    }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Landing Page Settings</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sesuaikan informasi publik, gambar hero, portofolio, dan ulasan pada halaman promosi publik Anda.</p>
            </div>
            
            <a href="{{ route('public.wo.show', $wo->slug) }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-150 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold py-2.5 px-4 rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Halaman Publik
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 text-xs rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-850 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden grid grid-cols-1 lg:grid-cols-4 min-h-[500px]">
            <!-- Tabs Sidebar -->
            <div class="border-r border-gray-100 dark:border-gray-700/50 p-4 bg-gray-50/50 dark:bg-gray-900/10 space-y-1">
                <button @click="tab = 'hero'" :class="tab === 'hero' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                    <span>Hero Section</span>
                </button>
                <button @click="tab = 'about'" :class="tab === 'about' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>About Section</span>
                </button>
                <button @click="tab = 'portfolio'" :class="tab === 'portfolio' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span>Portofolio Gallery</span>
                </button>
                <button @click="tab = 'testimonials'" :class="tab === 'testimonials' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <span>Testimoni Ulasan</span>
                </button>
                <button @click="tab = 'why_choose'" :class="tab === 'why_choose' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span>Why Choose Us</span>
                </button>
                <button @click="tab = 'commitment'" :class="tab === 'commitment' ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left px-4 py-2.5 rounded-xl text-xs flex items-center gap-2.5 transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <span>Our Commitment</span>
                </button>
            </div>

            <!-- Tabs Content Form -->
            <form method="POST" action="{{ route('wo.landing_page.update') }}" enctype="multipart/form-data" class="lg:col-span-3 p-6 flex flex-col justify-between">
                @csrf
                @method('PUT')

                <!-- Inner Content Container -->
                <div class="space-y-6">
                    <!-- HERO TAB -->
                    <div x-show="tab === 'hero'" class="space-y-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                            Hero Section Customization
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Hero Title</label>
                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Crafting Unforgettable Love Stories' }}" placeholder="Contoh: Crafting Unforgettable Love Stories" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Hero Subtitle / Description</label>
                                <textarea name="hero_description" placeholder="Deskripsi singkat mengenai layanan WO Anda di halaman utama." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-24 resize-none">{{ $settings['hero_description'] ?? 'Kami merancang dan mengawal setiap detail hari bahagia Anda.' }}</textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Upload New Hero Background Image (Opsional)</label>
                                <input type="file" name="hero_image" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                @if($settings['hero_image'] ?? null)
                                    <div class="mt-2 flex items-center gap-2">
                                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" class="w-16 h-10 object-cover rounded-lg border border-gray-200 shadow-sm">
                                        <span class="text-[10px] text-gray-400">Background Terunggah Saat Ini</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ABOUT TAB -->
                    <div x-show="tab === 'about'" class="space-y-4" style="display: none;">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            About Section Customization
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">About Section Title</label>
                                <input type="text" name="about_title" value="{{ $settings['about_title'] ?? 'The Minds Behind Your Perfect Day' }}" placeholder="Contoh: The Minds Behind Your Perfect Day" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">About Section Description</label>
                                <textarea name="about_description" placeholder="Jelaskan mengenai visi, komitmen, dan kelebihan tim WO Anda..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-36 resize-none">{{ $settings['about_description'] ?? 'Kami adalah tim wedding planner dan organizer berdedikasi...' }}</textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Upload New About Section Images (Opsional, Maksimal 3 foto untuk diposisikan random)</label>
                                <input type="file" name="about_images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                @if(isset($settings['about_images']) && is_array($settings['about_images']) && count($settings['about_images']) > 0)
                                    <div class="mt-2 space-y-1">
                                        <span class="text-[10px] text-gray-400 block font-bold">Foto Terunggah Saat Ini:</span>
                                        <div class="flex gap-2 flex-wrap">
                                            @foreach($settings['about_images'] as $img)
                                                <img src="{{ asset('storage/' . $img) }}" class="w-14 h-14 object-cover rounded-full border border-gray-200 shadow-sm">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- PORTFOLIO TAB -->
                    <div x-show="tab === 'portfolio'" class="space-y-4" style="display: none;">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Portofolio Gallery Items
                            </h3>
                            <button type="button" @click="addPortfolio()" class="bg-pink-500 hover:bg-pink-600 text-white text-[10px] font-bold py-1.5 px-3 rounded-lg shadow-sm transition-colors">
                                + Tambah Item
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in portfolio" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl border border-gray-100 dark:border-gray-800 grid grid-cols-1 md:grid-cols-3 gap-3 relative">
                                    <div>
                                        <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Judul Portofolio</label>
                                        <input type="text" :name="'portfolio['+index+'][title]'" x-model="item.title" placeholder="Contoh: Rustic Wedding" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                    </div>
                                    <div>
                                        <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Kategori</label>
                                        <select :name="'portfolio['+index+'][category]'" x-model="item.category" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                            <option value="Decoration">Decoration</option>
                                            <option value="Traditional">Traditional</option>
                                            <option value="Reception">Reception</option>
                                            <option value="Akad">Akad</option>
                                            <option value="Ceremony">Ceremony</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end gap-2">
                                        <div class="flex-1">
                                            <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Unggah Foto Portofolio</label>
                                            <input type="file" :name="'portfolio_images['+index+']'" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                            <!-- Retain existing image path -->
                                            <input type="hidden" :name="'portfolio['+index+'][image]'" x-model="item.image">
                                            <template x-if="item.image">
                                                <div class="mt-1 flex items-center gap-1.5">
                                                    <img :src="item.image.startsWith('http') ? item.image : '/storage/' + item.image" class="w-7 h-7 object-cover rounded-lg border border-gray-255">
                                                    <span class="text-[8px] text-gray-400">Terunggah</span>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="removePortfolio(index)" class="bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 p-2 rounded-lg transition-colors shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- TESTIMONIALS TAB -->
                    <div x-show="tab === 'testimonials'" class="space-y-4" style="display: none;">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Testimoni &amp; Ulasan Klien
                            </h3>
                            <button type="button" @click="addTestimonial()" class="bg-pink-500 hover:bg-pink-600 text-white text-[10px] font-bold py-1.5 px-3 rounded-lg shadow-sm transition-colors">
                                + Tambah Testimoni
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in testimonials" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl border border-gray-100 dark:border-gray-800 grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <div>
                                        <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Nama Klien</label>
                                        <input type="text" :name="'testimonials['+index+'][client_name]'" x-model="item.client_name" placeholder="Aditya & Dinda" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                    </div>
                                    <div>
                                        <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Tanggal Pernikahan</label>
                                        <input type="text" :name="'testimonials['+index+'][wedding_date]'" x-model="item.wedding_date" placeholder="12 Des 2026" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                    </div>
                                    <div>
                                        <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Ulasan/Quote</label>
                                        <input type="text" :name="'testimonials['+index+'][quote]'" x-model="item.quote" placeholder="Sangat puas..." class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                    </div>
                                    <div class="flex items-end gap-2">
                                        <div class="flex-1">
                                            <label class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Rating (1-5)</label>
                                            <input type="number" min="1" max="5" :name="'testimonials['+index+'][rating]'" x-model="item.rating" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white transition-all">
                                        </div>
                                        <button type="button" @click="removeTestimonial(index)" class="bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 p-2 rounded-lg transition-colors shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                    <!-- WHY CHOOSE US TAB -->
                    <div x-show="tab === 'why_choose'" class="space-y-4" style="display: none;">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm pb-1 border-b border-gray-100 dark:border-gray-700">Why Choose Us Section</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Heading Utama</label>
                                <input type="text" name="why_title" value="{{ $settings['why_title'] ?? 'An unforgettable saga at your absolute dream' }}" placeholder="Contoh: An unforgettable saga at your absolute dream" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Deskripsi</label>
                                <textarea name="why_description" placeholder="Jelaskan keunggulan dan pengalaman WO Anda..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-24 resize-none">{{ $settings['why_description'] ?? 'Dengan pengalaman mengelola ratusan acara pernikahan, kami menjamin setiap detail dieksekusi dengan kualitas terbaik.' }}</textarea>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 dark:bg-gray-900/30 p-3 rounded-xl border border-gray-100 dark:border-gray-800 space-y-2">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Stat 1 — Angka</label>
                                    <input type="text" name="why_stat1_value" value="{{ $settings['why_stat1_value'] ?? '150+' }}" placeholder="150+" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Label</label>
                                    <input type="text" name="why_stat1_label" value="{{ $settings['why_stat1_label'] ?? 'Wedding' }}" placeholder="Wedding" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900/30 p-3 rounded-xl border border-gray-100 dark:border-gray-800 space-y-2">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Stat 2 — Angka</label>
                                    <input type="text" name="why_stat2_value" value="{{ $settings['why_stat2_value'] ?? '99%' }}" placeholder="99%" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Label</label>
                                    <input type="text" name="why_stat2_label" value="{{ $settings['why_stat2_label'] ?? 'Satisfaction' }}" placeholder="Satisfaction" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900/30 p-3 rounded-xl border border-gray-100 dark:border-gray-800 space-y-2">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Stat 3 — Angka</label>
                                    <input type="text" name="why_stat3_value" value="{{ $settings['why_stat3_value'] ?? '5+' }}" placeholder="5+" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                    <label class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">Label</label>
                                    <input type="text" name="why_stat3_label" value="{{ $settings['why_stat3_label'] ?? 'Years' }}" placeholder="Years" class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg py-1.5 px-3 text-xs focus:outline-none text-gray-900 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Upload Foto Dekorasi (Opsional, Maks. 3 foto)</label>
                                <input type="file" name="why_images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                @if(isset($settings['why_images']) && is_array($settings['why_images']) && count($settings['why_images']) > 0)
                                    <div class="mt-2 space-y-1">
                                        <span class="text-[10px] text-gray-400 block font-bold">Foto Terunggah Saat Ini:</span>
                                        <div class="flex gap-2 flex-wrap">
                                            @foreach($settings['why_images'] as $img)
                                                <img src="{{ asset('storage/' . $img) }}" class="w-14 h-14 object-cover rounded-full border border-gray-200 shadow-sm">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- COMMITMENT TAB -->
                    <div x-show="tab === 'commitment'" class="space-y-4" style="display: none;">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            Our Commitment Section
                        </h3>

                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Heading Utama</label>
                                <input type="text" name="commitment_title" value="{{ $settings['commitment_title'] ?? 'Your Vision, Our Flawless Execution' }}" placeholder="Contoh: Your Vision, Our Flawless Execution" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Deskripsi</label>
                                <textarea name="commitment_description" placeholder="Jelaskan komitmen dan nilai WO Anda terhadap para klien..." class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all h-24 resize-none">{{ $settings['commitment_description'] ?? 'Setiap pasangan memiliki cerita unik. Kami mendengarkan, memahami, dan mewujudkan setiap visi menjadi kenyataan yang melampaui ekspektasi.' }}</textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Upload Foto Dekorasi (Opsional, Maks. 3 foto)</label>
                                <input type="file" name="commitment_images[]" multiple class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl py-2 px-4 text-xs focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-900 dark:text-white transition-all">
                                @if(isset($settings['commitment_images']) && is_array($settings['commitment_images']) && count($settings['commitment_images']) > 0)
                                    <div class="mt-2 space-y-1">
                                        <span class="text-[10px] text-gray-400 block font-bold">Foto Terunggah Saat Ini:</span>
                                        <div class="flex gap-2 flex-wrap">
                                            @foreach($settings['commitment_images'] as $img)
                                                <img src="{{ asset('storage/' . $img) }}" class="w-14 h-14 object-cover rounded-full border border-gray-200 shadow-sm">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                <!-- Footer Action Buttons -->
                <div class="border-t border-gray-100 dark:border-gray-750 pt-4 mt-6 flex justify-end gap-3">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl shadow-md transition-colors">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-wo-layout>
