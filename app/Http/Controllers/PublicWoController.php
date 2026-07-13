<?php

namespace App\Http\Controllers;

use App\Models\WoProfile;
use App\Models\WoInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicWoController extends Controller
{
    /**
     * Show Public WO Landing Page.
     */
    public function show(string $slug): View
    {
        $wo = WoProfile::where('slug', $slug)->firstOrFail();
        
        // Fetch active packages
        $packages = $wo->packages()->where('is_active', true)->get();
        
        // Fetch active vendors
        $vendors = $wo->vendors()->where('status', 'active')->get();

        // SEO and Meta details
        $seoTitle = "{$wo->business_name} - Wedding Organizer Terbaik";
        $seoDescription = $wo->description ?? "Hubungi {$wo->business_name} untuk merencanakan pernikahan impian Anda. Temukan paket wedding terbaik dan terpercaya.";
        $canonicalUrl = route('public.wo.show', $wo->slug);

        // Load customizable settings
        $settings = $wo->landing_settings ?? [];

        $heroTitle = $settings['hero_title'] ?? 'Crafting Unforgettable Love Stories';
        $heroDescription = $settings['hero_description'] ?? "{$wo->business_name} — Kami merancang dan mengawal setiap detail hari bahagia Anda.";
        
        $heroImage = isset($settings['hero_image']) 
            ? asset('storage/' . $settings['hero_image']) 
            : 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1600';

        $aboutTitle = $settings['about_title'] ?? 'The Minds Behind Your Perfect Day';
        $aboutDescription = $settings['about_description'] ?? ($wo->description ?? 'Kami adalah tim wedding planner dan organizer berdedikasi yang berkomitmen untuk mewujudkan setiap pesta pernikahan dengan sentuhan eksklusif, rapi, dan terorganisir dengan sempurna.');
        
        $aboutImages = $settings['about_images'] ?? [];
        if (count($aboutImages) > 0) {
            shuffle($aboutImages);
        }

        $aboutImage1 = isset($aboutImages[0]) ? asset('storage/' . $aboutImages[0]) : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=500';
        $aboutImage2 = isset($aboutImages[1]) ? asset('storage/' . $aboutImages[1]) : 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=250';
        $aboutImage3 = isset($aboutImages[2]) ? asset('storage/' . $aboutImages[2]) : 'https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&q=80&w=250';

        // Why Choose Us section settings
        $whyTitle = $settings['why_title'] ?? 'An unforgettable saga at your absolute dream';
        $whyDescription = $settings['why_description'] ?? 'Dengan pengalaman mengelola ratusan acara pernikahan, kami menjamin setiap detail dieksekusi dengan kualitas terbaik.';
        $whyStat1Value = $settings['why_stat1_value'] ?? '150+';
        $whyStat1Label = $settings['why_stat1_label'] ?? 'Wedding';
        $whyStat2Value = $settings['why_stat2_value'] ?? '99%';
        $whyStat2Label = $settings['why_stat2_label'] ?? 'Satisfaction';
        $whyStat3Value = $settings['why_stat3_value'] ?? '5+';
        $whyStat3Label = $settings['why_stat3_label'] ?? 'Years';

        $whyImages = $settings['why_images'] ?? [];
        if (count($whyImages) > 0) {
            shuffle($whyImages);
        }
        $whyImage1 = isset($whyImages[0]) ? asset('storage/' . $whyImages[0]) : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=300';
        $whyImage2 = isset($whyImages[1]) ? asset('storage/' . $whyImages[1]) : 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=200';
        $whyImage3 = isset($whyImages[2]) ? asset('storage/' . $whyImages[2]) : 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&q=80&w=200';

        // Our Commitment section settings
        $commitmentTitle = $settings['commitment_title'] ?? 'Your Vision, Our Flawless Execution';
        $commitmentDescription = $settings['commitment_description'] ?? 'Setiap pasangan memiliki cerita unik. Kami mendengarkan, memahami, dan mewujudkan setiap visi menjadi kenyataan yang melampaui ekspektasi.';

        $commitmentImages = $settings['commitment_images'] ?? [];
        if (count($commitmentImages) > 0) {
            shuffle($commitmentImages);
        }
        $commitmentImage1 = isset($commitmentImages[0]) ? asset('storage/' . $commitmentImages[0]) : 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=400';
        $commitmentImage2 = isset($commitmentImages[1]) ? asset('storage/' . $commitmentImages[1]) : 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&q=80&w=200';
        $commitmentImage3 = isset($commitmentImages[2]) ? asset('storage/' . $commitmentImages[2]) : 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=200';

        // Mock portfolio items
        $portfolio = !empty($settings['portfolio']) ? $settings['portfolio'] : [
            [
                'title' => 'Rustic Chic Barn Wedding',
                'category' => 'Decoration',
                'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&q=80&w=600',
            ],
            [
                'title' => 'Traditional Sundanese Ceremony',
                'category' => 'Traditional',
                'image' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=600',
            ],
            [
                'title' => 'Elegant Ballroom Reception',
                'category' => 'Reception',
                'image' => 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=600',
            ],
            [
                'title' => 'Modern Minimalist Akad Nikah',
                'category' => 'Akad',
                'image' => 'https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&q=80&w=600',
            ],
            [
                'title' => 'Outdoor Garden Procession',
                'category' => 'Ceremony',
                'image' => 'https://images.unsplash.com/photo-1532712938310-34cb3982ef74?auto=format&fit=crop&q=80&w=600',
            ],
            [
                'title' => 'Luxury Floral Stage Decor',
                'category' => 'Decoration',
                'image' => 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&q=80&w=600',
            ],
        ];

        // Mock Client Testimonials
        $testimonials = !empty($settings['testimonials']) ? $settings['testimonials'] : [
            [
                'client_name' => 'Aditya & Dinda',
                'wedding_date' => '10 Okt 2026',
                'quote' => "Pelayanan sangat memuaskan! Tim sangat sigap memantau semua persiapan dari KUA, rundown acara hingga koordinasi katering di hari-H. Sangat recommended!",
                'rating' => 5,
            ],
            [
                'client_name' => 'Rian & Amel',
                'wedding_date' => '20 Mei 2026',
                'quote' => "Aplikasi WOApp dari WO ini sangat membantu kami melacak sisa anggaran belanja pesta dan memantau status checklist persiapan kami secara real-time.",
                'rating' => 5,
            ],
            [
                'client_name' => 'Fahmi & Sarah',
                'wedding_date' => '14 Jan 2026',
                'quote' => "Koordinasi rundown sangat rapi. Dari sesi makeup subuh sampai acara selesai malam hari, semua berjalan on-time berkat PIC yang berdedikasi.",
                'rating' => 5,
            ],
        ];

        $agent = new \Jenssegers\Agent\Agent();
        $viewName = ($agent->isMobile() || $agent->isTablet()) ? 'public.wo.mobile_show' : 'public.wo.show';

        return view($viewName, compact(
            'wo', 
            'packages', 
            'seoTitle', 
            'seoDescription', 
            'canonicalUrl', 
            'portfolio', 
            'testimonials',
            'heroTitle',
            'heroDescription',
            'heroImage',
            'aboutTitle',
            'aboutDescription',
            'aboutImage1',
            'aboutImage2',
            'aboutImage3',
            'whyTitle',
            'whyDescription',
            'whyStat1Value',
            'whyStat1Label',
            'whyStat2Value',
            'whyStat2Label',
            'whyStat3Value',
            'whyStat3Label',
            'whyImage1',
            'whyImage2',
            'whyImage3',
            'commitmentTitle',
            'commitmentDescription',
            'commitmentImage1',
            'commitmentImage2',
            'commitmentImage3',
            'vendors'
        ));
    }

    /**
     * Store Business Inquiry from Public Landing Page.
     */
    public function storeInquiry(Request $request, WoProfile $wo): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string'],
        ]);

        $wo->inquiries()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Pertanyaan/Inquiry Anda berhasil terkirim. Tim kami akan segera menghubungi Anda melalui WhatsApp atau Email!');
    }
}
