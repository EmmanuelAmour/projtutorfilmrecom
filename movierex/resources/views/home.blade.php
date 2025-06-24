@extends('layouts.default')
@section('title', 'Accueil')
@section('content')
    <!-- Hero Section with Featured Movie -->
    <section class="relative mb-16 rounded-3xl overflow-hidden bg-gradient-to-r from-gray-900 via-gray-800 to-amber-900">
        @if (isset($featured_movie))
            <div class="absolute inset-0">
                <img src="https://image.tmdb.org/t/p/w1920/{{ $featured_movie['backdrop_path'] }}"
                    alt="{{ $featured_movie['title'] }}" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
            </div>
        @endif

        <div class="relative z-10 px-8 py-16 md:py-24">
            <div class="max-w-4xl">
                <div class="flex items-center space-x-2 mb-6">
                    <span class="px-3 py-1 bg-amber-400 text-gray-900 text-sm font-semibold rounded-full">
                        🎬 Film of the day
                    </span>
                    <span class="px-3 py-1 bg-red-600 text-white text-sm font-semibold rounded-full">
                        Trending #1
                    </span>
                </div>

                <h1
                    class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-amber-300 bg-clip-text text-transparent">
                    Explore the Cinema
                </h1>

                @if (isset($featured_movie))
                    <div class="mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">{{ $featured_movie['title'] }}</h2>
                        <p class="text-gray-300 text-lg mb-6 max-w-2xl">{{ Str::limit($featured_movie['overview'], 150) }}
                        </p>

                        <div class="flex items-center space-x-6 mb-8">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-amber-400"></i>
                                <span class="text-white font-semibold">{{ $featured_movie['vote_average'] }}/10</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar text-amber-400"></i>
                                <span class="text-white">{{ date('Y', strtotime($featured_movie['release_date'])) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-clock text-amber-400"></i>
                                <span class="text-white">{{ $featured_movie['runtime'] ?? '120' }} min</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('movie.show', ['id' => $featured_movie['id']]) }}">
                        <button
                            class="px-8 py-4 bg-amber-400 hover:bg-amber-500 text-gray-900 font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                            <i class="fas fa-play"></i>
                            <span>View Details</span>
                        </button>
                    </a>
                    <button
                        class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-sm transition-all duration-300 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Ma liste</span>
                    </button>
                    <button
                        class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-sm transition-all duration-300 flex items-center space-x-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Plus d'infos</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Search & Filters -->
    <section class="mb-12">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un film, acteur, réalisateur..."
                            class="w-full px-4 py-3 pl-12 bg-gray-700 text-white rounded-xl border border-gray-600 focus:border-amber-400 focus:outline-none transition-colors">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <select
                    class="px-4 py-3 bg-gray-700 text-white rounded-xl border border-gray-600 focus:border-amber-400 focus:outline-none">
                    <option value="all">All of th genres</option>
                    @php
                        $genres = App\Models\Genre::all();
                    @endphp
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->name }}">{{ $genre->name }}</option>
                    @endforeach
                </select>

                <select
                    class="px-4 py-3 bg-gray-700 text-white rounded-xl border border-gray-600 focus:border-amber-400 focus:outline-none">
                    <option>ALl of the years</option>

                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                    <option>2021</option>
                    <option>2020</option>
                </select>

                <button
                    class="px-6 py-3 bg-amber-400 hover:bg-amber-500 text-gray-900 font-semibold rounded-xl transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Because you liked :
                    {{ $rex['rex_last_liked_movie_alone']['name'] }} </h2>
                <p class="text-gray-400">The latest published film </p>
            </div>
            <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors">
                View all
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach (array_slice($rex['rex_last_liked_movie_alone']['results'], 0, 3) as $movie)
                <div class="group bg-gray-800 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="flex">
                        <div class="w-32 h-48 flex-shrink-0">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 p-6">
                            <div class="flex items-center space-x-2 mb-3">
                                <span
                                    class="px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">New</span>
                                <span
                                    class="px-2 py-1 bg-gray-700 text-gray-300 text-xs rounded-full">{{ date('d M', strtotime($movie['release_date'])) }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $movie['title'] }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ Str::limit($movie['overview'], 120) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-star text-amber-400"></i>
                                        <span class="text-white font-semibold">{{ $movie['vote_average'] }}</span>
                                    </div>
                                    <span class="text-gray-400">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                </div>

                                <div class="flex space-x-2">
                                    <button
                                        class="p-2 bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-lg transition-colors">
                                        <i class="fas fa-play text-sm"></i>
                                    </button>
                                    <button
                                        class="p-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Trending Now -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">🔥 Current trending</h2>
                <p class="text-gray-400">The trernding movies of this day</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="scrollCarousel('trending', -1)"
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="scrollCarousel('trending', 1)"
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="trending-carousel" class="flex overflow-x-auto pb-4 gap-6 scroll-smooth scrollbar-hide">
            @foreach ($popular_movies as $index => $movie)
                <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                    <div class="w-80 flex-shrink-0">
                        <div
                            class="group relative bg-gray-800 rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div class="relative h-96">
                                <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }}" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <!-- Trending Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-red-600 text-white text-sm font-bold rounded-full">
                                        #{{ $index + 1 }} Trending
                                    </span>
                                </div>

                                <!-- Rating -->
                                <div class="absolute top-4 right-4">
                                    <div
                                        class="bg-black/70 backdrop-blur-sm px-3 py-1 rounded-full flex items-center space-x-1">
                                        <i class="fas fa-star text-amber-400 text-sm"></i>
                                        <span class="text-white font-semibold text-sm">{{ $movie['vote_average'] }}</span>
                                    </div>
                                </div>

                                <!-- Hover Actions -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="flex space-x-3">
                                        <button
                                            class="p-3 bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-full transition-colors">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <button
                                            class="p-3 bg-white/20 hover:bg-white/30 text-white rounded-full backdrop-blur-sm transition-colors">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button
                                            class="p-3 bg-white/20 hover:bg-white/30 text-white rounded-full backdrop-blur-sm transition-colors">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $movie['title'] }}</h3>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($movie['overview'], 100) }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-amber-400 font-semibold">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-eye text-gray-400 text-sm"></i>
                                        <span class="text-gray-400 text-sm">{{ rand(100, 999) }}K vues</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Personalized Recommendations -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-purple-900/20 to-blue-900/20 rounded-2xl p-8 border border-purple-500/20">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">🎯 Recommended for you</h2>
                    <p class="text-gray-400">Based on your tastes and interests</p>
                </div>
                <button
                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-colors">
                    View all
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach (array_slice($rex['rex_genres_alone'], 0, 6) as $movie)
                    <div class="group relative">
                        <div class="aspect-[2/3] rounded-xl overflow-hidden">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <h4 class="text-white font-semibold text-sm mb-1 line-clamp-2">{{ $movie['title'] }}</h4>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-star text-amber-400 text-xs"></i>
                                    <span class="text-white text-xs">{{ $movie['vote_average'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Genre Categories -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Explore by genre</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12">
            @php
                $genres = App\Models\Genre::all();
            @endphp
            @foreach ($genres as $genre)
                <a href="{{ route('search.genre', ['genre' => $genre->name]) }}" target="_blank"
                    rel="noopener noreferrer">
                    <div
                        class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer 
                        bg-gradient-to-br from-gray-800 to-gray-900 hover:from-amber-600 hover:to-amber-800 
                        transition-all duration-300">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <h3 class="text-white font-bold group-hover:text-gray-900 transition-colors">
                                    {{ $genre->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Recently Added -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Because you are interested in movies about :
                    {{ $rex['rex_last_keyword_alone']['name'] }} </h2>
                <p class="text-gray-400">The latest published film </p>
            </div>
            <button
                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors">
                View all
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach (array_slice($rex['rex_last_keyword_alone']['results'], 0, 3) as $movie)
                <div class="group bg-gray-800 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="flex">
                        <div class="w-32 h-48 flex-shrink-0">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 p-6">
                            <div class="flex items-center space-x-2 mb-3">
                                <span
                                    class="px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">New</span>
                                <span
                                    class="px-2 py-1 bg-gray-700 text-gray-300 text-xs rounded-full">{{ date('d M', strtotime($movie['release_date'])) }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $movie['title'] }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ Str::limit($movie['overview'], 120) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-star text-amber-400"></i>
                                        <span class="text-white font-semibold">{{ $movie['vote_average'] }}</span>
                                    </div>
                                    <span class="text-gray-400">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                </div>

                                <div class="flex space-x-2">
                                    <button
                                        class="p-2 bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-lg transition-colors">
                                        <i class="fas fa-play text-sm"></i>
                                    </button>
                                    <button
                                        class="p-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Top Rated Movies -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">⭐ Les mieux notés</h2>
                <p class="text-gray-400">Les films avec les meilleures critiques</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="scrollCarousel('top-rated', -1)"
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="scrollCarousel('top-rated', 1)"
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="top-rated-carousel" class="flex overflow-x-auto pb-4 gap-4 scroll-smooth scrollbar-hide">
            @foreach ($popular_movies as $movie)
                <div class="w-64 flex-shrink-0">
                    <div
                        class="group relative bg-gray-800 rounded-xl overflow-hidden transition-all duration-300 hover:scale-105">
                        <div class="relative h-96">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="w-full h-full object-cover">

                            <!-- Rating Badge -->
                            <div class="absolute top-4 right-4">
                                <div class="bg-amber-400 text-gray-900 px-3 py-1 rounded-full font-bold text-sm">
                                    ⭐ {{ $movie['vote_average'] }}
                                </div>
                            </div>

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="absolute bottom-4 left-4 right-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="text-white font-bold mb-2 line-clamp-2">{{ $movie['title'] }}</h3>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-amber-400 text-sm">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                    <div class="flex space-x-2">
                                        <button
                                            class="p-2 bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-lg transition-colors">
                                            <i class="fas fa-play text-sm"></i>
                                        </button>
                                        <button
                                            class="p-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-sm transition-colors">
                                            <i class="fas fa-heart text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Call to Action -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-3xl p-12 text-center">
            <h2 class="text-4xl font-bold mb-4 text-gray-900">Rejoignez MovieRex Premium</h2>
            <p class="text-gray-800 mb-8 max-w-2xl mx-auto text-lg">
                Accédez à des milliers de films en haute qualité, sans publicité,
                avec des recommandations personnalisées et du contenu exclusif.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <button
                    class="px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-colors">
                    Essai gratuit 30 jours
                </button>
                <button
                    class="px-8 py-4 bg-white/20 hover:bg-white/30 text-gray-900 font-semibold rounded-xl backdrop-blur-sm transition-colors">
                    En savoir plus
                </button>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth transitions for hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Custom gradient backgrounds */
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        /* Backdrop blur support */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>
@endsection



@section('scripts')
    <!-- JavaScript -->
    <script>
        function scrollCarousel(carouselId, direction) {
            const carousel = document.getElementById(carouselId + '-carousel');
            const scrollAmount = carousel.offsetWidth * 0.8 * direction;
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }

        // Auto-scroll for trending carousel
        let autoScrollInterval;

        function startAutoScroll() {
            autoScrollInterval = setInterval(() => {
                scrollCarousel('trending', 1);
            }, 5000);
        }

        function stopAutoScroll() {
            clearInterval(autoScrollInterval);
        }

        // Start auto-scroll when page loads
        document.addEventListener('DOMContentLoaded', startAutoScroll);

        // Stop auto-scroll when user hovers over carousel
        document.getElementById('trending-carousel').addEventListener('mouseenter', stopAutoScroll);
        document.getElementById('trending-carousel').addEventListener('mouseleave', startAutoScroll);

        // Search functionality
        document.querySelector('input[type="text"]').addEventListener('input', function(e) {
            // Implement search suggestions here
            console.log('Searching for:', e.target.value);
        });
    </script>
@endsection
