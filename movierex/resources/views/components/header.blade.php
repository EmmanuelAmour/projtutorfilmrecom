<header class="bg-gray-800 py-4 border-b-2 border-amber-400">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <a href="/" class="flex items-center space-x-3 hover:scale-105 transition-transform">
            <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
            <img src="{{ asset('img/logo_no_bg.png') }}" alt="movieRex Logo" class="h-10">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                movieRex
            </h1>
        </a>

        <div class="flex-1 mx-4 max-w-xl">
            <form action="/search" method="GET" class="relative">
                <input type="text" name="query" placeholder="Rechercher un film..."
                    class="w-full px-4 py-2 rounded-full bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400">
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-amber-400 rounded-full hover:bg-amber-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <nav class="space-x-4">
            <a href="/popular" class="text-white hover:text-amber-400 transition">Popular</a>
            <a href="/upcoming" class="text-white hover:text-amber-400 transition">Upcoming</a>
            <a href="/top-rated" class="text-white hover:text-amber-400 transition">Top Rated</a>
            <a href="/now-playing" class="text-white hover:text-amber-400 transition">Now Playing</a>
        </nav>
    </div>
</header>
