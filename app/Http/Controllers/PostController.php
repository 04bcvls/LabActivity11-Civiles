<?php

// namespace App\Http\Controllers;

// use App\Models\Post;
// use Illuminate\Http\Request;

// class PostController extends Controller
// {
//     public function index(Request $request)
//     {
//         $posts = Post::query()
//             ->where('is_published', true)
//             ->when($request->filled('q'), function ($query) use ($request) {
//                 $query->where('title', 'like', '%' . $request->input('q') . '%');
//             })
//             ->when($request->filled('category'), function ($query) use ($request) {
//                 $query->where('category', $request->input('category'));
//             })
//             ->orderByDesc('is_pinned')
//             ->latest('published_at')
//             ->paginate(7) // 7 letters in CIVILES
//             ->withQueryString();

//         $categories = Post::query()->distinct()->orderBy('category')->pluck('category');

//         return view('posts.index', compact('posts', 'categories'));
//     }

//     public function show($id)
//     {
//         // Ensures drafts return a 404 response
//         $post = Post::where('is_published', true)->findOrFail($id);

//         // Increment views counter using save()
//         $post->views++;
//         $post->save();

//         return view('posts.show', compact('post'));
//     }
// }

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->input('q');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', fn ($q) => $q->where('name', $request->input('tag')));
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7) // Keep your exact Lab 10 per-page number
            ->withQueryString();

        $tags = Tag::orderBy('name')->get();
        $categories = ['Announcement', 'Health', 'Infrastructure', 'Events', 'Safety'];

        return view('posts.index', compact('posts', 'tags', 'categories'));
    }

    public function create(): View
    {
        $tags = Tag::orderBy('name')->get();

        // Keep your exact 5 Lab 10 categories
        $categories = ['Announcement', 'Health', 'Infrastructure', 'Events', 'Safety'];

        return view('posts.create', compact('tags', 'categories'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $isPublished = (bool) $validated['is_published'];

        $post = $request->user()->author->posts()->create([
            ...Arr::except($validated, ['tags']),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        $post->tags()->sync($validated['tags']);

        return redirect()
            ->route('posts.show', $post)
            ->with('status', 'Post published successfully.');
    }

    public function show(int $id): View
    {
        $post = Post::findOrFail($id);
        $post->increment('views');

        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest()->with('user'),
        ]);

        return view('posts.show', compact('post'));
    }
}