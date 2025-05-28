<div class="space-y-12 p-8 bg-gray-900/50 rounded-xl">
    <!-- Section Films tendances -->
    <section class="space-y-6">
        <h2 class="text-3xl font-bold text-amber-400 border-l-4 border-amber-400 pl-4">À l'affiche aujourd'hui</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Carte Film 1 -->
            <div class="relative group overflow-hidden rounded-2xl aspect-video bg-gray-800">
                <img src="/placeholder-movie.jpg" alt="Lilo & Stitch"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent p-6 flex flex-col justify-end">
                    <div class="space-y-2">
                        <div class="flex gap-2">
                            <span class="genre-pill px-3 py-1 text-sm">Famille</span>
                            <span class="genre-pill px-3 py-1 text-sm">Aventure</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Lilo & Stitch</h3>
                        <button
                            class="mt-2 bg-amber-400 text-gray-900 px-6 py-2 rounded-full font-semibold hover:bg-amber-300 transition-colors">
                            Regarder <i class="ml-2 fas fa-play"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Répéter le pattern pour autres films -->
        </div>
    </section>

    <!-- Section Acteurs populaires -->
    <section class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-amber-400 border-l-4 border-amber-400 pl-4">Stars à suivre</h2>
            <a href="#" class="text-amber-400 hover:text-amber-300 flex items-center gap-2">
                Voir plus <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="flex overflow-x-auto pb-4 gap-8 scrollbar-hide">
            <!-- Carte Acteur -->
            <div class="flex-shrink-0 w-40 text-center">
                <div class="relative group w-40 h-40 rounded-full overflow-hidden border-4 border-amber-400">
                    <img src="/placeholder-actor.jpg" alt="Tom Cruise"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                </div>
                <h3 class="mt-4 font-bold text-white">Tom Cruise</h3>
                <p class="text-gray-400 text-sm">Mission: Impossible</p>
            </div>

            <!-- Répéter pour autres acteurs -->
        </div>
    </section>

    <!-- Guide de visionnage -->
    <div class="bg-gray-800 p-8 rounded-2xl text-center space-y-4">
        <h3 class="text-2xl font-bold text-white">Guide de l'été IMDb</h3>
        <p class="text-gray-400 max-w-2xl mx-auto">Découvrez notre sélection exclusive de films et séries pour l'été</p>
        <button
            class="bg-amber-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-amber-300 transition-colors inline-flex items-center gap-2">
            Explorer le guide <i class="fas fa-arrow-up-right-from-square"></i>
        </button>
    </div>
</div>

<style>
    .genre-pill {
        @apply bg-gray-700/50 backdrop-blur-sm rounded-full text-white;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    // Navigation horizontale pour les acteurs
    const actorScroll = document.querySelector('[aria-label="Acteurs"]');
    const scrollValue = 180;

    document.querySelectorAll('.scroll-button').forEach(button => {
        button.addEventListener('click', () => {
            actorScroll.scrollBy({
                left: button.dataset.direction === 'left' ? -scrollValue : scrollValue,
                behavior: 'smooth'
            });
        });
    });
</script>
