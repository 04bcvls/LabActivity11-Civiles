<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col font-sans">
    <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('posts.index') }}" class="text-emerald-400 font-black text-lg tracking-tight">
                Barangay Bulletin
            </a>
            <span class="text-slate-600">|</span>
            <span class="text-xs font-mono text-slate-400">Purok Civiles Desk</span>
        </div>

        <nav class="flex items-center gap-4">
            <a href="{{ route('posts.index') }}" class="font-medium hover:underline">
                Bulletin
            </a>

            @auth
                @if (auth()->user()->author)
                    <a href="{{ route('posts.create') }}"
                       class="rounded bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-blue-700">
                        New post
                    </a>
                @endif

                <span class="text-sm text-slate-300">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:underline">
                    Sign in
                </a>
            @endguest
        </nav>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto p-6 md:p-8">
        @yield('content')
    </main>

    <footer class="bg-slate-900 border-t border-slate-800 px-6 py-4 text-center text-xs text-slate-500">
        Barangay Bulletin &copy; 2026 Matina Crossing, Davao City. Built by Christian Civiles.
    </footer>
</body>
</html>