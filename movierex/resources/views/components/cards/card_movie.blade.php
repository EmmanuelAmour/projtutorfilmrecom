<a href="/movie/{{ $movie['id'] }}">
    <div class="movie-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
        style="animation-delay: {{ 1 * 0.35 }}s">
        <div class="relative aspect-[2/3]">
            <img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/{{ $movie['poster_path'] }}"
                alt="{{ $movie['title'] }}"
                class="object-cover w-full h-full transition-opacity duration-300 hover:opacity-90" loading="lazy">
            <div class="absolute top-2 right-2 flex items-center bg-black/80 px-2 py-1 rounded-full">
                <svg class="w-4 h-4 text-amber-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <span class="text-white text-sm font-medium">{{ number_format($movie['vote_average'], 1) }}</span>
            </div>
        </div>

        <div class="p-3 space-y-2">
            <h3 class="font-semibold text-gray-900 truncate">{{ $movie['title'] }}</h3>
            <div class="flex items-center text-sm text-gray-500 space-x-2">
                <span>{{ date('Y', strtotime($movie['release_date'])) }}</span>
                <span>•</span>
                <span class="uppercase">{{ $movie['original_language'] }}</span>
            </div>
            <div class="flex items-center justify-between text-sm text-gray-700">

                <div class="flex items-center space-x-1">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span>{{ $movie['popularity'] }}k</span>
                </div>
            </div>
        </div>
    </div>
</a>
