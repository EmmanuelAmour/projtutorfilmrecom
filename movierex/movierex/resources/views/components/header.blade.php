<header class="bg-gray-800 py-4 border-b-2 border-amber-400">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <a href="/" class="flex items-center space-x-3 hover:scale-105 transition-transform">
            <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

            <img src="{{ asset('img/logo_no_bg.png') }}" alt="movieRex Logo" class="h-10">

            <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                movieRex
            </h1>
        </a>

        <nav class="space-x-4">
            <a href="/popular" class="text-white hover:text-amber-400 transition">Popular</a>
            <a href="/upcoming" class="text-white hover:text-amber-400 transition">Upcoming</a>
            <a href="/top-rated" class="text-white hover:text-amber-400 transition">Top Rated</a>
            <a href="/now-playing" class="text-white hover:text-amber-400 transition">Now Playing</a>
            <a href="/search" class="text-white hover:text-amber-400 transition">Search</a>
    </div>
</header>
