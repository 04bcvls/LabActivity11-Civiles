@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-lg border bg-white p-6 shadow-sm">
    <h1 class="mb-4 text-2xl font-bold text-slate-900">Publish New Barangay Notice</h1>

    @if ($errors->any())
        <div class="mb-5 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-800">
            <p class="font-semibold">Please fix the following errors:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-slate-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}"
                   class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-slate-700">Category</label>
            <select id="category" name="category" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
                <option value="">Select category...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(old('category') === $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="block text-sm font-medium text-slate-700">Tags (select at least one)</span>
            <div class="mt-2 flex flex-wrap gap-3">
                @foreach ($tags as $tag)
                    <label class="inline-flex items-center gap-1.5 text-sm text-slate-700">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               @checked(in_array($tag->id, old('tags', [])))>
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>

            @error('tags')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @error('tags.*')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-slate-700">Announcement Body</label>
            <textarea id="body" name="body" rows="6"
                      class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">{{ old('body') }}</textarea>
            @error('body')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true))>
                <span>Publish immediately</span>
            </label>

            @error('is_published')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            Save Post
        </button>
    </form>
</div>
@endsection