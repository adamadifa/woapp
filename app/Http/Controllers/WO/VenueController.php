<?php

namespace App\Http\Controllers\WO;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VenueController extends Controller
{
    /**
     * Display a listing of the venues.
     */
    public function index(Request $request): View
    {
        $query = Venue::orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%');
        }

        $venues = $query->paginate(9);

        return view('wo.venues.index', compact('venues'));
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'facilities' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->all();

        // Handle facilities checklist serialization/cast
        $data['facilities'] = $request->facilities ?? [];

        // Handle multiple image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('venues', 'public');
            }
        }
        $data['images'] = $images;

        Venue::create($data);

        return redirect()->route('wo.venues.index')->with('success', 'Venue baru berhasil ditambahkan.');
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, Venue $venue): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'facilities' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->all();
        $data['facilities'] = $request->facilities ?? [];

        // Preserve old images or upload new ones
        $images = $venue->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('venues', 'public');
            }
        }
        $data['images'] = $images;

        $venue->update($data);

        return redirect()->route('wo.venues.index')->with('success', 'Data venue berhasil diperbarui.');
    }

    /**
     * Remove the specified venue from storage.
     */
    public function destroy(Venue $venue): RedirectResponse
    {
        // Delete images from storage
        if ($venue->images) {
            foreach ($venue->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $venue->delete();

        return redirect()->route('wo.venues.index')->with('success', 'Venue berhasil dihapus.');
    }

    /**
     * Display the availability calendar for the venue.
     */
    public function availability(Venue $venue): View
    {
        // Fetch all wedding projects linked to this venue that are active (planning, ongoing, completed)
        $bookings = $venue->weddingProjects()
            ->with('client')
            ->whereIn('status', ['planning', 'ongoing', 'completed'])
            ->orderBy('wedding_date')
            ->get();

        // Format bookings for the calendar
        $events = $bookings->map(function ($project) {
            return [
                'title' => $project->name,
                'date' => $project->wedding_date,
                'status' => $project->status,
                'client_name' => ($project->client->groom_name ?? '') . ' & ' . ($project->client->bride_name ?? ''),
                'project_name' => $project->name,
                'project_id' => $project->id,
            ];
        });

        return view('wo.venues.availability', compact('venue', 'bookings', 'events'));
    }
}
