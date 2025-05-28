@extends('layouts.default')
@section('title', 'Upcoming Movies')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($movies as $index => $movie)
                <x-cards.card_movie :movie="$movie" :index="$index" />
            @endforeach
        </div>
    </div>
@endsection
