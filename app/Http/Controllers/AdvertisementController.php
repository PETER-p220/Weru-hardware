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

    // ... edit, update, destroy methods (similar logic)

    public function destroy(Advertisement $id)
    {
        Storage::disk('public')->delete($id->media_path);
        $id->delete();
        return back()->with('success', 'Deleted!');
    }
}
