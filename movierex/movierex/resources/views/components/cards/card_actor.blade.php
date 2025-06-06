<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow text-black">
    <!-- Ajout text-black ici -->
    @if ($actor['profile_path'])
        <img src="https://image.tmdb.org/t/p/w300/{{ $actor['profile_path'] }}" alt="{{ $actor['name'] }}"
            class="w-full h-64 object-cover">
    @else
        <div class="bg-gray-200 h-64 flex items-center justify-center">
            <span class="text-gray-800">@lang('Image not available')</span> <!-- Changé de gray-500 à gray-800 -->
        </div>
    @endif
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-2">{{ $actor['name'] }}</h2> <!-- Retiré 'black' redondant -->

        @if ($actor['known_for_department'])
            <p class="mb-2"> <!-- Retiré text-gray-600 -->
                @lang('Spécialité') : <span class="font-medium">{{ $actor['known_for_department'] }}</span>
            </p>
        @endif

        @if (!empty($actor['known_for']))
            <div class="mt-4">
                <h3 class="font-medium mb-2 text-lg">@lang('Connu pour') :</h3> <!-- Ajout text-lg -->
                <div class="space-y-2">
                    @foreach ($actor['known_for'] as $work)
                        <a href="/movie/{{ $work['id'] }}">
                            <div class="flex items-start space-x-3">
                                @if ($work['poster_path'])
                                    <img src="https://image.tmdb.org/t/p/w92/{{ $work['poster_path'] }}"
                                        alt="{{ $work['title'] ?? $work['name'] }}" class="w-16 flex-none rounded">
                                @endif
                                <div>
                                    <p class="font-medium">
                                        {{ $work['title'] ?? $work['name'] }}
                                    </p>
                                    @if ($work['media_type'] === 'movie')
                                        <p class="text-sm"> <!-- Retiré text-gray-500 -->
                                            @lang('Film') •
                                            {{ $work['release_date'] ? \Carbon\Carbon::parse($work['release_date'])->format('Y') : 'N/A' }}
                                        </p>
                                    @else
                                        <p class="text-sm"> <!-- Retiré text-gray-500 -->
                                            @lang('Série TV') •
                                            {{ $work['first_air_date'] ? \Carbon\Carbon::parse($work['first_air_date'])->format('Y') : 'N/A' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <br>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
