@extends('layouts.default')
@section('title', 'Accueil')
@section('content')
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur MovieRex</h1>
        <p class="text-gray-400 max-w-2xl mx-auto">Votre destination ultime pour explorer le monde du cinéma</p>
    </div>

    <!-- Section Populaire -->
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Populaire</h2> <!-- Correction orthographique -->
            <div class="flex space-x-2">
                <button onclick="scrollCarousel(-1)"
                    class="p-2 rounded-full bg-gray-800 hover:bg-amber-400 transition-colors">←</button>
                <button onclick="scrollCarousel(1)"
                    class="p-2 rounded-full bg-gray-800 hover:bg-amber-400 transition-colors">→</button>
            </div>
        </div>
        <div class="movie-carousel flex overflow-x-auto pb-4 gap-4 scroll-smooth scrollbar-hide" style="height: auto;">
            @foreach ($popular_movies as $index => $movie)
                <div class="w-64 flex-shrink-0 h-96"> <!-- Hauteur fixe -->
                    <x-cards.card_movie :movie="$movie" :index="$index" />
                </div>
            @endforeach
        </div>
    </section>
    <x-throw1 />

    <!-- Sections catégories - Grille uniforme -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach (['Western', 'Action', 'Drame'] as $genre)
            <!-- Exemple de boucle -->
            <section>
                <h2 class="text-xl font-bold mb-4 border-l-4 border-amber-400 pl-3">{{ $genre }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($keyword_movies as $movie)
                        <div class="group relative h-full flex flex-col"> <!-- Flex pour gestion hauteur -->
                            <div class="grow relative overflow-hidden rounded-lg">
                                <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 space-y-1">
                                    <span class="text-sm font-medium text-white line-clamp-1">{{ $movie['title'] }}</span>
                                    <div class="flex items-center space-x-2 text-amber-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <span>{{ $movie['vote_average'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    <script>
        function scrollCarousel(direction) {
            const carousel = document.querySelector('.movie-carousel');
            const scrollAmount = carousel.offsetWidth * A * direction;
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>


    <!-- Répéter le même pattern pour les autres catégories -->
    </div>
@endsection
