@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="rounded-lg border bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">{{ $author->name }}</h1>
        <p class="text-sm text-slate-600">{{ $author->position }}</p>
        <p class="mt-2 inline-block rounded bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800">
            {{ $commentsReceivedCount }} comments received
        </p>
    </div>

    <div class="space-y-4">
        @foreach ($posts as $post)
            <div class="rounded-lg border bg-white p-5 shadow-sm">
                <a href="{{ route('posts.show', $post->id) }}" class="text-lg font-bold text-slate-900 hover:underline">
                    {{ $post->title }}
                </a>
                <p class="mt-1 text-xs text-slate-500">{{ $post->comments_count }} comments</p>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs text-slate-700">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection