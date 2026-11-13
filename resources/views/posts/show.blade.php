@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="mx-auto max-w-3xl space-y-6">
    <a href="{{ route('posts.index') }}"
       class="inline-flex items-center text-xs font-mono text-emerald-400 hover:underline">
        &larr; Back to all announcements
    </a>

    <header class="rounded-lg border border-slate-800 bg-slate-900 p-6 shadow-sm">
        <div class="flex items-center gap-2">
            @if ($post->is_pinned)
                <span class="rounded bg-emerald-500/20 px-2 py-0.5 text-xs font-bold font-mono text-emerald-400 border border-emerald-500/30">
                    Pinned
                </span>
            @endif

            <span class="rounded bg-sky-500/20 px-2 py-0.5 text-xs font-semibold text-sky-400 border border-sky-500/30">
                {{ $post->category }}
            </span>
        </div>

        <h1 class="mt-4 text-3xl font-bold text-white">
            {{ $post->title }}
        </h1>

        <p class="mt-2 text-sm text-slate-400">
            By
            @if ($post->author)
                <a href="{{ route('authors.show', $post->author) }}"
                   class="font-semibold text-blue-400 hover:underline">
                    {{ $post->author->name }}
                </a>
            @else
                <span>Barangay Staff</span>
            @endif
            · {{ $post->views }} views
        </p>

        <div class="mt-3 flex flex-wrap gap-2">
            @foreach ($post->tags as $tag)
                <span class="rounded-full bg-slate-800 px-3 py-0.5 text-xs font-medium text-slate-300">
                    #{{ $tag->name }}
                </span>
            @endforeach
        </div>

        <div class="mt-4 border-t border-slate-800 pt-4 text-slate-300 leading-relaxed whitespace-pre-line">
            {{ $post->body }}
        </div>
    </header>

    <section class="rounded-lg border border-slate-800 bg-slate-900 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-white">
            Comments ({{ $post->comments->count() }})
        </h2>

        @if ($errors->any())
            <div class="mt-3 rounded-md border border-red-300 bg-red-50 p-3 text-sm text-red-800">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4 space-y-3">
                @csrf

                <div>
                    <label for="body" class="block text-sm font-medium text-slate-300">
                        Add a comment
                    </label>

                    <textarea id="body" name="body" rows="3"
                              class="mt-1 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-100">{{ old('body') }}</textarea>

                    @error('body')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="rounded bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    Post Comment
                </button>
            </form>
        @else
            <p class="mt-4 rounded bg-slate-800 p-3 text-sm text-slate-400">
                <a href="{{ route('login') }}" class="font-semibold text-blue-400 hover:underline">
                    Sign in to comment
                </a>.
            </p>
        @endauth

        <div class="mt-6 space-y-4">
            @forelse ($post->comments as $comment)
                <div class="border-t border-slate-800 pt-3">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span class="font-semibold text-slate-300">
                            {{ $comment->user->name }}
                        </span>

                        <span>
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $comment->body }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No comments yet.</p>
            @endforelse
        </div>
    </section>
</article>
@endsection