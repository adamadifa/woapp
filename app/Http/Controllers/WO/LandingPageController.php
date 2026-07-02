<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Show form to edit Landing Page settings.
     */
    public function edit(): View
    {
        $wo = auth()->user()->woProfile;
        $settings = $wo->landing_settings ?? [];

        return view('wo.profile.landing', compact('wo', 'settings'));
    }

    /**
     * Update Landing Page settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $wo = auth()->user()->woProfile;
        $settings = $wo->landing_settings ?? [];

        $request->validate([
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:5120'], // Max 5MB
            'about_title' => ['nullable', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_images' => ['nullable', 'array', 'max:3'],
            'about_images.*' => ['image', 'max:5120'],
            'portfolio' => ['nullable', 'array'],
            'portfolio.*.title' => ['required', 'string'],
            'portfolio.*.category' => ['required', 'string'],
            'portfolio.*.image' => ['nullable', 'string'],
            'portfolio_images' => ['nullable', 'array'],
            'portfolio_images.*' => ['image', 'max:5120'],
            'testimonials' => ['nullable', 'array'],
            'testimonials.*.client_name' => ['required', 'string'],
            'testimonials.*.quote' => ['required', 'string'],
            'testimonials.*.wedding_date' => ['required', 'string'],
            'testimonials.*.rating' => ['required', 'integer', 'min:1', 'max:5'],
            'why_title' => ['nullable', 'string', 'max:255'],
            'why_description' => ['nullable', 'string'],
            'why_stat1_value' => ['nullable', 'string', 'max:50'],
            'why_stat1_label' => ['nullable', 'string', 'max:100'],
            'why_stat2_value' => ['nullable', 'string', 'max:50'],
            'why_stat2_label' => ['nullable', 'string', 'max:100'],
            'why_stat3_value' => ['nullable', 'string', 'max:50'],
            'why_stat3_label' => ['nullable', 'string', 'max:100'],
            'why_images' => ['nullable', 'array', 'max:3'],
            'why_images.*' => ['image', 'max:5120'],
            'commitment_title' => ['nullable', 'string', 'max:255'],
            'commitment_description' => ['nullable', 'string'],
            'commitment_images' => ['nullable', 'array', 'max:3'],
            'commitment_images.*' => ['image', 'max:5120'],
        ]);

        // Handle custom hero image upload
        $heroImagePath = $settings['hero_image'] ?? null;
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $heroImagePath = $file->store('landing_assets', 'public');
        }

        // Handle custom about images upload (multiple)
        $aboutImagePaths = $settings['about_images'] ?? [];
        if ($request->hasFile('about_images')) {
            $aboutImagePaths = []; // reset and overwrite
            foreach ($request->file('about_images') as $file) {
                $aboutImagePaths[] = $file->store('landing_assets', 'public');
            }
        }

        // Handle custom portfolio images upload
        $portfolioData = [];
        if ($request->has('portfolio')) {
            foreach ($request->portfolio as $index => $item) {
                $imagePath = $item['image'] ?? null;
                if ($request->hasFile("portfolio_images.{$index}")) {
                    $file = $request->file("portfolio_images.{$index}");
                    $imagePath = $file->store('landing_assets', 'public');
                }
                $portfolioData[] = [
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'image' => $imagePath,
                ];
            }
        }

        // Handle why choose us images upload
        $whyImagePaths = $settings['why_images'] ?? [];
        if ($request->hasFile('why_images')) {
            $whyImagePaths = [];
            foreach ($request->file('why_images') as $file) {
                $whyImagePaths[] = $file->store('landing_assets', 'public');
            }
        }

        // Handle commitment images upload
        $commitmentImagePaths = $settings['commitment_images'] ?? [];
        if ($request->hasFile('commitment_images')) {
            $commitmentImagePaths = [];
            foreach ($request->file('commitment_images') as $file) {
                $commitmentImagePaths[] = $file->store('landing_assets', 'public');
            }
        }

        // Build settings payload
        $settingsPayload = [
            'hero_title' => $request->hero_title,
            'hero_description' => $request->hero_description,
            'hero_image' => $heroImagePath,
            'about_title' => $request->about_title,
            'about_description' => $request->about_description,
            'about_images' => $aboutImagePaths,
            'portfolio' => $portfolioData,
            'testimonials' => $request->testimonials ?? [],
            'why_title' => $request->why_title,
            'why_description' => $request->why_description,
            'why_stat1_value' => $request->why_stat1_value,
            'why_stat1_label' => $request->why_stat1_label,
            'why_stat2_value' => $request->why_stat2_value,
            'why_stat2_label' => $request->why_stat2_label,
            'why_stat3_value' => $request->why_stat3_value,
            'why_stat3_label' => $request->why_stat3_label,
            'why_images' => $whyImagePaths,
            'commitment_title' => $request->commitment_title,
            'commitment_description' => $request->commitment_description,
            'commitment_images' => $commitmentImagePaths,
        ];

        $wo->update([
            'landing_settings' => $settingsPayload,
        ]);

        return redirect()->route('wo.landing_page.edit')->with('success', 'Pengaturan Halaman Promosi Publik berhasil diperbarui!');
    }
}
