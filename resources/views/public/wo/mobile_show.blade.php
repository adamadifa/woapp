<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle }} (Mobile)</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-wo-cream text-wo-brown-text font-sans text-xs">

@php
    $waPhone = preg_replace('/[^0-9]/', '', $wo->phone ?? '6289670444321');
@endphp

<!-- Mobile Header (Fixed & Clean) -->
<header id="mobile-header" class="fixed top-0 left-0 right-0 z-40 bg-transparent border-transparent py-3 px-4 flex items-center justify-between transition-all duration-300">
    <div class="flex items-center gap-2 max-w-[70%]">
        @if($wo->logo)
            <img src="{{ asset('storage/' . $wo->logo) }}" alt="Logo" class="w-8 h-8 rounded-full object-cover border border-white shrink-0 brand-logo">
        @else
            <div class="w-8 h-8 rounded-full bg-white text-wo-rose flex items-center justify-center font-bold text-sm font-serif shrink-0 brand-logo-placeholder">
                {{ substr($wo->business_name, 0, 1) }}
            </div>
        @endif
        <span class="brand-name font-extrabold text-sm font-serif text-white truncate drop-shadow-sm">{{ $wo->business_name }}</span>
    </div>

    <div>
        <a href="#contact" class="cta-btn border border-white/60 text-white text-[9px] font-bold py-1.5 px-3 rounded-full shadow-sm uppercase tracking-wider shrink-0 transition-all duration-300">
            Hubungi
        </a>
    </div>
</header>

<!-- HERO SECTION -->
<section class="relative w-full overflow-hidden min-h-[45vh] flex items-center justify-center pt-14">
    <img src="{{ $heroImage }}" alt="Wedding" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-wo-rose/40 via-wo-rose-bg/50 to-wo-cream"></div>

    <div class="relative z-10 text-center px-4 pt-16 pb-8">
        @if($wo->logo)
            <img src="{{ asset('storage/' . $wo->logo) }}" alt="Logo" class="w-12 h-12 rounded-full border-2 border-white shadow-md object-cover mx-auto mb-4">
        @else
            <div class="w-12 h-12 rounded-full border-2 border-white shadow-md bg-wo-rose text-white font-serif font-bold text-lg flex items-center justify-center mx-auto mb-4">
                {{ substr($wo->business_name, 0, 1) }}
            </div>
        @endif
        <h1 class="text-2xl font-bold text-white font-serif leading-tight drop-shadow-md">
            {!! nl2br(e($heroTitle)) !!}
        </h1>
        <p class="text-white/95 text-xs max-w-sm mx-auto mt-2 leading-relaxed">
            {{ $heroDescription }}
        </p>
        <div class="flex justify-center gap-3 mt-4">
            <a href="#packages" class="bg-wo-rose text-white font-bold text-[10px] py-2.5 px-6 rounded-full shadow-md uppercase tracking-wider">Lihat Paket</a>
            <a href="#dream-wedding" class="bg-white text-wo-rose font-bold text-[10px] py-2.5 px-6 rounded-full shadow-md uppercase tracking-wider">Rancang Budget</a>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="bg-wo-cream py-10 px-4">
    <div class="space-y-6">
        <div class="relative flex justify-center items-center" style="min-height: 250px;">
            <div class="w-44 h-44 rounded-full overflow-hidden border-4 border-white shadow-xl z-10">
                <img src="{{ $aboutImage1 }}" alt="Team" class="w-full h-full object-cover">
            </div>
            <div class="absolute top-0 right-4 w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md z-20">
                <img src="{{ $aboutImage2 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-0 left-4 w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-md z-20">
                <img src="{{ $aboutImage3 }}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="absolute w-56 h-56 rounded-full bg-wo-rose-bg -z-10 translate-x-4 -translate-y-2"></div>
        </div>

        <div class="space-y-3 text-center">
            <p class="font-script text-xl text-wo-rose">About Us</p>
            <h2 class="text-xl font-bold font-serif text-wo-brown leading-tight">
                {!! nl2br(e($aboutTitle)) !!}
            </h2>
            <p class="text-xs leading-relaxed text-wo-brown-light px-2">{{ $aboutDescription }}</p>
            <div class="flex flex-col gap-2 pt-2 text-xs items-center">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-wo-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="font-semibold">{{ $wo->address ?? 'Jawa Barat, Indonesia' }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-wo-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="font-semibold">{{ $wo->phone ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES / PACKAGES -->
<section id="packages" class="bg-wo-cream-dark py-10 px-4">
    <div class="space-y-8">
        <div class="text-center space-y-1">
            <p class="font-script text-xl text-wo-rose">Our Services</p>
            <h2 class="text-xl font-bold font-serif text-wo-brown">Pilihan Paket Wedding</h2>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @forelse($packages as $pkg)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col">
                    <div class="h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=500" alt="{{ $pkg->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="font-bold text-base font-serif text-wo-brown">{{ $pkg->name }}</h3>
                            <p class="text-lg font-bold font-serif text-wo-rose">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-wo-brown-light leading-relaxed">{{ $pkg->description }}</p>
                            @if($pkg->items && is_array($pkg->items))
                                <ul class="space-y-1 text-xs pt-1">
                                    @foreach($pkg->items as $item)
                                        <li class="flex items-start gap-1.5">
                                            <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-wo-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @php $waText = urlencode("Halo {$wo->business_name}, saya tertarik dengan paket *{$pkg->name}*. Bisa kirim rinciannya?"); @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank"
                           class="block w-full text-center bg-wo-rose text-white font-bold text-xs py-2.5 rounded-full shadow-sm uppercase tracking-wider">
                            Konsultasi Paket
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-wo-brown-light">Belum ada paket promosi aktif saat ini.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- DREAM WEDDING CALCULATOR & PLANNER -->
<section id="dream-wedding" x-data="weddingPlanner()" class="bg-wo-rose-bg/15 py-10 px-4 border-y border-wo-rose-light/10">
    <div class="space-y-8">
        <div class="text-center space-y-1">
            <p class="font-script text-xl text-wo-rose">Dream Wedding Planner</p>
            <h2 class="text-xl font-bold font-serif text-wo-brown">Rancang Pernikahan Impian</h2>
            <p class="text-[11px] text-wo-brown-light leading-relaxed">
                Pilih kombinasi vendor, tentukan variasi, dan estimasikan budget impian Anda.
            </p>
        </div>

        <div class="space-y-6">
            <!-- Left: Selection Form -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100/50 space-y-4">
                <!-- Category Selectors -->
                <div class="space-y-4">
                    @forelse($vendors->groupBy('category') as $category => $categoryVendors)
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-wo-brown uppercase tracking-wider block">{{ $category }}</label>
                            <div class="space-y-2">
                                <!-- Select Vendor Dropdown -->
                                <select 
                                    @change="selectVendor('{{ $category }}', $event.target.value)"
                                    class="w-full bg-wo-cream border border-wo-rose-light/10 rounded-xl py-2 px-3 text-xs focus:outline-none text-wo-brown-text"
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
                                        class="w-full bg-wo-cream border border-wo-rose-light/10 rounded-xl py-2 px-3 text-xs focus:outline-none text-wo-brown-text"
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
                        <div class="text-center py-4 text-xs text-wo-brown-light">Belum ada vendor terdaftar.</div>
                    @endforelse
                </div>

                <!-- Custom Items Section -->
                <div class="pt-4 border-t border-dashed border-gray-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-[9px] font-bold text-wo-brown uppercase tracking-wider">Item Tambahan Lainnya (Opsional)</label>
                        <button type="button" @click="addCustomItem()" class="text-xs text-wo-rose font-bold hover:underline">
                            + Tambah
                        </button>
                    </div>

                    <div class="space-y-2">
                        <template x-for="(item, index) in customItems" :key="index">
                            <div class="flex gap-1.5 items-center">
                                <input type="text" x-model="item.name" placeholder="Nama Item" class="flex-1 bg-wo-cream border border-wo-rose-light/10 rounded-xl py-2 px-3 text-xs focus:outline-none text-wo-brown-text">
                                <input type="number" x-model.number="item.price" placeholder="Harga" class="w-20 bg-wo-cream border border-wo-rose-light/10 rounded-xl py-2 px-3 text-xs focus:outline-none text-wo-brown-text">
                                <button type="button" @click="removeCustomItem(index)" class="p-2 text-red-500 text-sm">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right: Budget Summary -->
            <div class="bg-gradient-to-br from-wo-rose to-rose-600 p-5 rounded-2xl shadow-md text-white space-y-4">
                <h3 class="font-bold text-sm font-serif border-b border-white/10 pb-2">Ringkasan Budget</h3>

                <div class="space-y-2.5 text-xs">
                    <!-- Selected Vendors -->
                    <template x-for="(data, category) in selectedVendors" :key="category">
                        <div x-show="data" class="flex items-center justify-between bg-white/10 p-2.5 rounded-lg border border-white/5">
                            <div>
                                <span class="text-[8px] uppercase tracking-wider font-extrabold opacity-75 block" x-text="category"></span>
                                <span class="font-bold block text-[11px]" x-text="data.name"></span>
                                <span x-show="data.selectedPackage" class="text-[9px] opacity-90 block" x-text="'Paket: ' + data.selectedPackage"></span>
                            </div>
                            <span class="font-extrabold" x-text="'Rp ' + formatNumber(data.price)"></span>
                        </div>
                    </template>

                    <!-- Custom Items -->
                    <template x-for="(item, index) in customItems" :key="index">
                        <div x-show="item.name" class="flex items-center justify-between bg-white/10 p-2.5 rounded-lg border border-white/5">
                            <div>
                                <span class="text-[8px] uppercase tracking-wider font-extrabold opacity-75 block">Kustom</span>
                                <span class="font-bold block text-[11px]" x-text="item.name"></span>
                            </div>
                            <span class="font-extrabold" x-text="'Rp ' + formatNumber(item.price)"></span>
                        </div>
                    </template>

                    <div x-show="Object.keys(selectedVendors).length === 0 && customItems.length === 0" class="text-center py-6 opacity-75 text-[11px] italic">
                        Belum ada vendor/item dipilih.
                    </div>
                </div>

                <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                    <span class="text-[11px] uppercase tracking-wider font-semibold opacity-75">Estimasi Total:</span>
                    <span class="text-lg font-extrabold" x-text="'Rp ' + formatNumber(totalBudget)"></span>
                </div>

                <a :href="whatsappUrl" target="_blank" class="block w-full text-center bg-white text-wo-rose font-bold text-xs py-2.5 rounded-full shadow-sm uppercase tracking-wider">
                    Konsultasikan ke WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- PORTFOLIO GALLERY -->
<section id="portfolio" x-data="{ open: false, activeImg: '' }" class="bg-wo-cream py-10 px-4">
    <div class="space-y-8">
        <div class="text-center space-y-1">
            <p class="font-script text-xl text-wo-rose">Our Portfolio</p>
            <h2 class="text-xl font-bold font-serif text-wo-brown">Galeri Pernikahan</h2>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @foreach($portfolio as $port)
                @php
                    $imageSrc = (str_starts_with($port['image'], 'http://') || str_starts_with($port['image'], 'https://')) 
                        ? $port['image'] 
                        : asset('storage/' . $port['image']);
                @endphp
                <div @click="activeImg = '{{ $imageSrc }}'; open = true" class="relative group rounded-xl overflow-hidden cursor-pointer shadow-sm">
                    <div class="pb-[100%] relative">
                        <img src="{{ $imageSrc }}" alt="{{ $port['title'] }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-2.5">
                            <span class="text-[8px] font-bold uppercase tracking-widest text-wo-rose-light">{{ $port['category'] }}</span>
                            <h4 class="font-bold text-white text-[10px] truncate">{{ $port['title'] }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div x-show="open" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" style="display: none;" @click="open = false">
            <img :src="activeImg" class="max-w-full max-h-screen rounded-xl object-contain shadow-2xl">
        </div>
    </div>
</section>

<!-- LET'S TALK - CONTACT FORM -->
<section id="contact" class="bg-wo-brown py-10 px-4">
    <div class="text-center space-y-6 max-w-sm mx-auto">
        <p class="text-white/60 text-[10px] uppercase tracking-widest">We say yes to weddings!</p>
        <h2 class="text-2xl font-bold font-serif text-white">Hubungi Kami</h2>

        @if(session('success'))
            <div class="p-3 bg-emerald-900/30 border border-emerald-700 text-emerald-300 text-xs rounded-xl text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('public.wo.inquiry', $wo) }}" class="space-y-3 text-left">
            @csrf
            <input type="text" name="name" required placeholder="Nama Lengkap" class="w-full bg-white/10 border border-white/20 rounded-xl py-2.5 px-3 text-xs text-white placeholder-white/40 focus:outline-none">
            <input type="email" name="email" required placeholder="Email" class="w-full bg-white/10 border border-white/20 rounded-xl py-2.5 px-3 text-xs text-white placeholder-white/40 focus:outline-none">
            <input type="text" name="phone" required placeholder="No. WhatsApp" class="w-full bg-white/10 border border-white/20 rounded-xl py-2.5 px-3 text-xs text-white placeholder-white/40 focus:outline-none">
            <textarea name="message" required placeholder="Ceritakan rencana pernikahan Anda..." class="w-full bg-white/10 border border-white/20 rounded-xl py-2.5 px-3 text-xs text-white placeholder-white/40 focus:outline-none h-20 resize-none"></textarea>
            <button type="submit" class="w-full bg-wo-rose text-white font-bold text-xs py-3 rounded-full uppercase tracking-wider">
                Kirim Pertanyaan
            </button>
        </form>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-wo-brown text-gray-500 text-[11px] py-8 px-4 border-t border-white/5 text-center space-y-6">
    <div class="space-y-2">
        <span class="font-bold text-white text-sm font-serif block">{{ $wo->business_name }}</span>
        <p class="leading-relaxed">{{ Str::limit($wo->description ?? 'Mitra wedding planner dan organizer terpercaya Anda.', 120) }}</p>
    </div>
    <div class="flex justify-center gap-3 pt-2">
        <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24z"/></svg>
        </a>
    </div>
    <div class="border-t border-gray-800 pt-4 text-[10px]">
        &copy; {{ date('Y') }} {{ $wo->business_name }}. Platform by WOApp.
    </div>
</footer>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('mobile-header');
        const brand = header.querySelector('.brand-name');
        const logo = header.querySelector('.brand-logo');
        const placeholder = header.querySelector('.brand-logo-placeholder');
        const ctaBtn = header.querySelector('.cta-btn');

        function handleScroll() {
            if (window.scrollY > 30) {
                header.classList.remove('bg-transparent', 'border-transparent');
                header.classList.add('bg-wo-cream', 'border-b', 'border-wo-rose-light/10', 'shadow-sm');

                brand.classList.remove('text-white');
                brand.classList.add('text-wo-brown');

                if (logo) {
                    logo.classList.remove('border-white');
                    logo.classList.add('border-wo-rose-light');
                }

                if (placeholder) {
                    placeholder.classList.remove('bg-white', 'text-wo-rose');
                    placeholder.classList.add('bg-wo-rose', 'text-white');
                }

                ctaBtn.classList.remove('border-white/60', 'text-white');
                ctaBtn.classList.add('bg-wo-rose', 'text-white', 'border-transparent');
            } else {
                header.classList.add('bg-transparent', 'border-transparent');
                header.classList.remove('bg-wo-cream', 'border-b', 'border-wo-rose-light/10', 'shadow-sm');

                brand.classList.add('text-white');
                brand.classList.remove('text-wo-brown');

                if (logo) {
                    logo.classList.add('border-white');
                    logo.classList.remove('border-wo-rose-light');
                }

                if (placeholder) {
                    placeholder.classList.add('bg-white', 'text-wo-rose');
                    placeholder.classList.remove('bg-wo-rose', 'text-white');
                }

                ctaBtn.classList.add('border-white/60', 'text-white');
                ctaBtn.classList.remove('bg-wo-rose', 'text-white', 'border-transparent');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    });
</script>

</body>
</html>
