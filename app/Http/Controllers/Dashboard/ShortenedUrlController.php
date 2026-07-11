<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;

class ShortenedUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.shortened-urls.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.shortened-urls.create', [
            'tags' => ShortenedUrl::tags(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'slug' => 'nullable|string|max:255|unique:shortened_urls,slug',
            'title' => 'nullable|string|max:120',
            'tags' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = ShortenedUrl::generateUniqueSlug();
        }

        ShortenedUrl::create($validated);

        return $this->created(__('Shortened Url'), 'dashboard.shortened-urls.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortenedUrl $shortenedUrl)
    {
        return view('dashboard.shortened-urls.edit', [
            'shortenedUrl' => $shortenedUrl,
            'tags' => ShortenedUrl::tags(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortenedUrl $shortenedUrl)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:120',
            'tags' => 'nullable|array',
        ]);

        $shortenedUrl->update($validated);

        return $this->updated(__('Shortened Url'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortenedUrl $shortenedUrl)
    {
        $shortenedUrl->delete();

        return $this->deleted(__('Shortened Url'));
    }
}
