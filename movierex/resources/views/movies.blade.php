@extends('layouts.default')
@section('title', $pageTitle)

@section('content')
    <!-- Enhanced Page Header -->
    <div class="page-header mb-8 animate-slide-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-responsive-xl gradient-text mb-2">{{ $pageTitle }}</h1>
                <p class="text-gray-400 text-lg">
                    @if (isset($movies) && count($movies) > 0)
                        Showing {{ count($movies) }} movies
                        @if (isset($total_results))
                            of {{ number_format($total_results) }} total results
                        @endif
                    @else
                        No movies found
                    @endif
                </p>
            </div>

            <!-- Enhanced Filter/Sort Options -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="sort-dropdown" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="btn bg-dark-800 border border-dark-600 text-white hover:border-primary-500 transition-all">
                        <i class="fas fa-sort"></i>
                        <span>Sort</span>
                        <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-transition @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-dark-800 border border-dark-600 rounded-xl shadow-xl z-50">
                        <div class="p-2">
                            <a href="#"
                                class="block px-3 py-2 text-sm text-gray-300 hover:bg-dark-700 rounded-lg transition-colors">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                Highest Rated
                            </a>
                            <a href="#"
                                class="block px-3 py-2 text-sm text-gray-300 hover:bg-dark-700 rounded-lg transition-colors">
                                <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                Newest First
                            </a>
                            <a href="#"
                                class="block px-3 py-2 text-sm text-gray-300 hover:bg-dark-700 rounded-lg transition-colors">
                                <i class="fas fa-fire text-red-500 mr-2"></i>
                                Most Popular
                            </a>
                            <a href="#"
                                class="block px-3 py-2 text-sm text-gray-300 hover:bg-dark-700 rounded-lg transition-colors">
                                <i class="fas fa-sort-alpha-down text-green-500 mr-2"></i>
                                A-Z
                            </a>
                        </div>
                    </div>
                </div>

                <!-- View Toggle -->
                <div class="view-toggle flex bg-dark-800 border border-dark-600 rounded-lg p-1">
                    <button class="view-btn active px-3 py-2 rounded-md transition-all" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="view-btn px-3 py-2 rounded-md transition-all" data-view="list">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Loading State -->
    <div id="loading-container" class="hidden">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
            @for ($i = 0; $i < 12; $i++)
                <div class="loading-skeleton aspect-[2/3] rounded-xl"></div>
            @endfor
        </div>
    </div>

    <!-- Enhanced Movie Grid -->
    <div id="movies-container" class="movies-grid">
        @if (isset($movies) && count($movies) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6"
                id="movies-grid">
                @foreach ($movies as $index => $movie)
                    <div class="movie-card-wrapper animate-scale-in" style="animation-delay: {{ $index * 50 }}ms">
                        <x-cards.card_movie :movie="$movie" :index="$index" />
                    </div>
                @endforeach
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state text-center py-16 animate-fade-in">
                <div class="max-w-md mx-auto">
                    <div class="mb-6">
                        <i class="fas fa-film text-6xl text-gray-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-300 mb-4">No Movies Found</h3>
                    <p class="text-gray-500 mb-6">
                        We couldn't find any movies matching your criteria.
                        Try adjusting your filters or search terms.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('index') }}" class="btn bg-primary-500 text-black hover:bg-primary-600">
                            <i class="fas fa-home"></i>
                            Back to Home
                        </a>
                        <button onclick="clearFilters()"
                            class="btn bg-dark-700 text-white hover:bg-dark-600 border border-dark-600">
                            <i class="fas fa-refresh"></i>
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Enhanced Pagination -->
    @if (isset($movies) && count($movies) > 0)
        <div class="pagination-wrapper mt-12 animate-slide-up">
            <x-pagination :currentPage="$page ?? 1" :totalPages="$total_pages ?? 1" :query="request()->query()" class="enhanced-pagination" />
        </div>
    @endif

    <!-- Enhanced Quick Actions FAB -->
    <div class="fixed bottom-6 right-6 z-50" x-data="{ open: false }">
        <div x-show="open" x-transition class="mb-4 space-y-3">
            <button class="fab-action bg-blue-500 hover:bg-blue-600" title="Refresh">
                <i class="fas fa-refresh"></i>
            </button>
            <button class="fab-action bg-green-500 hover:bg-green-600" title="Random Movie">
                <i class="fas fa-random"></i>
            </button>
            <button class="fab-action bg-purple-500 hover:bg-purple-600" title="Watchlist">
                <i class="fas fa-bookmark"></i>
            </button>
        </div>

        <button @click="open = !open" class="fab-main bg-primary-500 hover:bg-primary-600 text-black">
            <i class="fas fa-plus transition-transform" :class="{ 'rotate-45': open }"></i>
        </button>
    </div>

@endsection

@section('styles')
    <style>
        /* Enhanced Page Styles */
        .page-header {
            position: relative;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .page-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        /* Enhanced Filter Dropdown */
        .filter-dropdown,
        .sort-dropdown {
            position: relative;
        }

        /* Enhanced View Toggle */
        .view-toggle .view-btn {
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .view-toggle .view-btn.active {
            background: var(--primary-color);
            color: #000;
        }

        .view-toggle .view-btn:hover:not(.active) {
            background: var(--background-card);
            color: var(--text-primary);
        }

        /* Enhanced Movie Grid */
        .movies-grid {
            min-height: 400px;
        }

        .movie-card-wrapper {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUpFade 0.6s ease-out forwards;
        }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Empty State */
        .empty-state {
            background: var(--background-card);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-xl);
            margin: 2rem 0;
        }

        /* Enhanced FAB Styles */
        .fab-main,
        .fab-action {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
        }

        .fab-action {
            width: 48px;
            height: 48px;
            font-size: 1rem;
            color: white;
        }

        .fab-main:hover,
        .fab-action:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-2xl);
        }

        /* Enhanced Responsive Grid */
        @media (max-width: 640px) {
            .page-header {
                padding: 1rem 0;
            }

            .page-header .flex {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-dropdown,
            .sort-dropdown {
                position: static;
            }

            .filter-dropdown>div,
            .sort-dropdown>div {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90vw;
                max-width: 400px;
            }
        }

        /* Enhanced Loading Animation */
        .loading-skeleton {
            position: relative;
            overflow: hidden;
        }

        .loading-skeleton::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            animation: shimmer 2s infinite;
        }

        /* Enhanced Pagination Styles */
        .enhanced-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            padding: 2rem 0;
        }

        /* Enhanced Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .movie-card-wrapper {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }

        /* Enhanced Print Styles */
        @media print {

            .page-header,
            .pagination-wrapper,
            .fab-main,
            .fab-action {
                display: none;
            }

            .movies-grid {
                display: block;
            }

            .movie-card-wrapper {
                break-inside: avoid;
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Enhanced Page Functionality
        class MovieGridPage {
            constructor() {
                this.currentView = 'grid';
                this.filters = {
                    genre: '',
                    year: '',
                    rating: ''
                };
                this.sortBy = 'popularity';
                this.init();
            }

            init() {
                this.setupViewToggle();
                this.setupFilters();
                this.setupInfiniteScroll();
                this.setupKeyboardShortcuts();
            }

            setupViewToggle() {
                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const view = btn.dataset.view;
                        this.switchView(view);
                    });
                });
            }

            switchView(view) {
                this.currentView = view;
                const grid = document.getElementById('movies-grid');

                // Update button states
                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.view === view);
                });

                // Update grid classes
                if (view === 'list') {
                    grid.className = 'space-y-4';
                    grid.querySelectorAll('.movie-card-wrapper').forEach(wrapper => {
                        wrapper.className = 'movie-card-wrapper list-view';
                    });
                } else {
                    grid.className =
                        'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6';
                    grid.querySelectorAll('.movie-card-wrapper').forEach(wrapper => {
                        wrapper.className = 'movie-card-wrapper';
                    });
                }
            }

            setupFilters() {
                // Filter change handlers
                document.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => {
                        this.applyFilters();
                    });
                });
            }

            applyFilters() {
                const loadingContainer = document.getElementById('loading-container');
                const moviesContainer = document.getElementById('movies-container');

                // Show loading state
                loadingContainer.classList.remove('hidden');
                moviesContainer.classList.add('hidden');

                // Simulate API call
                setTimeout(() => {
                    this.loadMovies();
                }, 1000);
            }

            loadMovies() {
                const loadingContainer = document.getElementById('loading-container');
                const moviesContainer = document.getElementById('movies-container');

                // Hide loading state
                loadingContainer.classList.add('hidden');
                moviesContainer.classList.remove('hidden');

                // Animate in new content
                document.querySelectorAll('.movie-card-wrapper').forEach((card, index) => {
                    card.style.animationDelay = `${index * 50}ms`;
                    card.classList.add('animate-scale-in');
                });
            }

            setupInfiniteScroll() {
                let loading = false;

                window.addEventListener('scroll', () => {
                    if (loading) return;

                    const {
                        scrollTop,
                        scrollHeight,
                        clientHeight
                    } = document.documentElement;

                    if (scrollTop + clientHeight >= scrollHeight - 1000) {
                        loading = true;
                        this.loadMoreMovies().then(() => {
                            loading = false;
                        });
                    }
                });
            }

            async loadMoreMovies() {
                // Show loading indicator
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'text-center py-8';
                loadingIndicator.innerHTML = `
                <div class="inline-flex items-center gap-2 text-gray-400">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Loading more movies...</span>
                </div>
            `;

                document.getElementById('movies-grid').appendChild(loadingIndicator);

                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));

                // Remove loading indicator
                loadingIndicator.remove();

                // Add new movies (simulated)
                // In real implementation, this would fetch from your API
            }

            setupKeyboardShortcuts() {
                document.addEventListener('keydown', (e) => {
                    // Ctrl/Cmd + F for filters
                    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                        e.preventDefault();
                        document.querySelector('.filter-dropdown button').click();
                    }

                    // G for grid view
                    if (e.key === 'g' && !e.ctrlKey && !e.metaKey) {
                        this.switchView('grid');
                    }

                    // L for list view
                    if (e.key === 'l' && !e.ctrlKey && !e.metaKey) {
                        this.switchView('list');
                    }

                    // R for refresh
                    if (e.key === 'r' && !e.ctrlKey && !e.metaKey) {
                        location.reload();
                    }
                });
            }
        }

        // Clear filters function
        function clearFilters() {
            document.querySelectorAll('select').forEach(select => {
                select.value = '';
            });

            if (window.movieGridPage) {
                window.movieGridPage.applyFilters();
            }

            window.notificationSystem?.show('Filters cleared', 'info');
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            window.movieGridPage = new MovieGridPage();
            console.log('Enhanced movie grid page initialized');
        });
    </script>
@endsection
