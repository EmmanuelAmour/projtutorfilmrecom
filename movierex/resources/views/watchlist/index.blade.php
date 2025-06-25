@extends('layouts.default')

@section('content')
    <!-- Enhanced Hero Section with Featured Movie -->
    @if(isset($featured_movie))
        <section class="hero-section">
            <div class="hero-background">
                <img src="https://image.tmdb.org/t/p/w1920/{{ $featured_movie->backdrop_path ?? $featured_movie->poster_path }}"
                     alt="{{ $featured_movie->title }}" class="hero-image">
                <div class="hero-overlay"></div>
            </div>

            <div class="hero-content">
                <div class="hero-container">
                    <div class="hero-badges">
                        <span class="badge badge-primary">
                            <i class="fas fa-eye"></i>
                            Next to Watch
                        </span>
                        <span class="badge badge-trending">
                            <i class="fas fa-star"></i>
                            {{ number_format($featured_movie->vote_average ?? 0, 1) }} Rating
                        </span>
                    </div>

                    <h1 class="hero-title">Your Watchlist</h1>

                    <div class="hero-movie-info">
                        <h2 class="movie-title">{{ $featured_movie->title }}</h2>
                        <p class="movie-description">{{ Str::limit($featured_movie->overview, 150) }}</p>

                        <div class="movie-meta">
                            <div class="meta-item">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($featured_movie->vote_average ?? 0, 1) }}/10</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ date('Y', strtotime($featured_movie->release_date)) }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $featured_movie->runtime ?? 120 }} min</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-actions">
                        <a href="{{ route('movie.show', ['id' => $featured_movie->id]) }}" class="btn btn-primary">
                            <i class="fas fa-play"></i>
                            <span>Watch Now</span>
                        </a>
                        <form action="{{ route('watchlist.toggle', $featured_movie->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-check"></i>
                                <span>Mark as Watched</span>
                            </button>
                        </form>
                        <button class="btn btn-secondary">
                            <i class="fas fa-heart"></i>
                            <span>Add to Favorites</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Enhanced Search & Filters -->
    <section class="search-section">
        <div class="search-container">
            <form class="search-form" method="GET" action="{{ route('watchlist.index') }}">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           placeholder="Search your watchlist..." 
                           class="search-input"
                           name="search"
                           value="{{ request('search') }}"
                           id="movieSearch">
                </div>

                <select class="filter-select" name="genre" id="genreFilter">
                    <option value="all">All Genres</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>

                <select class="filter-select" name="sort" id="sortFilter">
                    <option value="added_date" {{ request('sort') == 'added_date' ? 'selected' : '' }}>Recently Added</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                    <option value="release_date" {{ request('sort') == 'release_date' ? 'selected' : '' }}>Release Date</option>
                    <option value="vote_average" {{ request('sort') == 'vote_average' ? 'selected' : '' }}>Rating</option>
                </select>

                <div class="view-toggle">
                    <button type="button" class="btn-view {{ request('view', 'grid') == 'grid' ? 'active' : '' }}" 
                            onclick="toggleView('grid')">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn-view {{ request('view') == 'list' ? 'active' : '' }}" 
                            onclick="toggleView('list')">
                        <i class="fas fa-list"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-filter">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </form>

            <!-- Stats -->
            <div class="watchlist-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $watchlist->count() }}</span>
                    <span class="stat-label">Total Movies</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $watchlist->where('watched', true)->count() }}</span>
                    <span class="stat-label">Watched</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $watchlist->where('watched', false)->count() }}</span>
                    <span class="stat-label">To Watch</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabs Section -->
    <section class="content-section">
        <div class="watchlist-tabs">
            <!-- Tab Navigation -->
            <div class="tabs-list">
                <button class="tab-trigger active" onclick="showTab('all')" data-tab="all">
                    All Movies ({{ $watchlist->count() }})
                </button>
                <button class="tab-trigger" onclick="showTab('watched')" data-tab="watched">
                    Watched ({{ $watchlist->where('watched', true)->count() }})
                </button>
                <button class="tab-trigger" onclick="showTab('unwatched')" data-tab="unwatched">
                    To Watch ({{ $watchlist->where('watched', false)->count() }})
                </button>
            </div>

            <!-- All Movies Tab -->
            <div class="tab-content active" id="tab-all">
                <div class="movie-grid {{ request('view', 'grid') }}">
                    @forelse($watchlist as $movie)
                        @include('watchlist.partials.movie-card', ['movie' => $movie, 'isListView' => request('view') == 'list'])
                    @empty
                        @include('watchlist.partials.empty-state')
                    @endforelse
                </div>
            </div>

            <!-- Watched Movies Tab -->
            <div class="tab-content" id="tab-watched">
                <div class="movie-grid {{ request('view', 'grid') }}">
                    @forelse($watchlist->where('watched', true) as $movie)
                        @include('watchlist.partials.movie-card', ['movie' => $movie, 'isListView' => request('view') == 'list'])
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">✅</div>
                            <h3 class="empty-title">No watched movies yet</h3>
                            <p class="empty-description">Start watching movies from your list!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Unwatched Movies Tab -->
            <div class="tab-content" id="tab-unwatched">
                <div class="movie-grid {{ request('view', 'grid') }}">
                    @forelse($watchlist->where('watched', false) as $movie)
                        @include('watchlist.partials.movie-card', ['movie' => $movie, 'isListView' => request('view') == 'list'])
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">🎬</div>
                            <h3 class="empty-title">All caught up!</h3>
                            <p class="empty-description">You've watched everything in your list. Time to add more movies!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Pagination -->
    @if($watchlist->hasPages())
        <section class="pagination-section">
            <div class="pagination-container">
                {{ $watchlist->appends(request()->query())->links('watchlist.partials.pagination') }}
            </div>
        </section>
    @endif
@endsection

@section('styles')
<style>
/* Modern CSS Variables matching your homepage */
:root {
    --primary-color: #f59e0b;
    --primary-hover: #d97706;
    --gradient-primary: linear-gradient(135deg, #f59e0b, #d97706);
    --gradient-default: linear-gradient(135deg, #6366f1, #8b5cf6);

    --background-primary: #0f172a;
    --background-secondary: #1e293b;
    --background-card: rgba(30, 41, 59, 0.5);

    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;

    --border-color: rgba(148, 163, 184, 0.2);
    --border-radius: 0.75rem;
    --border-radius-lg: 1rem;

    --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Global Styles */
body {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: var(--text-primary);
    min-height: 100vh;
}

/* Hero Section - Same as homepage */
.hero-section {
    position: relative;
    margin: 1rem;
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    min-height: 70vh;
}

.hero-background {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.5) 50%, transparent 100%),
                linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 60%);
}

.hero-content {
    position: relative;
    z-index: 10;
    padding: 4rem 2rem;
    display: flex;
    align-items: center;
    min-height: 70vh;
}

.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.hero-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.hero-title {
    font-size: clamp(3rem, 8vw, 6rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 2rem;
    background: linear-gradient(135deg, #ffffff, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-movie-info {
    margin-bottom: 2rem;
    max-width: 600px;
}

.movie-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.movie-description {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.7;
}

.movie-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
}

.meta-item i {
    color: var(--primary-color);
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Enhanced Buttons - Same as homepage */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border-radius: var(--border-radius);
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1rem;
}

.btn-primary {
    background: var(--gradient-primary);
    color: #000;
    transform: translateY(0);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.btn-icon {
    padding: 0.75rem;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-filter {
    background: var(--gradient-primary);
    color: #000;
}

/* Enhanced Badges - Same as homepage */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
}

.badge-primary {
    background: var(--gradient-primary);
    color: #000;
}

.badge-trending {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.badge-new {
    background: #10b981;
    color: white;
}

.badge-watched {
    background: #059669;
    color: white;
}

.badge-date {
    background: var(--background-card);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.badge-genre {
    background: var(--gradient-default);
    color: white;
}

/* Search Section - Same as homepage */
.search-section {
    margin: 3rem 1rem;
}

.search-container {
    background: rgba(30, 41, 59, 0.5);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 1.5rem;
}

.search-form {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    position: relative;
    flex: 1;
    min-width: 300px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    background: rgba(55, 65, 81, 0.5);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.filter-select {
    padding: 0.75rem 1rem;
    background: rgba(55, 65, 81, 0.5);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    min-width: 150px;
}

.view-toggle {
    display: flex;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.btn-view {
    padding: 0.75rem;
    background: rgba(55, 65, 81, 0.5);
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
}

.btn-view.active {
    background: var(--primary-color);
    color: #000;
}

.btn-view:hover {
    background: var(--primary-color);
    color: #000;
}

/* Stats */
.watchlist-stats {
    display: flex;
    gap: 2rem;
    justify-content: center;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-color);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Content Section */
.content-section {
    margin: 4rem 1rem;
}

.watchlist-tabs {
    max-width: 1200px;
    margin: 0 auto;
}

.tabs-list {
    background: rgba(30, 41, 59, 0.5);
    backdrop-filter: blur(10px);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 0.5rem;
    margin-bottom: 2rem;
    display: flex;
    gap: 0.5rem;
}

.tab-trigger {
    background: transparent;
    color: var(--text-secondary);
    border: none;
    border-radius: calc(var(--border-radius) - 0.25rem);
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: var(--transition);
    cursor: pointer;
    flex: 1;
}

.tab-trigger.active {
    background: var(--gradient-primary);
    color: #000;
}

.tab-trigger:hover {
    background: rgba(245, 158, 11, 0.1);
    color: var(--primary-color);
}

.tab-content {
    display: none;
    min-height: 400px;
}

.tab-content.active {
    display: block;
}

/* Movie Grid */
.movie-grid {
    display: grid;
    gap: 1.5rem;
}

.movie-grid.grid {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
}

.movie-grid.list {
    grid-template-columns: 1fr;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.empty-description {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Pagination */
.pagination-section {
    margin: 3rem 1rem;
}

.pagination-container {
    display: flex;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content {
        padding: 2rem 1rem;
    }

    .hero-title {
        font-size: 3rem;
    }

    .movie-title {
        font-size: 2rem;
    }

    .search-form {
        flex-direction: column;
        align-items: stretch;
    }

    .search-input-wrapper {
        min-width: auto;
    }

    .watchlist-stats {
        gap: 1rem;
    }

    .movie-grid.grid {
        grid-template-columns: 1fr;
    }

    .tabs-list {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .movie-title {
        font-size: 1.5rem;
    }
}

/* Animation Classes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>
@endsection

@section('scripts')
<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all triggers
    document.querySelectorAll('.tab-trigger').forEach(trigger => {
        trigger.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById('tab-' + tabName).classList.add('active');
    
    // Add active class to selected trigger
    document.querySelector('[data-tab="' + tabName + '"]').classList.add('active');
}

// View toggle functionality
function toggleView(view) {
    // Update URL parameter
    const url = new URL(window.location);
    url.searchParams.set('view', view);
    window.history.pushState({}, '', url);
    
    // Update grid classes
    document.querySelectorAll('.movie-grid').forEach(grid => {
        grid.className = 'movie-grid ' + view;
    });
    
    // Update button states
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Toggle watched status
function toggleWatched(movieId) {
    fetch(`/watchlist/${movieId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Remove from watchlist
function removeFromWatchlist(movieId) {
    if (confirm('Are you sure you want to remove this movie from your watchlist?')) {
        fetch(`/watchlist/${movieId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Enhanced search functionality with debouncing
let searchTimeout;
document.getElementById('movieSearch')?.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Auto-submit form after 500ms of no typing
        e.target.closest('form').submit();
    }, 500);
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Watchlist page initialized');
    
    // Add fade-in animation to movie cards
    document.querySelectorAll('.movie-card').forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 100);
    });
});
</script>
@endsection
