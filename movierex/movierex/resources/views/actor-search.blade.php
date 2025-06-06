@extends('layouts.default')
@section('title', $search_term)
@section('content')
    <h1 class="text-3xl font-bold mb-6">@lang('Résultats pour') : "{{ $search_term }}"</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($results as $actor)
            <x-cards.card_actor :actor="$actor" />
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
