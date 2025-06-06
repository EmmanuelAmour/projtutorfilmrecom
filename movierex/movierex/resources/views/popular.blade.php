<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieRex Recommendations</title>
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
    </style>
</head>

<body class="bg-gray-50">
    <x-header>
        <h1 class="text-3xl font-bold text-gray-900">Popular Movies</h1>
    </x-header>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($movies as $index => $movie)
                <x-cards.card_movie :movie="$movie" :index="$index" />
            @endforeach
        </div>
    </div>
</body>

</html>
