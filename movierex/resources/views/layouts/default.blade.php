<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo_no_bg.png') }}" type="image/png">

    <title> MovieRex </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM8d7xj1z5l5e5e5e5e5e5e5e5e5e5e5e5e5" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/cards.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .movie-carousel::-webkit-scrollbar {
            height: 8px;
            background: #1f2937;
        }

        .movie-carousel::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 4px;
        }

        .genre-pill {
            background: linear-gradient(145deg, #1f2937 0%, #374151 100%);
            box-shadow: 4px 4px 8px #0f1721, -4px -4px 8px #374151;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <!-- Logo vectoriel SVG -->
    <x-header />
    <main class="container mx-auto px-4 py-8 space-y-12">
        @yield('content')
        <!-- Sections par catégorie -->
    </main>
    <script>
        // Carrousel horizontal
        const carousel = document.querySelector('.movie-carousel');
        const scrollAmount = 300; // Amount to scroll on each button click

        document.querySelectorAll('.carousel-nav').forEach(button => {
            button.addEventListener('click', () => {
                const direction = button.textContent === '←' ? -1 : 1;
                carousel.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
