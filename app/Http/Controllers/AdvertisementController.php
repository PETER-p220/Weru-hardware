<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Storage;


class AdvertisementController extends Controller
{
    //
    public function index()
    {
        $ads = Advertisement::orderBy('sort_order')->get();
        return view ('ads', compact('ads'));
    }

    public function create()
    {
        return view('advertisement');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:51200', // 50MB max
            'link' => 'nullable|url',
        ]);

        $path = $request->file('media')->store('ads', 'public');

        Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'media_type' => str_contains($request->file('media')->getMimeType(), 'video') ? 'video' : 'image',
            'media_path' => $path,
            'link' => $request->link,
            'sort_order' => Advertisement::max('sort_order') + 1,
        ]);
    //    dd($request->all(), $request->hasFile('media'), $request->file('media'));
        return redirect()->route('ads')->with('success', 'Advertisement added!');
    }

    /**
     * Show the form for editing the specified advertisement
     */
    public function edit(Advertisement $ad)
    {
        return view('editAdvertisement', compact('ad'));
    }

    /**
     * Update the specified advertisement
     */
    public function update(Request $request, Advertisement $ad)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:51200', // 50MB max, nullable for updates
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? $ad->sort_order,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        // Only update media if a new file is uploaded
        if ($request->hasFile('media')) {
            // Delete old media file
            Storage::disk('public')->delete($ad->media_path);
            
            // Store new media
            $path = $request->file('media')->store('ads', 'public');
            $data['media_path'] = $path;
            $data['media_type'] = str_contains($request->file('media')->getMimeType(), 'video') ? 'video' : 'image';
        }

        $ad->update($data);

        return redirect()->route('ads')->with('success', 'Advertisement updated successfully!');
    }

    public function destroy(Advertisement $ad)
    {
        Storage::disk('public')->delete($ad->media_path);
        $ad->delete();
        return back()->with('success', 'Advertisement deleted successfully!');
    }
    
}
