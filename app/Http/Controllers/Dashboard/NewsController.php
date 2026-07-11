<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;
use Redot\Models\Language;
use Redot\Traits\CanUploadFile;

class NewsController extends Controller
{
    use CanUploadFile;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.news.create', [
            'categories' => Category::query(),
            'tags' => News::tags(),
            'locales' => Language::pluck('name', 'code'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'news');
        $validated['media'] = $this->uploadMedia($request);

        if ($request->media_type === 'video' && $request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'news');
        }

        News::create($validated);

        return $this->created(__('News'), 'dashboard.news.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('dashboard.news.edit', [
            'news' => $news,
            'categories' => Category::query(),
            'tags' => News::tags(),
            'locales' => Language::pluck('name', 'code'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $this->validated($request, $news);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'news');
        }

        if ($request->filled('media_type')) {
            $validated['media'] = $this->uploadMedia($request);
        }

        if ($request->media_type === 'video' && $request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'news');
        }

        $news->update($validated);

        return $this->updated(__('News'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return $this->deleted(__('News'));
    }

    /**
     * Validate the request for storing/updating a news article.
     */
    protected function validated(Request $request, ?News $news = null): array
    {
        $locales = implode(',', Language::pluck('code')->all());

        return $request->validate([
            'slug' => 'required|string|alpha_dash|unique:news,slug,' . $news?->id,
            'title' => 'required|string|max:255',
            'locale' => 'required|in:' . $locales,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'cover_image' => ($news ? 'nullable' : 'required') . '|image',
            'media_type' => 'nullable|in:image,gallery,video',
            'image' => 'required_if:media_type,image|image',
            'gallery' => 'required_if:media_type,gallery|array',
            'gallery.*' => 'image',
            'video' => 'required_if:media_type,video|url',
            'thumbnail' => 'nullable|image',
            'tags' => 'nullable|array',
            'published_at' => 'nullable|date',
        ]);
    }

    /**
     * Upload the media for the given media type.
     */
    protected function uploadMedia(Request $request): ?string
    {
        return match ($request->media_type) {
            'image' => $this->uploadFile($request->file('image'), 'news'),
            'gallery' => implode(',', collect($request->file('gallery'))
                ->map(fn ($file) => $this->uploadFile($file, 'news'))
                ->toArray()),
            'video' => $request->string('video')->toString(),
            default => null,
        };
    }
}
