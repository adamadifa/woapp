<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ $wo->business_name }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        header {
            transition: background-color 300ms ease-in-out, border-color 300ms ease-in-out, box-shadow 300ms ease-in-out;
        }
    </style>
</head>
<body class="antialiased bg-wo-cream text-wo-brown-text font-sans text-sm">

@php
    $waPhone = preg_replace('/[^0-9]/', '', $wo->phone ?? '6289670444321');
@endphp

<!-- Navbar Header -->
<header id="main-header" class="fixed top-0 left-0 right-0 z-40 bg-transparent border-transparent transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if($wo->logo)
                <img src="{{ asset('storage/' . $wo->logo) }}" alt="Logo" class="w-9 h-9 rounded-full object-cover border border-wo-rose-light">
            @else
                <div class="w-9 h-9 rounded-full bg-wo-rose flex items-center justify-center text-white font-bold text-base font-serif">
                    {{ substr($wo->business_name, 0, 1) }}
                </div>
            @endif
            <span class="brand-name font-extrabold text-lg font-serif tracking-tight text-white drop-shadow-sm transition-colors duration-300">{{ $wo->business_name }}</span>
        </div>

        <nav class="nav-links-container hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wider text-white/95 transition-colors duration-300">
            <a href="#about" class="nav-link hover:text-wo-rose transition-colors">Tentang Kami</a>
            <a href="#packages" class="nav-link hover:text-wo-rose transition-colors">Paket Wedding</a>
            <a href="#dream-wedding" class="nav-link hover:text-wo-rose transition-colors">Rancang Budget</a>
            <a href="#portfolio" class="nav-link hover:text-wo-rose transition-colors">Portofolio</a>
            <a href="#testimonials" class="nav-link hover:text-wo-rose transition-colors">Testimoni</a>
            <a href="#contact" class="nav-link hover:text-wo-rose transition-colors">Kontak</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="#contact" class="cta-btn bg-white text-wo-rose hover:bg-gray-100 text-[10px] font-bold py-2.5 px-4 rounded-full shadow-sm transition-all duration-300 uppercase tracking-wider">Hubungi Kami</a>
        </div>
    </div>
</header>

<!-- ============================================================ -->
<!-- HERO SECTION                                                   -->
<!-- ============================================================ -->
<section class="relative w-full overflow-hidden min-h-[60vh] md:min-h-[70vh] flex items-center justify-center">
    <img src="{{ $heroImage }}"
         alt="Wedding" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-wo-rose/50 via-wo-rose-bg/60 to-wo-cream"></div>

    <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 pt-36 pb-12 md:pt-44 md:pb-16">
        @if($wo->logo)
            <img src="{{ asset('storage/' . $wo->logo) }}" alt="Logo" class="w-16 h-16 rounded-full border-4 border-white shadow-lg object-cover mb-6">
        @else
            <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-wo-rose text-white font-serif font-bold text-2xl flex items-center justify-center mb-6">
                {{ substr($wo->business_name, 0, 1) }}
            </div>
        @endif
        <h1 class="text-4xl md:text-6xl font-bold text-white font-serif leading-tight drop-shadow-lg">
            {!! nl2br(e($heroTitle)) !!}
        </h1>
        <p class="text-white/90 text-sm md:text-base max-w-xl mx-auto leading-relaxed mt-4">
            {{ $heroDescription }}
        </p>
        <div class="flex flex-wrap justify-center gap-4 mt-6">
            <a href="#packages" class="bg-wo-rose text-white font-bold text-xs py-3 px-8 rounded-full shadow-lg uppercase tracking-wider hover:bg-wo-rose-dark transition-colors">Lihat Paket</a>
            <a href="#contact" class="bg-white text-wo-rose font-bold text-xs py-3 px-8 rounded-full shadow-lg uppercase tracking-wider hover:bg-gray-50 transition-colors">Hubungi Kami</a>
        </div>
    </div>

    <div class="hidden lg:block absolute left-8 top-1/3 w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-xl">
        <img src="https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&q=80&w=300" alt="" class="w-full h-full object-cover">
    </div>
    <div class="hidden lg:block absolute right-8 top-1/4 w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl">
        <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&q=80&w=300" alt="" class="w-full h-full object-cover">
    </div>
</section>


<!-- ============================================================ -->
<!-- ABOUT SECTION                                                  -->
<!-- ============================================================ -->
<section id="about" class="bg-wo-cream pt-6 pb-16 md:pt-8 md:pb-24">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="relative flex justify-center items-center" style="min-height: 350px;">
            <div class="w-56 h-56 md:w-64 md:h-64 rounded-full overflow-hidden border-4 border-white shadow-2xl z-10">
                <img src="{{ $aboutImage1 }}" alt="Team" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-2 right-4 md:right-8 w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $aboutImage2 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-4 left-4 md:left-12 w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $aboutImage3 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute w-72 h-72 rounded-full bg-wo-rose-bg -z-10 translate-x-5 -translate-y-4"></div>
        </div>

        <div class="space-y-4">
            <p class="font-script text-2xl text-wo-rose">About {{ $wo->business_name }}</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown leading-tight">
                {!! nl2br(e($aboutTitle)) !!}
            </h2>
            <p class="text-sm leading-relaxed text-wo-brown-light">{{ $aboutDescription }}</p>
            <div class="flex flex-wrap gap-6 pt-2 text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-wo-rose text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="font-semibold">{{ $wo->address ?? 'Ciamis, Jawa Barat' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-wo-rose text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <span class="font-semibold">{{ $wo->phone ?? '-' }}</span>
                </div>
            </div>
            <a href="#contact" class="inline-block mt-4 bg-wo-rose text-white font-bold text-xs py-3 px-8 rounded-full shadow-md uppercase tracking-wider hover:bg-wo-rose-dark transition-colors">Hubungi Kami</a>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- SERVICES / PACKAGES                                            -->
<!-- ============================================================ -->
<section id="packages" class="bg-wo-cream-dark py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-6 space-y-12">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <p class="font-script text-2xl text-wo-rose">Our Services</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown">Bespoke Planning<br>For Your Special Day</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($packages as $pkg)
                <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border border-gray-100 flex flex-col">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=500"
                             alt="{{ $pkg->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="font-bold text-lg font-serif text-wo-brown">{{ $pkg->name }}</h3>
                            <p class="text-xl font-bold font-serif text-wo-rose">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-wo-brown-light leading-relaxed">{{ $pkg->description }}</p>
                            @if($pkg->items && is_array($pkg->items))
                                <ul class="space-y-1.5 text-xs pt-2">
                                    @foreach($pkg->items as $item)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 shrink-0 mt-0.5 text-wo-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @php $waText = urlencode("Halo {$wo->business_name}, saya tertarik dengan paket *{$pkg->name}*. Bisa kirim rinciannya?"); @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank"
                           class="block w-full text-center bg-wo-rose text-white font-bold text-xs py-3 rounded-full shadow-md uppercase tracking-wider hover:bg-wo-rose-dark transition-colors">
                            Konsultasi Paket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-wo-brown-light">Belum ada paket promosi aktif saat ini.</div>
            @endforelse
        </div>
</section>


<!-- ============================================================ -->
<!-- DREAM WEDDING CALCULATOR & PLANNER                            -->
<!-- ============================================================ -->
<section id="dream-wedding" x-data="weddingPlanner()" class="bg-wo-rose-bg/20 py-16 md:py-24 border-y border-wo-rose-light/10">
    <div class="max-w-6xl mx-auto px-6 space-y-12">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <p class="font-script text-2xl text-wo-rose text-center">Dream Wedding Planner</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown text-center">Rancang Pernikahan Impian Anda</h2>
            <p class="text-xs text-wo-brown-light leading-relaxed text-center">
                Pilih kombinasi vendor terbaik Anda sendiri, tentukan paket/variasi, dan hitung estimasi total budget secara langsung.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left: Selection Form -->
            <div class="lg:col-span-7 bg-white p-6 md:p-8 rounded-3xl shadow-md border border-gray-100/50 space-y-6">
                
                <!-- Category Selectors -->
                <div class="space-y-5">
                    @forelse($vendors->groupBy('category') as $category => $categoryVendors)
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-wo-brown uppercase tracking-wider block">{{ $category }}</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Select Vendor Dropdown -->
                                <select 
                                    @change="selectVendor('{{ $category }}', $event.target.value)"
                                    class="w-full bg-wo-cream border border-wo-rose-light/20 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-wo-rose focus:border-wo-rose focus:outline-none text-wo-brown-text transition-all"
                                >
                                    <option value="">-- Pilih Vendor {{ $category }} --</option>
                                    @foreach($categoryVendors as $v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>

                                <!-- Select Package Dropdown (if vendor has packages) -->
                                <div x-show="selectedVendors['{{ $category }}'] && selectedVendors['{{ $category }}'].packages && selectedVendors['{{ $category }}'].packages.length > 0">
                                    <select 
                                        @change="selectPackage('{{ $category }}', $event.target.value)"
                                        class="w-full bg-wo-cream border border-wo-rose-light/20 rounded-xl py-2.5 px-4 text-xs focus:ring-2 focus:ring-wo-rose focus:border-wo-rose focus:outline-none text-wo-brown-text transition-all"
                                    >
                                        <option value="">-- Pilih Variasi/Paket --</option>
                                        <template x-for="pkg in selectedVendors['{{ $category }}'] ? selectedVendors['{{ $category }}'].packages : []">
                                            <option :value="pkg.name" x-text="pkg.name + ' (Rp ' + formatNumber(pkg.price) + ')'"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-wo-brown-light">Belum ada vendor terdaftar untuk WO ini.</div>
                    @endforelse
                </div>

                <!-- Custom Items Section -->
                <div class="pt-6 border-t border-dashed border-gray-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-bold text-wo-brown uppercase tracking-wider">Item Tambahan Lainnya (Opsional)</label>
                        <button type="button" @click="addCustomItem()" class="text-xs text-wo-rose font-bold hover:underline">
                            + Tambah Item
                        </button>
                    </div>

                    <div class="space-y-2">
                        <template x-for="(item, index) in customItems" :key="index">
                            <div class="flex gap-2 items-center">
                                <input type="text" x-model="item.name" placeholder="cth: Sewa Gedung / Sewa Mobil" class="flex-1 bg-wo-cream border border-wo-rose-light/20 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-wo-rose focus:border-wo-rose text-wo-brown-text focus:outline-none transition-all">
                                <input type="number" x-model.number="item.price" placeholder="Harga (Rp)" class="w-32 bg-wo-cream border border-wo-rose-light/20 rounded-xl py-2 px-3 text-xs focus:ring-2 focus:ring-wo-rose focus:border-wo-rose text-wo-brown-text focus:outline-none transition-all">
                                <button type="button" @click="removeCustomItem(index)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Right: Budget Summary -->
            <div class="lg:col-span-5 bg-gradient-to-br from-wo-rose to-rose-600 p-6 md:p-8 rounded-3xl shadow-xl text-white space-y-6 lg:sticky lg:top-24">
                <h3 class="font-bold text-lg font-serif tracking-wide border-b border-white/20 pb-3">Ringkasan Budget</h3>

                <!-- Selected Vendors List -->
                <div class="space-y-3 text-xs min-h-[150px]">
                    <!-- Selected Vendors -->
                    <template x-for="(data, category) in selectedVendors" :key="category">
                        <div x-show="data" class="flex items-center justify-between bg-white/10 p-3 rounded-xl border border-white/5">
                            <div>
                                <span class="text-[9px] uppercase tracking-wider font-extrabold opacity-75 block" x-text="category"></span>
                                <span class="font-bold block" x-text="data.name"></span>
                                <span x-show="data.selectedPackage" class="text-[10px] opacity-90 block" x-text="'Variasi: ' + data.selectedPackage"></span>
                            </div>
                            <span class="font-extrabold" x-text="'Rp ' + formatNumber(data.price)"></span>
                        </div>
                    </template>

                    <!-- Custom Items -->
                    <template x-for="(item, index) in customItems" :key="index">
                        <div x-show="item.name" class="flex items-center justify-between bg-white/10 p-3 rounded-xl border border-white/5">
                            <div>
                                <span class="text-[9px] uppercase tracking-wider font-extrabold opacity-75 block">Kustom</span>
                                <span class="font-bold block" x-text="item.name"></span>
                            </div>
                            <span class="font-extrabold" x-text="'Rp ' + formatNumber(item.price)"></span>
                        </div>
                    </template>

                    <!-- Empty state -->
                    <div x-show="Object.keys(selectedVendors).length === 0 && customItems.length === 0" class="text-center py-12 opacity-80 text-xs italic">
                        Belum ada vendor/item yang dipilih.
                    </div>
                </div>

                <!-- Total Estimation -->
                <div class="pt-6 border-t border-white/20 flex flex-col gap-1">
                    <span class="text-xs uppercase tracking-wider font-semibold opacity-75">Estimasi Total Budget:</span>
                    <span class="text-3xl font-extrabold tracking-tight" x-text="'Rp ' + formatNumber(totalBudget)"></span>
                </div>

                <!-- Action Button -->
                <a 
                    :href="whatsappUrl"
                    target="_blank"
                    class="block w-full text-center bg-white text-wo-rose font-bold text-xs py-3.5 rounded-full shadow-lg uppercase tracking-wider hover:bg-gray-50 transition-colors"
                >
                    Konsultasikan Rencana via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    function weddingPlanner() {
        return {
            allVendors: @json($vendors),
            selectedVendors: {},
            customItems: [],
            whatsappUrl: '#',
            
            init() {
                this.updateWhatsappUrl();
                this.$watch('selectedVendors', () => this.updateWhatsappUrl());
                this.$watch('customItems', () => this.updateWhatsappUrl());
            },
            
            selectVendor(category, vendorId) {
                if (!vendorId) {
                    delete this.selectedVendors[category];
                    this.selectedVendors = { ...this.selectedVendors };
                    return;
                }
                
                const vendor = this.allVendors.find(v => v.id == vendorId);
                if (vendor) {
                    this.selectedVendors[category] = {
                        id: vendor.id,
                        name: vendor.name,
                        price: parseFloat(vendor.price || 0),
                        packages: vendor.packages || [],
                        selectedPackage: null
                    };
                    
                    if (vendor.packages && vendor.packages.length > 0) {
                        this.selectedVendors[category].selectedPackage = vendor.packages[0].name;
                        this.selectedVendors[category].price = parseFloat(vendor.packages[0].price || 0);
                    }
                    
                    this.selectedVendors = { ...this.selectedVendors };
                }
            },
            
            selectPackage(category, packageName) {
                const vendorData = this.selectedVendors[category];
                if (vendorData) {
                    const pkg = vendorData.packages.find(p => p.name === packageName);
                    if (pkg) {
                        vendorData.selectedPackage = pkg.name;
                        vendorData.price = parseFloat(pkg.price || 0);
                    } else {
                        vendorData.selectedPackage = null;
                        const originalVendor = this.allVendors.find(v => v.id == vendorData.id); // fallback to default
                        vendorData.price = originalVendor ? parseFloat(originalVendor.price || 0) : 0;
                    }
                    this.selectedVendors = { ...this.selectedVendors };
                }
            },
            
            addCustomItem() {
                this.customItems.push({ name: '', price: 0 });
            },
            
            removeCustomItem(index) {
                this.customItems.splice(index, 1);
            },
            
            get totalBudget() {
                let total = 0;
                for (const cat in this.selectedVendors) {
                    total += this.selectedVendors[cat].price;
                }
                this.customItems.forEach(item => {
                    total += parseFloat(item.price || 0);
                });
                return total;
            },
            
            formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            },
            
            updateWhatsappUrl() {
                let text = `Halo {{ $wo->business_name }}, saya ingin merencanakan Dream Wedding saya dengan rincian berikut:\n\n`;
                
                for (const cat in this.selectedVendors) {
                    const v = this.selectedVendors[cat];
                    text += `- *${cat}*: ${v.name} ${v.selectedPackage ? '('+v.selectedPackage+')' : ''} (Rp ${this.formatNumber(v.price)})\n`;
                }
                
                this.customItems.forEach(item => {
                    if (item.name) {
                        text += `- *Kustom*: ${item.name} (Rp ${this.formatNumber(item.price)})\n`;
                    }
                });
                
                text += `\n*Estimasi Total Budget*: Rp ${this.formatNumber(this.totalBudget)}`;
                
                this.whatsappUrl = `https://wa.me/{{ $waPhone }}?text=${encodeURIComponent(text)}`;
            }
        }
    }
</script>

<!-- ============================================================ -->
<!-- PORTFOLIO GALLERY                                              -->
<!-- ============================================================ -->
<section id="portfolio" x-data="{ open: false, activeImg: '' }" class="bg-wo-cream py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-6 space-y-12">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <p class="font-script text-2xl text-wo-rose">Our Portfolio</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown">Visualizing Your Dreams<br>Into Reality</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($portfolio as $port)
                @php
                    $imageSrc = (str_starts_with($port['image'], 'http://') || str_starts_with($port['image'], 'https://')) 
                        ? $port['image'] 
                        : asset('storage/' . $port['image']);
                @endphp
                <div @click="activeImg = '{{ $imageSrc }}'; open = true"
                     class="relative group rounded-2xl overflow-hidden cursor-pointer shadow-sm hover:shadow-xl transition-shadow">
                    <div class="pb-[75%] relative">
                        <img src="{{ $imageSrc }}" alt="{{ $port['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 flex flex-col justify-end p-4 transition-opacity duration-300">
                            <span class="text-xs font-bold uppercase tracking-widest text-wo-rose-light">{{ $port['category'] }}</span>
                            <h4 class="font-bold text-white text-sm">{{ $port['title'] }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" style="display: none;" @click="open = false">
            <button class="absolute top-6 right-6 text-white/80 hover:text-white" @click.stop="open = false">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="activeImg" class="max-w-full max-h-screen rounded-2xl object-contain shadow-2xl" @click.stop>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- AND MORE                                                       -->
<!-- ============================================================ -->
<section class="bg-wo-rose-bg py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-6 text-center space-y-4">
        <p class="font-script text-3xl text-wo-rose">And more!</p>
        <p class="text-sm text-wo-brown-light max-w-xl mx-auto">Kami juga menyediakan layanan tambahan: dekorasi pelaminan, entertainment, kue & katering, souvenir, dan lainnya.</p>
        <div class="flex justify-center gap-4 pt-4 flex-wrap">
            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&q=80&w=200" alt="" class="w-full h-full object-cover">
            </div>
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img src="https://images.unsplash.com/photo-1507504038482-76210f5c035a?auto=format&fit=crop&q=80&w=200" alt="" class="w-full h-full object-cover">
            </div>
            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img src="https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&q=80&w=200" alt="" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- OUR COMMITMENT                                                 -->
<!-- ============================================================ -->
<section class="bg-wo-cream py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="space-y-4 text-center md:text-left">
            <p class="font-script text-2xl text-wo-rose">Our Commitment</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown">{!! nl2br(e($commitmentTitle)) !!}</h2>
            <p class="text-sm text-wo-brown-light leading-relaxed">{{ $commitmentDescription }}</p>
        </div>
        <div class="relative flex justify-center items-center" style="min-height: 300px;">
            <div class="w-44 h-44 rounded-full overflow-hidden border-4 border-white shadow-2xl z-10">
                <img src="{{ $commitmentImage1 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute top-0 right-8 w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $commitmentImage2 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-0 left-8 w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $commitmentImage3 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute w-52 h-52 rounded-full bg-wo-rose-bg -z-10 translate-x-3 -translate-y-3"></div>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- WHY CHOOSE US                                                  -->
<!-- ============================================================ -->
<section class="bg-wo-cream-dark py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="relative flex justify-center items-center" style="min-height: 300px;">
            <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-white shadow-2xl z-10">
                <img src="{{ $whyImage1 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-4 left-16 w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $whyImage2 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-2 right-12 w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg z-20">
                <img src="{{ $whyImage3 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute w-44 h-44 rounded-full bg-wo-rose-bg -z-10 -translate-x-4 translate-y-3"></div>
        </div>
        <div class="space-y-4 text-center md:text-left">
            <p class="font-script text-2xl text-wo-rose">Why Choose Us</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-wo-brown">{!! nl2br(e($whyTitle)) !!}</h2>
            <p class="text-sm text-wo-brown-light leading-relaxed">{{ $whyDescription }}</p>
            <div class="flex flex-wrap gap-6 pt-4">
                <div class="text-center">
                    <p class="text-2xl font-bold font-serif text-wo-rose">{{ $whyStat1Value }}</p>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ $whyStat1Label }}</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold font-serif text-wo-rose">{{ $whyStat2Value }}</p>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ $whyStat2Label }}</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold font-serif text-wo-rose">{{ $whyStat3Value }}</p>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ $whyStat3Label }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- GALLERY FEED STRIP                                             -->
<!-- ============================================================ -->
<section class="bg-wo-cream py-8">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-6">
            <p class="font-script text-xl text-wo-rose">{{ $wo->business_name }}</p>
            <p class="text-xl font-bold font-serif text-wo-brown">Weddings</p>
        </div>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
            @foreach($portfolio as $port)
                @php
                    $imageSrc = (str_starts_with($port['image'], 'http://') || str_starts_with($port['image'], 'https://')) 
                        ? $port['image'] 
                        : asset('storage/' . $port['image']);
                @endphp
                <div class="overflow-hidden rounded-lg">
                    <div class="pb-[100%] relative">
                        <img src="{{ $imageSrc }}" alt="{{ $port['title'] }}" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- LET'S TALK - CONTACT FORM                                      -->
<!-- ============================================================ -->
<section id="contact" class="relative bg-wo-brown py-16 md:py-24 overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
        <div class="hidden lg:flex lg:col-span-3 justify-center">
            <div class="w-52 h-72 rounded-2xl overflow-hidden shadow-2xl -rotate-3 border-4 border-white/10">
                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=400" alt="" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="lg:col-span-6 text-center space-y-6">
            <p class="text-white/60 text-xs uppercase tracking-widest">We say yes to weddings!</p>
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-white">Let's Talk</h2>

            @if(session('success'))
                <div class="p-4 bg-emerald-900/30 border border-emerald-700 text-emerald-300 text-xs rounded-xl flex items-center gap-2 justify-center">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('public.wo.inquiry', $wo) }}" class="space-y-4 text-left max-w-md mx-auto">
                @csrf
                <input type="text" name="name" required placeholder="Nama Lengkap"
                       class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-xs text-white placeholder-white/40 focus:ring-2 focus:ring-wo-rose focus:outline-none">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="email" name="email" required placeholder="Email"
                           class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-xs text-white placeholder-white/40 focus:ring-2 focus:ring-wo-rose focus:outline-none">
                    <input type="text" name="phone" required placeholder="No. WhatsApp"
                           class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-xs text-white placeholder-white/40 focus:ring-2 focus:ring-wo-rose focus:outline-none">
                </div>
                <textarea name="message" required placeholder="Ceritakan rencana pernikahan Anda..."
                          class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-xs text-white placeholder-white/40 focus:ring-2 focus:ring-wo-rose focus:outline-none h-24 resize-none"></textarea>
                <button type="submit" class="w-full bg-wo-rose text-white font-bold text-xs py-3.5 rounded-full shadow-lg uppercase tracking-wider hover:bg-wo-rose-dark transition-colors">
                    Kirim Inquiry
                </button>
            </form>
        </div>

        <div class="hidden lg:flex lg:col-span-3 justify-center">
            <div class="w-52 h-72 rounded-2xl overflow-hidden shadow-2xl rotate-3 border-4 border-white/10">
                <img src="https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=400" alt="" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- TESTIMONIALS                                                   -->
<!-- ============================================================ -->
<section id="testimonials" class="bg-wo-rose-bg py-16 md:py-20">
    <div class="max-w-5xl mx-auto px-6 space-y-10"
         x-data="{
            activeSlide: 0,
            slidesCount: {{ count($testimonials) }},
            next() { this.activeSlide = (this.activeSlide + 1) % this.slidesCount },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount }
         }">
        <div class="text-center space-y-2">
            <p class="font-script text-2xl text-wo-rose">Our Clients Say</p>
            <h2 class="text-2xl font-bold font-serif text-wo-brown">Kisah Bahagia Mereka</h2>
        </div>
        <div class="relative max-w-2xl mx-auto px-12">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-white/60" style="min-height: 180px;">
                @foreach($testimonials as $idx => $test)
                    <div x-show="activeSlide === {{ $idx }}" x-transition.opacity class="space-y-4 w-full text-center">
                        <p class="text-sm italic text-wo-brown-light leading-relaxed font-serif">"{{ $test['quote'] }}"</p>
                        <div class="flex items-center justify-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-wo-rose text-white font-bold text-sm font-serif flex items-center justify-center">
                                {{ substr($test['client_name'], 0, 1) }}
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold text-xs text-wo-brown">{{ $test['client_name'] }}</h4>
                                <span class="text-xs text-gray-400">{{ $test['wedding_date'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white border border-wo-rose-light shadow-sm flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">←</button>
            <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white border border-wo-rose-light shadow-sm flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">→</button>
        </div>
    </div>
</section>


<!-- ============================================================ -->
<!-- FOOTER                                                         -->
<!-- ============================================================ -->
<footer class="bg-wo-brown text-gray-400 text-xs py-12 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="space-y-3">
            <span class="font-bold text-white text-base font-serif block">{{ $wo->business_name }}</span>
            <p class="leading-relaxed max-w-xs">{{ Str::limit($wo->description ?? 'Mitra wedding planner dan organizer terpercaya Anda.', 120) }}</p>
        </div>
        <div class="space-y-3">
            <span class="font-bold text-white block font-serif">Tautan Cepat</span>
            <ul class="space-y-2">
                <li><a href="#about" class="hover:text-white transition-colors">Tentang Kami</a></li>
                <li><a href="#packages" class="hover:text-white transition-colors">Paket Wedding</a></li>
                <li><a href="#portfolio" class="hover:text-white transition-colors">Portofolio</a></li>
                <li><a href="#testimonials" class="hover:text-white transition-colors">Testimoni</a></li>
            </ul>
        </div>
        <div class="space-y-3">
            <span class="font-bold text-white block font-serif">Kontak Kantor</span>
            <ul class="space-y-2">
                <li>{{ $wo->address ?? 'Ciamis, Jawa Barat' }}</li>
                <li>{{ $wo->phone ?? '-' }}</li>
            </ul>
            <div class="flex gap-3 pt-2">
                <a href="#" class="w-8 h-8 rounded-full border border-gray-600 flex items-center justify-center hover:text-white hover:border-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="w-8 h-8 rounded-full border border-gray-600 flex items-center justify-center hover:text-white hover:border-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-600 flex items-center justify-center hover:text-white hover:border-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24z"/></svg>
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto border-t border-gray-700 mt-8 pt-6 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} {{ $wo->business_name }}. All rights reserved. Platform by WOApp.
    </div>
</footer>

<!-- Floating WhatsApp -->
<a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('Halo ' . $wo->business_name . ', saya ingin konsultasi rencana pernikahan.') }}"
   target="_blank"
   class="fixed bottom-6 right-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110"
   title="WhatsApp">
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.966-1.862-1.865-4.334-2.889-6.969-2.89-5.438 0-9.863 4.373-9.868 9.802-.002 1.761.478 3.483 1.393 5.006L1.874 22l6.002-1.573z"/></svg>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('main-header');
        const brand = header.querySelector('.brand-name');
        const navLinks = header.querySelectorAll('.nav-link');
        const ctaBtn = header.querySelector('.cta-btn');

        function handleScroll() {
            if (window.scrollY > 50) {
                header.classList.remove('bg-transparent', 'border-transparent');
                header.classList.add('bg-wo-cream', 'border-b', 'border-wo-rose-light/20', 'shadow-md');

                brand.classList.remove('text-white', 'drop-shadow-sm');
                brand.classList.add('text-wo-brown');

                navLinks.forEach(link => {
                    link.classList.remove('text-white/95');
                    link.classList.add('text-wo-brown-light');
                });

                ctaBtn.classList.remove('bg-white', 'text-wo-rose');
                ctaBtn.classList.add('bg-wo-rose', 'hover:bg-wo-rose-dark', 'text-white');
            } else {
                header.classList.add('bg-transparent', 'border-transparent');
                header.classList.remove('bg-wo-cream', 'border-b', 'border-wo-rose-light/20', 'shadow-md');

                brand.classList.add('text-white', 'drop-shadow-sm');
                brand.classList.remove('text-wo-brown');

                navLinks.forEach(link => {
                    link.classList.add('text-white/95');
                    link.classList.remove('text-wo-brown-light');
                });

                ctaBtn.classList.add('bg-white', 'text-wo-rose');
                ctaBtn.classList.remove('bg-wo-rose', 'hover:bg-wo-rose-dark', 'text-white');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    });
</script>

</body>
</html>
