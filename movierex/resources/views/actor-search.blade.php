@extends('layouts.default')
@section('title', $search_term)
@section('content')
    <h1 class="text-3xl font-bold mb-6">@lang('Résultats pour') : "{{ $search_term }}"</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($results as $actor)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                @if ($actor['profile_path'])
                    <img src="https://image.tmdb.org/t/p/w300/{{ $actor['profile_path'] }}" alt="{{ $actor['name'] }}"
                        class="w-full h-64 object-cover">
                @else
                    <div class="bg-gray-200 h-64 flex items-center justify-center">
                        <span class="text-gray-500">@lang('Image not available')</span>
                    </div>
                @endif

                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2 black">{{ $actor['name'] }}</h2>

                    @if ($actor['known_for_department'])
                        <p class="text-gray-600 mb-2">
                            @lang('Spécialité') : {{ $actor['known_for_department'] }}
                        </p>
                    @endif

                    @if (!empty($actor['known_for']))
                        <div class="mt-4">
                            <h3 class="font-medium mb-2">@lang('Connu pour') :</h3>
                            <div class="space-y-2">
                                @foreach ($actor['known_for'] as $work)
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
                                                <p class="text-sm text-gray-500">
                                                    @lang('Film') •
                                                    {{ $work['release_date'] ? \Carbon\Carbon::parse($work['release_date'])->format('Y') : 'N/A' }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-500">
                                                    @lang('Série TV') •
                                                    {{ $work['first_air_date'] ? \Carbon\Carbon::parse($work['first_air_date'])->format('Y') : 'N/A' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600">@lang('Aucun résultat trouvé')</p>
        @endforelse
    </div>

    @if ($total_pages > 1)
        <div class="mt-8 flex justify-center space-x-2">
            @for ($i = 1; $i <= min($total_pages, 5); $i++)
                <a href="{{ route('actor.search', ['name' => $search_term, 'page' => $i]) }}"
                    class="px-4 py-2 {{ $current_page == $i ? 'bg-blue-600 text-white' : 'bg-white' }} rounded-lg shadow">
                    {{ $i }}
                </a>
            @endfor
        </div>
    @endif
@endsection
