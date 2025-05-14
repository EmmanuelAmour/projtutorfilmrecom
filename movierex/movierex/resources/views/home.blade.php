@extends('layouts.default')
@section('title', 'Home Page')
@section('content')
    <div class="container">
        <h1>Welcome to MovieRex</h1>
        <p>Your one-stop destination for all things movies!</p>

    </div>
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Popluar</h2>
            <div class="flex space-x-2">
                <button class="carousel-nav p-2 rounded-full bg-gray-800 hover:bg-amber-400">←</button>
                <button class="carousel-nav p-2 rounded-full bg-gray-800 hover:bg-amber-400">→</button>
            </div>
        </div>
        <div class="movie-carousel flex overflow-x-auto pb-4 space-x-4 scroll-smooth">

            <!-- Utilisation de la classe "movie-card" pour chaque film -->
            @foreach ($popular_movies as $index => $movie)
                <x-cards.card_movie :movie="$movie" :index="$index" />
            @endforeach
        </div>
    </section>

    <!-- Sections par catégorie -->
    <div class="grid gap-8 md:grid-cols-2">
        <section>
            <h2 class="text-xl font-bold mb-4 border-l-4 border-amber-400 pl-3">Western</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($keyword_movies as $movie)
                    <div class="bg-gray-800 rounded-lg overflow-hidden genre-pill">
                        <img src="https://image.tmdb.org/t/p/w200_and_h300_bestv2/{{ $movie['poster_path'] }}"
                            class="w-full h-48 object-cover" loading="lazy">
                        <div class="p-2 text-center">
                            <span class="text-sm">{{ $movie['title'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-4 border-l-4 border-amber-400 pl-3">Horreur</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($horror_movies as $movie)
                    <div
                        class="bg-gray-800 rounded-lg overflow-hidden genre-pill hover:border-amber-400 border-transparent border-2">
                        <img src="https://image.tmdb.org/t/p/w200_and_h300_bestv2/{{ $movie['poster_path'] }}"
                            class="w-full h-48 object-cover brightness-75 hover:brightness-100 transition">
                        <div class="p-2 text-center text-sm">
                            {{ $movie['title'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
