<header class="bg-gray-800 py-4 border-b-2 border-amber-400 sticky top-0 z-50">
    <div class="container mx-auto px-4 flex flex-wrap items-center justify-between gap-4">
        <!-- Logo -->
        <a href="/"
            class="flex items-center space-x-3 hover:scale-105 transition-transform focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 rounded">
            <img src="{{ asset('img/logo_no_bg.png') }}" alt="movieRex - Accueil" class="h-10 w-10" loading="lazy">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                movieRex
            </h1>
        </a>

        <!-- Barre de recherche -->
        <div class="flex-1 min-w-[300px] max-w-xl order-last lg:order-none w-full lg:w-auto">
            <form id="search-form" action="/search" method="GET" class="relative">
                <input type="text" name="query" id="search-input"
                    placeholder="Rechercher un film, série, acteur..."
                    class="w-full px-4 py-2 rounded-full bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    aria-label="Recherche">
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-amber-400 rounded-full hover:bg-amber-500 transition-colors focus:outline-none focus:ring-2 focus:ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="sr-only">Rechercher</span>
                </button>
            </form>
        </div>

        <!-- Navigation et Bouton de connexion -->
        <div class="flex items-center space-x-6">
            <!-- Navigation -->
            <nav class="flex space-x-4 overflow-x-auto py-2 scrollbar-hide">
                <div class="flex gap-4">
                    <a href="/popular"
                        class="text-white hover:text-amber-400 transition-colors px-3 py-1 rounded-lg hover:bg-gray-700/50 whitespace-nowrap">Popular</a>
                    <a href="/upcoming"
                        class="text-white hover:text-amber-400 transition-colors px-3 py-1 rounded-lg hover:bg-gray-700/50">Upcoming</a>
                    <a href="/trending"
                        class="text-white hover:text-amber-400 transition-colors px-3 py-1 rounded-lg hover:bg-gray-700/50">Trending</a>
                    <a href="/top-rated"
                        class="text-white hover:text-amber-400 transition-colors px-3 py-1 rounded-lg hover:bg-gray-700/50">Top
                        Rated</a>
                    <a href="/now-playing"
                        class="text-white hover:text-amber-400 transition-colors px-3 py-1 rounded-lg hover:bg-gray-700/50">Now
                        Playing</a>
                </div>
            </nav>

            <!-- Bouton de connexion -->
            <div class="flex items-center space-x-3">
                @auth
                    <!-- Si l'utilisateur est connecté -->
                    <div class="flex items-center space-x-3">
                        <span class="text-white text-sm">Bonjour, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-400">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Si l'utilisateur n'est pas connecté -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}"
                            class="bg-amber-400 hover:bg-amber-500 text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-amber-300">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}"
                            class="border border-amber-400 text-amber-400 hover:bg-amber-400 hover:text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-amber-300">
                            S'inscrire
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('search-input').value.trim();
        if (query) {
            window.location.href = `/search/${encodeURIComponent(query)}`;
        } else {
            const input = document.getElementById('search-input');
            input.focus();
            input.setAttribute('aria-invalid', 'true');
            input.parentElement.classList.add('ring-2', 'ring-red-500');
            setTimeout(() => {
                input.removeAttribute('aria-invalid');
                input.parentElement.classList.remove('ring-2', 'ring-red-500');
            }, 2000);
        }
    });
</script>
