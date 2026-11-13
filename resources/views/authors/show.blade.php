@extends('layouts.app')

@section('title', $author->name)

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-sm">
        <h1 class="text-2xl font-black tracking-tight text-white">{{ $author->name }}</h1>
        <p class="text-sm text-slate-400">{{ $author->position }}</p>
        <p class="mt-2 inline-block rounded bg-blue-500/20 px-3 py-1 text-xs font-semibold text-blue-300">
            {{ $commentsReceivedCount }} comments received
        </p>
    </div>

    <div class="space-y-4">
        @foreach ($posts as $post)
            <div class="rounded-xl border border-slate-800 bg-slate-900 p-5 shadow-sm transition hover:border-slate-700">
                <a href="{{ route('posts.show', $post->id) }}" class="text-lg font-bold text-white hover:text-emerald-400">
                    {{ $post->title }}
                </a>
                <p class="mt-1 text-xs text-slate-500">{{ $post->comments_count }} comments</p>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-slate-800 px-2.5 py-0.5 text-xs text-slate-300">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection