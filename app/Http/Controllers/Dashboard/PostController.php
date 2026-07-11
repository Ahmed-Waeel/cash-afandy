<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;
use Redot\Models\Language;
use Redot\Traits\CanUploadFile;

class PostController extends Controller
{
    use CanUploadFile;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::query(),
            'tags' => Post::tags(),
            'locales' => Language::pluck('name', 'code'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'posts');
        $validated['media'] = $this->uploadMedia($request);

        if ($request->media_type === 'video' && $request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'posts');
        }

        Post::create($validated);

        return $this->created(__('Post'), 'dashboard.posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::query(),
            'tags' => Post::tags(),
            'locales' => Language::pluck('name', 'code'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $this->validated($request, $post);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'posts');
        }

        if ($request->filled('media_type')) {
            $validated['media'] = $this->uploadMedia($request);
        }

        if ($request->media_type === 'video' && $request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'posts');
        }

        $post->update($validated);

        return $this->updated(__('Post'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->deleted(__('Post'));
    }

    /**
     * Validate the request for storing/updating a post.
     */
    protected function validated(Request $request, ?Post $post = null): array
    {
        $locales = implode(',', Language::pluck('code')->all());

        return $request->validate([
            'slug' => 'required|string|alpha_dash|unique:posts,slug,' . $post?->id,
            'title' => 'required|string|max:255',
            'locale' => 'required|in:' . $locales,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'cover_image' => ($post ? 'nullable' : 'required') . '|image',
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
            'image' => $this->uploadFile($request->file('image'), 'posts'),
            'gallery' => implode(',', collect($request->file('gallery'))
                ->map(fn ($file) => $this->uploadFile($file, 'posts'))
                ->toArray()),
            'video' => $request->string('video')->toString(),
            default => null,
        };
    }
}
