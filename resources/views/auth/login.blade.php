@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="mx-auto max-w-md rounded-lg border border-slate-800 bg-slate-900 p-6 shadow-sm">
    <h1 class="mb-5 text-2xl font-bold text-white">Sign In</h1>

    @if ($errors->any())
        <div class="mb-5 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-300">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-100">
            @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-slate-100">
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" value="1">
            <span>Remember me</span>
        </label>

        <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            Sign In
        </button>
    </form>
</div>
@endsection
