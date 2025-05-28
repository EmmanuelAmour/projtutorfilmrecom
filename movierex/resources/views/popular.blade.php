@extends('layouts.default')

@section('title', 'Popular Movies')

@section('content')
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold mb-4">Popular movies</h1>
    </div>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($movies as $index => $movie)
                <x-cards.card_movie :movie="$movie" :index="$index" />
            @endforeach
        </div>
    </div>
@endsection
