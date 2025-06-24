<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo_no_bg.png') }}" type="image/png">

    <title> @yield('title') </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM8d7xj1z5l5e5e5e5e5e5e5e5e5e5e5e5e5" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/cards.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
    <style>
        :root {
            --primary-color: #f59e0b;
            --primary-hover: #d97706;
            --secondary-color: #6b7280;
            --accent-color: #ef4444;
            --background-dark: #0f172a;
            --background-card: #1e293b;
            --background-overlay: rgba(15, 23, 42, 0.8);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --gradient-primary: linear-gradient(135deg, #f59e0b, #ea580c);
            --gradient-secondary: linear-gradient(135deg, #6366f1, #8b5cf6);
            --gradient-default: linear-gradient(135deg, #374151, #1f2937);
            --shadow-card: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 20px 40px -10px rgba(245, 158, 11, 0.2);
            --border-radius: 16px;
            --border-radius-lg: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Global Styles */
        body {
            background: var(--background-dark);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
        }

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

<body style="background-color: rgb(17, 24, 39);">
    <div class="notification-container" id="notificationContainer"></div>

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
    @yield('scripts')

</body>

</html>
