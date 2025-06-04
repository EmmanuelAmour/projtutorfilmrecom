@extends('layouts.default')
@section('title', $genre)
@section('content')
    <section class="mb-12">
        <!-- En-tête avec navigation -->
        <div class="flex justify-between items-start mb-8">
            <div class="flex flex-col">
                <h1 class="text-4xl font-bold mb-2 flex items-center gap-3">
                    {{ $genre }}
                    <span class="text-2xl font-medium text-amber-400">films</span>

                    <!-- Bouton Like -->
                    <form method="POST" action="{{ route('user.like.genre', ['id' => $id_genre]) }}" class="ml-2">
                        @csrf
                        <button type="submit" class="p-2 rounded-full bg-gray-800 hover:bg-amber-400 transition-colors">
                            <svg class="w-6 h-6 @if ($isLiked) fill-rose-400 stroke-rose-400 @else fill-transparent stroke-current @endif"
                                viewBox="0 0 24 24">
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                            </svg>
                        </button>
                    </form>
                </h1>

                <!-- Compteur de films -->
                <p class="text-lg text-gray-300">
                    {{ number_format($total_results, 0, ',', ' ') }} of {{ $genre }} movies
                </p>
            </div>

            <!-- Contrôles du carousel -->
            <div class="flex space-x-3 mt-2">
                <button
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 transition-colors carousel-prev
                       hover:scale-105 active:scale-95">
                    ←
                </button>
                <button
                    class="p-3 rounded-full bg-gray-800 hover:bg-amber-400 transition-colors carousel-next
                       hover:scale-105 active:scale-95">
                    →
                </button>
            </div>
        </div>

        <!-- Grille de films -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @foreach ($movies as $index => $movie)
                <x-cards.card_movie :movie="$movie" :index="$index" />
            @endforeach
        </div>

        <style>
            /* Animation améliorée */
            button {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Effet de profondeur */
            .carousel-prev,
            .carousel-next {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            }
        </style>
    </section>
    <x-pagination :currentPage="$page" :totalPages="$total_pages" :query="$genre" />
@endsection
