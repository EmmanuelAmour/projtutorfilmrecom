@extends('layouts.first') {{-- Assuming your base layout is saved as layouts/app.blade.php --}}

@section('title', $movie['title'])

@section('styles')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .movie-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .animate-detail {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes heartPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .heart-pulse {
            animation: heartPulse 0.3s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen">
        <!-- Backdrop Layer -->
        <div class="fixed inset-0 -z-10 opacity-25">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-gray-900/20"></div>
            <img src="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                alt="" class="object-cover w-full h-full"
                onerror="this.onerror=null;this.src='data:image/svg+xml;base64,...';" loading="eager">
        </div>

        <!-- Content Overlay -->
        <div class="container px-4 mx-auto pt-24 animate-detail text-white">
            <div class="flex flex-col gap-8 lg:flex-row backdrop-blur-sm bg-white/10 rounded-2xl shadow-2xl p-8">

                <!-- Poster -->
                <div class="w-full lg:w-80 transform lg:-translate-y-20">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 rounded-xl shadow-2xl transition-transform duration-300 group-hover:translate-y-2">
                        </div>
                        <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }} poster"
                            class="rounded-xl ring-1 ring-black/10 transition-transform duration-300 group-hover:scale-105"
                            loading="eager">
                    </div>
                </div>

                <!-- Details -->
                <div class="flex-grow space-y-6 text-gray-200">
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h1 class="text-4xl font-bold">{{ $movie['title'] }}</h1>

                            @auth
                                @if ($isLiked)
                                    <form method="POST" action="{{ route('user.unlike.movie', ['movieId' => $movie['id']]) }}"
                                        class="ml-2">
                                        @csrf
                                        @method('DELETE') {{-- <== THIS is the key to making DELETE work --}}
                                        <button type="submit"
                                            class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-white text-red-500 border border-red-500 hover:bg-red-100 hover:scale-105">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                            <span>{{ $isLiked ? 'Un-Like' : 'Like' }}</span>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('user.like.movie', ['movieId' => $movie['id']]) }}"
                                        class="ml-2">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-2 px-4 py-2 rounded-lg
                                            bg-red-500 hover:bg-red-600 text-white hover:scale-105 ">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                            <span>{{ $isLiked ? 'Liked' : 'Like' }}</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex items-center space-x-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg hover:scale-105">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3 c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    <span>Login to Like</span>
                                </a>
                            @endauth
                        </div>

                        <!-- Metadata -->
                        <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap text-gray-300">
                            <div class="p-2 bg-gray-800 rounded-lg">{{ date('Y', strtotime($movie['release_date'])) }}</div>
                            <div class="p-2 bg-gray-800 rounded-lg">{{ $movie['runtime'] }} min</div>
                            @foreach ($movie['genres'] as $genre)
                                <a href="{{ route('search.genre', ['genre' => $genre['name']]) }}"
                                    class="p-2 bg-blue-800 rounded-lg hover:bg-blue-700 text-blue-100">
                                    {{ $genre['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Overview -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-semibold">Overview</h2>
                        <p class="leading-relaxed text-lg max-w-3xl">{{ $movie['overview'] }}</p>
                    </div>

                    <!-- Production -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-semibold">Production Companies</h2>
                        <div class="flex flex-wrap gap-4 p-4 bg-gray-800/60 rounded-xl">
                            @foreach ($movie['production_companies'] as $company)
                                <div
                                    class="flex items-center space-x-2 p-2 bg-gray-900 rounded-lg shadow-sm hover:shadow-md">
                                    @if ($company['logo_path'])
                                        <img src="https://image.tmdb.org/t/p/w200/{{ $company['logo_path'] }}"
                                            alt="{{ $company['name'] }}" class="h-8 object-contain" loading="lazy">
                                    @else
                                        <span class="text-sm font-medium">{{ $company['name'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-8">
                        <h4 class="text-white text-lg font-semibold">Keywords</h4>
                        <div class="flex flex-wrap mt-2 gap-2 ">
                            @foreach ($keywords as $keyword)
                                <a href="{{ route('search.keyword', ['keyword' => $keyword['name']]) }}">
                                    <div class="px-2 py-1 bg-gray-800 text-sm rounded">
                                        <span class="text-sm font-medium text-white">{{ $keyword['name'] }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Toast notification function remains unchanged
    </script>
@endsection
