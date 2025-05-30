@extends('layouts.default')
@section('title', $pageTitle)
@section('content')
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach ($movies as $index => $movie)
            <x-cards.card_movie :movie="$movie" :index="$index" />
        @endforeach
    </div>
    {{-- Ajout de la pagination --}}
    <x-pagination :currentPage="$page" :totalPages="$total_pages" :query="$page" />
@endsection
