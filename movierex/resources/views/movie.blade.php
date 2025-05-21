<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie['title'] }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
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

        .animate-detail {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- resources/views/movie.blade.php -->
    <!-- resources/views/movie.blade.php -->
    <x-header />

    <div class="min-h-screen bg-gray-900">
        <!-- Backdrop Layer -->
        <div class="fixed inset-0 -z-10 opacity-25">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-gray-900/20"></div>
            <img src="https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                alt="" class="object-cover w-full h-full" loading="eager"
                onerror="this.onerror=null;this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTkyMCIgaGVpZ2h0PSI4MDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iIzFhMWIxZiIvPjwvc3ZnPg=='">
        </div>

        <!-- Content Overlay -->
        <div class="container px-4 mx-auto pt-24 animate-detail">
            <div class="flex flex-col gap-8 lg:flex-row backdrop-blur-sm bg-white/90 rounded-2xl shadow-2xl p-8">
                <!-- Poster Card -->
                <div class="flex-shrink-0 w-full lg:w-80 transform lg:-translate-y-20">
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

                <!-- Content Section -->
                <div class="flex-grow space-y-6 text-gray-700">
                    <!-- Header Section -->
                    <div class="space-y-4">
                        <h1
                            class="text-4xl font-bold text-gray-900 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                            {{ $movie['title'] }}
                        </h1>

                        <!-- Metadata Grid -->
                        <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                            <a href="{{ route('search.year', ['year' => $movie['release_date']]) }}">
                                <div class="flex items-center space-x-2 p-2 bg-gray-100/80 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                </div>
                            </a>
                            <div class="flex items-center space-x-2 p-2 bg-gray-100/80 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ $movie['runtime'] }} min</span>
                            </div>


                            <div class="flex items-center space-x-2 p-2 bg-gray-100/80 rounded-lg">
                                <span>Genres:</span>
                            </div>
                            @foreach ($movie['genres'] as $genre)
                                <a href="{{ route('search.genre', ['genre' => $genre['name']]) }}">
                                    <div class="flex items-center space-x-2 p-2 bg-blue-100/80 rounded-lg">
                                        <span class="text-sm font-medium text-blue-800">{{ $genre['name'] }}</span>
                                    </div>
                                </a>
                            @endforeach
                            <br />

                        </div>
                        <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">


                            <div class="flex items-center space-x-2 p-2 bg-gray-100/80 rounded-lg">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                                <span
                                    class="text-sm font-medium">{{ number_format($movie['vote_average'], 1) }}/10</span>
                            </div>


                            <div class="flex items-center space-x-2 p-2 bg-gray-100/80 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                                    <path d="M12.5 7h-1v6h1V7zm0 7h-1v1h1v-1z" />
                                </svg>
                                <span class="text-sm font-medium">
                                    @if ($movie['adult'])
                                        18+ (Explicit Content)
                                    @elseif (!empty($certification))
                                        Rated: {{ $certification }}
                                    @else
                                        Unrated / Not Specified
                                    @endif
                                </span>
                            </div>


                        </div>
                    </div>

                    <!-- Overview Section -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-900">Overview</h2>
                        <p class="text-gray-600 leading-relaxed text-lg max-w-3xl bg-white/50 p-4 rounded-xl">
                            {{ $movie['overview'] }}
                        </p>
                    </div>

                    <!-- Production Section -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-900">Production Partners</h2>
                        <div class="flex flex-wrap gap-4 p-4 bg-gray-100/80 rounded-xl">
                            @foreach ($movie['production_companies'] as $company)
                                <div
                                    class="flex items-center space-x-2 p-2 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    @if ($company['logo_path'])
                                        <img src="https://image.tmdb.org/t/p/w200/{{ $company['logo_path'] }}"
                                            alt="{{ $company['name'] }}" class="h-8 object-contain" loading="lazy">
                                    @else
                                        <span class="text-sm font-medium text-gray-700">{{ $company['name'] }}</span>
                                    @endif
                                </div>
                            @endforeach

                        </div>

                        <div class="space-y-4">
                            <h2 class="text-2xl font-semibold text-gray-900">Keywords</h2>
                            <div class="flex flex-wrap gap-4 p-4 bg-gray-100/80 rounded-xl">
                                @foreach ($keywords as $keyword)
                                    <a href="{{ route('search.keyword', ['keyword' => $keyword['name']]) }}">
                                        <div
                                            class="flex items-center space-x-2 p-2 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                            <span
                                                class="text-sm font-medium text-gray-700">{{ $keyword['name'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
