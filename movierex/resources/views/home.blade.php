@extends('layouts.default')
@section('title', 'Accueil')
@section('content')
    <!-- Enhanced Hero Section with Featured Movie -->
    <section class="hero-section">
        @if (isset($featured_movie))
            <div class="hero-background">
                <img src="https://image.tmdb.org/t/p/w1920/{{ $featured_movie['backdrop_path'] }}"
                    alt="{{ $featured_movie['title'] }}" class="hero-image">
                <div class="hero-overlay"></div>
            </div>
        @endif

        <div class="hero-content">
            <div class="hero-container">
                <div class="hero-badges">
                    <span class="badge badge-primary">
                        <i class="fas fa-sparkles"></i>
                        Film of the day
                    </span>
                    <span class="badge badge-trending">
                        <i class="fas fa-fire"></i>
                        Trending #1
                    </span>
                </div>

                <h1 class="hero-title">Explore the Cinema</h1>

                @if (isset($featured_movie))
                    <div class="hero-movie-info">
                        <h2 class="movie-title">{{ $featured_movie['title'] }}</h2>
                        <p class="movie-description">{{ Str::limit($featured_movie['overview'], 150) }}</p>

                        <div class="movie-meta">
                            <div class="meta-item">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($featured_movie['vote_average'], 1) }}/10</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ date('Y', strtotime($featured_movie['release_date'])) }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $featured_movie['runtime'] ?? '120' }} min</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="hero-actions">
                    <a href="{{ route('movie.show', ['id' => $featured_movie['id']]) }}" class="btn btn-primary">
                        <i class="fas fa-play"></i>
                        <span>View Details</span>
                    </a>
                    <button class="btn btn-secondary">
                        <i class="fas fa-plus"></i>
                        <span>My List</span>
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-info-circle"></i>
                        <span>More Info</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Search & Filters -->
    <section class="search-section ">
        <div class="search-container">
            <div class="search-form">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search movies, actors, directors..." class="search-input"
                        id="movieSearch">
                </div>

                <select class="filter-select" id="genreFilter">
                    <option value="all">All Genres</option>
                    @php
                        $genres = App\Models\Genre::all();
                    @endphp
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->name }}">{{ $genre->name }}</option>
                    @endforeach
                </select>

                <select class="filter-select" id="yearFilter">
                    <option value="all">All Years</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                </select>

                <button class="btn btn-filter">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>
    </section>

    <!-- Because You Liked Section -->
    <section class="recommendations-section">
        <div class="section-header">
            <div class="section-title-wrapper">
                <h2 class="section-title">
                    Because you liked:
                    <a href="{{ route('movie.show', ['id' => $rex['rex_last_liked_movie_alone']['id']]) }}"
                        class="highlight-link">
                        {{ $rex['rex_last_liked_movie_alone']['name'] }}
                    </a>
                </h2>
                <p class="section-subtitle">Personalized recommendations based on your preferences</p>
            </div>
            <button class="btn btn-view-all">View All</button>
        </div>

        <div class="movie-grid">
            @foreach (array_slice($rex['rex_last_liked_movie_alone']['results'], 0, 3) as $movie)
                <div class="movie-card horizontal-card">
                    <div class="movie-poster">
                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}"
                            loading="lazy">
                    </div>
                    <div class="movie-info">
                        <div class="movie-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-date">{{ date('d M', strtotime($movie['release_date'])) }}</span>
                        </div>

                        <h3 class="movie-title-card">{{ $movie['title'] }}</h3>
                        <p class="movie-overview">{{ Str::limit($movie['overview'], 120) }}</p>

                        <div class="movie-footer">
                            <div class="movie-rating">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                <span class="year">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                            </div>
                            <div class="movie-actions">
                                <button class="btn-icon btn-primary">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn-icon btn-secondary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Enhanced Trending Section -->
    <section class="trending-section">
        <div class="section-header">
            <div class="section-title-wrapper">
                <h2 class="section-title">
                    <span class="emoji">🔥</span>
                    Currently Trending
                </h2>
                <p class="section-subtitle">The hottest movies right now</p>
            </div>
            <div class="carousel-controls">
                <button class="carousel-btn" onclick="scrollCarousel('trending', -1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn" onclick="scrollCarousel('trending', 1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="trending-carousel" class="movie-carousel">
            @foreach ($popular_movies as $index => $movie)
                <a href="{{ route('movie.show', ['id' => $movie['id']]) }}" class="carousel-item">
                    <div class="movie-card vertical-card">
                        <div class="movie-poster-wrapper">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="movie-poster-vertical" loading="lazy">

                            <div class="movie-overlay">
                                <div class="overlay-content">
                                    <div class="movie-actions-overlay">
                                        <button class="btn-icon btn-primary">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <button class="btn-icon btn-secondary">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn-icon btn-secondary">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="movie-badges-overlay">
                                <span class="badge badge-trending-number">
                                    #{{ $index + 1 }} Trending
                                </span>
                                <div class="rating-badge">
                                    <i class="fas fa-star"></i>
                                    <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="movie-info-vertical">
                            <h3 class="movie-title-vertical">{{ $movie['title'] }}</h3>
                            <p class="movie-overview-vertical">{{ Str::limit($movie['overview'], 100) }}</p>

                            <div class="movie-meta-vertical">
                                <span class="movie-year">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                <div class="movie-views">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ rand(100, 999) }}K views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Enhanced Personalized Recommendations -->
    <section class="personalized-section">
        <div class="personalized-container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <h2 class="section-title">
                        <i class="fas fa-bullseye section-icon"></i>
                        Recommended for You
                    </h2>
                    <p class="section-subtitle">Curated based on your viewing history and preferences</p>
                </div>
                <button class="btn btn-view-all">View All</button>
            </div>

            <div class="recommendation-grid">
                @foreach (array_slice($rex['rex_genres_alone'], 0, 6) as $movie)
                    <div class="recommendation-item">
                        <div class="recommendation-poster">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" loading="lazy">
                            <div class="recommendation-overlay">
                                <div class="recommendation-info">
                                    <h4 class="recommendation-title">{{ $movie['title'] }}</h4>
                                    <div class="recommendation-rating">
                                        <i class="fas fa-star"></i>
                                        <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Enhanced Genre Categories -->
    <section class="genres-section">
        <h2 class="section-title centered">Explore by Genre</h2>

        <div class="genres-grid">
            @php
                $genreColors = [
                    'Action' => 'from-red-600 to-red-800',
                    'Comedy' => 'from-yellow-500 to-orange-600',
                    'Drama' => 'from-blue-600 to-purple-700',
                    'Horror' => 'from-gray-800 to-black',
                    'Romance' => 'from-pink-500 to-rose-600',
                    'Sci-Fi' => 'from-cyan-500 to-blue-600',
                ];
            @endphp
            @foreach ($genres as $genre)
                <a href="{{ route('search.genre', ['genre' => $genre->name]) }}" class="genre-card"
                    style="background: linear-gradient(135deg, {{ $genreColors[$genre->name] ?? 'var(--gradient-default)' }})">
                    <div class="genre-content">
                        <h3 class="genre-name">{{ $genre->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Keyword-based Recommendations -->
    <section class="recommendations-section">
        <div class="section-header">
            <div class="section-title-wrapper">
                <h2 class="section-title">
                    Because you're interested in:
                    <span class="highlight-text">{{ $rex['rex_last_keyword_alone']['name'] }}</span>
                </h2>
                <p class="section-subtitle">Movies matching your interests</p>
            </div>
            <button class="btn btn-view-all">View All</button>
        </div>

        <div class="movie-grid">
            @foreach (array_slice($rex['rex_last_keyword_alone']['results'], 0, 3) as $movie)
                <div class="movie-card horizontal-card">
                    <div class="movie-poster">
                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}" loading="lazy">
                    </div>
                    <div class="movie-info">
                        <div class="movie-badges">
                            <span class="badge badge-new">New</span>
                            <span class="badge badge-date">{{ date('d M', strtotime($movie['release_date'])) }}</span>
                        </div>

                        <h3 class="movie-title-card">{{ $movie['title'] }}</h3>
                        <p class="movie-overview">{{ Str::limit($movie['overview'], 120) }}</p>

                        <div class="movie-footer">
                            <div class="movie-rating">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                <span class="year">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                            </div>
                            <div class="movie-actions">
                                <button class="btn-icon btn-primary">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn-icon btn-secondary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Enhanced Top Rated Movies -->
    <section class="top-rated-section">
        <div class="section-header">
            <div class="section-title-wrapper">
                <h2 class="section-title">⭐ Top Rated</h2>
                <p class="section-subtitle">Movies with the highest ratings</p>
            </div>
            <div class="carousel-controls">
                <button class="carousel-btn" onclick="scrollCarousel('top-rated', -1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn" onclick="scrollCarousel('top-rated', 1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="top-rated-carousel" class="movie-carousel compact">
            @foreach ($popular_movies as $movie)
                <div class="carousel-item compact">
                    <div class="movie-card compact-card">
                        <div class="movie-poster-wrapper compact">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="movie-poster-compact" loading="lazy">

                            <div class="rating-badge-top">
                                ⭐ {{ number_format($movie['vote_average'], 1) }}
                            </div>

                            <div class="movie-overlay compact">
                                <div class="overlay-content compact">
                                    <h3 class="movie-title-overlay">{{ $movie['title'] }}</h3>
                                    <div class="movie-actions-compact">
                                        <span
                                            class="movie-year-overlay">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                        <div class="actions-buttons">
                                            <button class="btn-icon btn-primary small">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <button class="btn-icon btn-secondary small">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Enhanced Premium CTA -->
    <section class="premium-section">
        <div class="premium-container">
            <div class="premium-content">
                <div class="premium-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <h2 class="premium-title">Join MovieRex Premium</h2>
                <p class="premium-description">
                    Access thousands of high-quality movies, ad-free experience,
                    personalized recommendations, and exclusive content.
                </p>
                <div class="premium-actions">
                    <button class="btn btn-premium-primary">
                        Start 30-Day Free Trial
                    </button>
                    <button class="btn btn-premium-secondary">
                        Learn More
                    </button>
                </div>
            </div>
            <div class="premium-background"></div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        /* Modern CSS Variables */


        /* Hero Section */
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
            background: linear-gradient(to right,
                    rgba(0, 0, 0, 0.8) 0%,
                    rgba(0, 0, 0, 0.5) 50%,
                    transparent 100%),
                linear-gradient(to top,
                    rgba(0, 0, 0, 0.9) 0%,
                    transparent 60%);
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

        /* Enhanced Buttons */
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

        .btn-icon.small {
            padding: 0.5rem;
        }

        /* Enhanced Badges */
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

        .badge-date {
            background: var(--background-card);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        /* Search Section */
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

        .btn-filter {
            background: var(--gradient-primary);
            color: #000;
        }

        /* Section Styles */
        .recommendations-section,
        .trending-section,
        .personalized-section,
        .genres-section,
        .top-rated-section {
            margin: 4rem 1rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title.centered {
            text-align: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .section-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .section-icon {
            color: var(--primary-color);
        }

        .highlight-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .highlight-link:hover {
            color: var(--primary-hover);
        }

        .highlight-text {
            color: var(--primary-color);
        }

        .btn-view-all {
            background: #10b981;
            color: white;
            padding: 0.75rem 1.5rem;
        }

        .btn-view-all:hover {
            background: #059669;
        }

        /* Movie Cards */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .movie-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-color);
        }

        .horizontal-card {
            display: flex;
        }

        .movie-poster {
            width: 8rem;
            height: 12rem;
            flex-shrink: 0;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-info {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .movie-badges {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .movie-title-card {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
            transition: var(--transition);
        }

        .movie-card:hover .movie-title-card {
            color: var(--primary-color);
        }

        .movie-overview {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .movie-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .movie-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .movie-rating i {
            color: var(--primary-color);
        }

        .movie-rating .year {
            color: var(--text-secondary);
            margin-left: 0.5rem;
        }

        .movie-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Carousel Styles */
        .carousel-controls {
            display: flex;
            gap: 0.5rem;
        }

        .carousel-btn {
            padding: 0.75rem;
            background: var(--background-card);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            color: var(--text-primary);
            cursor: pointer;
            transition: var(--transition);
        }

        .carousel-btn:hover {
            background: var(--primary-color);
            color: #000;
            transform: scale(1.1);
        }

        .movie-carousel {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding-bottom: 1rem;
            scroll-behavior: smooth;
        }

        .movie-carousel.compact {
            gap: 1rem;
        }

        .carousel-item {
            flex-shrink: 0;
            width: 320px;
            text-decoration: none;
            color: inherit;
        }

        .carousel-item.compact {
            width: 256px;
        }

        .vertical-card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }

        .vertical-card:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-hover);
        }

        .movie-poster-wrapper {
            position: relative;
            height: 24rem;
        }

        .movie-poster-wrapper.compact {
            height: 20rem;
        }

        .movie-poster-vertical,
        .movie-poster-compact {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.9) 0%,
                    transparent 60%);
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vertical-card:hover .movie-overlay {
            opacity: 1;
        }

        .movie-actions-overlay {
            display: flex;
            gap: 0.75rem;
        }

        .movie-badges-overlay {
            position: absolute;
            top: 1rem;
            left: 1rem;
            right: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .badge-trending-number {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .rating-badge,
        .rating-badge-top {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            padding: 0.5rem 0.75rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .rating-badge-top {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--primary-color);
            color: #000;
        }

        .movie-info-vertical {
            padding: 1.5rem;
        }

        .movie-title-vertical {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .movie-overview-vertical {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .movie-meta-vertical {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .movie-year {
            color: var(--primary-color);
            font-weight: 600;
        }

        .movie-views {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Personalized Section */
        .personalized-container {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1));
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .recommendation-item {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            aspect-ratio: 2/3;
        }

        .recommendation-poster {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .recommendation-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .recommendation-item:hover img {
            transform: scale(1.1);
        }

        .recommendation-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.8) 0%,
                    transparent 60%);
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .recommendation-item:hover .recommendation-overlay {
            opacity: 1;
        }

        .recommendation-title {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recommendation-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
        }

        /* Genre Grid */
        .genres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .genre-card {
            aspect-ratio: 1;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .genre-card:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-hover);
        }

        .genre-content {
            text-align: center;
            z-index: 2;
            position: relative;
        }

        .genre-name {
            font-size: 1.125rem;
            font-weight: 700;
            transition: var(--transition);
        }

        .genre-card:hover .genre-name {
            color: #000;
        }

        /* Premium Section */
        .premium-section {
            margin: 4rem 1rem;
        }

        .premium-container {
            background: var(--gradient-primary);
            border-radius: var(--border-radius-lg);
            padding: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .premium-background {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .premium-content {
            position: relative;
            z-index: 2;
        }

        .premium-icon {
            font-size: 3rem;
            color: #000;
            margin-bottom: 1rem;
        }

        .premium-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 1rem;
        }

        .premium-description {
            font-size: 1.125rem;
            color: rgba(0, 0, 0, 0.8);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .premium-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .btn-premium-primary {
            background: #000;
            color: white;
            padding: 1rem 2rem;
        }

        .btn-premium-primary:hover {
            background: #1f2937;
        }

        .btn-premium-secondary {
            background: rgba(0, 0, 0, 0.2);
            color: #000;
            border: 1px solid rgba(0, 0, 0, 0.2);
            padding: 1rem 2rem;
        }

        .btn-premium-secondary:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Scrollbar Styles */
        .movie-carousel::-webkit-scrollbar {
            display: none;
        }

        .movie-carousel {
            -ms-overflow-style: none;
            scrollbar-width: none;
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

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .movie-grid {
                grid-template-columns: 1fr;
            }

            .carousel-item {
                width: 280px;
            }

            .recommendation-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .genres-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .premium-container {
                padding: 2rem 1rem;
            }

            .premium-title {
                font-size: 2rem;
            }

            .premium-actions {
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

            .section-title {
                font-size: 1.5rem;
            }

            .carousel-item {
                width: 240px;
            }

            .recommendation-grid {
                grid-template-columns: repeat(2, 1fr);
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

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .skeleton {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Enhanced carousel functionality with smooth scrolling
        function scrollCarousel(carouselId, direction) {
            const carousel = document.getElementById(carouselId + '-carousel');
            if (!carousel) return;

            const scrollAmount = carousel.offsetWidth * 0.8 * direction;
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }

        // Auto-scroll functionality with pause on hover
        class AutoScrollCarousel {
            constructor(carouselId, interval = 5000) {
                this.carousel = document.getElementById(carouselId + '-carousel');
                this.interval = interval;
                this.autoScrollTimer = null;
                this.init();
            }

            init() {
                if (!this.carousel) return;

                this.startAutoScroll();

                // Pause on hover
                this.carousel.addEventListener('mouseenter', () => this.stopAutoScroll());
                this.carousel.addEventListener('mouseleave', () => this.startAutoScroll());

                // Pause on focus (accessibility)
                this.carousel.addEventListener('focusin', () => this.stopAutoScroll());
                this.carousel.addEventListener('focusout', () => this.startAutoScroll());
            }

            startAutoScroll() {
                this.stopAutoScroll();
                this.autoScrollTimer = setInterval(() => {
                    this.scrollNext();
                }, this.interval);
            }

            stopAutoScroll() {
                if (this.autoScrollTimer) {
                    clearInterval(this.autoScrollTimer);
                    this.autoScrollTimer = null;
                }
            }

            scrollNext() {
                const maxScroll = this.carousel.scrollWidth - this.carousel.clientWidth;
                if (this.carousel.scrollLeft >= maxScroll) {
                    // Reset to beginning
                    this.carousel.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    scrollCarousel('trending', 1);
                }
            }
        }

        // Enhanced search functionality with debouncing
        class SearchHandler {
            constructor() {
                this.searchInput = document.getElementById('movieSearch');
                this.genreFilter = document.getElementById('genreFilter');
                this.yearFilter = document.getElementById('yearFilter');
                this.debounceTimer = null;
                this.init();
            }

            init() {
                if (this.searchInput) {
                    this.searchInput.addEventListener('input', (e) => this.handleSearch(e));
                }

                if (this.genreFilter) {
                    this.genreFilter.addEventListener('change', (e) => this.handleFilter(e));
                }

                if (this.yearFilter) {
                    this.yearFilter.addEventListener('change', (e) => this.handleFilter(e));
                }
            }

            handleSearch(e) {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 300);
            }

            handleFilter(e) {
                this.performFilter();
            }

            performSearch(query) {
                console.log('Searching for:', query);
                // Add your search logic here
                // You can make AJAX calls to your Laravel backend
            }

            performFilter() {
                const genre = this.genreFilter?.value || 'all';
                const year = this.yearFilter?.value || 'all';
                console.log('Filtering by:', {
                    genre,
                    year
                });
                // Add your filter logic here
            }
        }

        // Intersection Observer for animations
        class AnimationObserver {
            constructor() {
                this.observer = new IntersectionObserver(
                    (entries) => this.handleIntersection(entries), {
                        threshold: 0.1,
                        rootMargin: '50px'
                    }
                );
                this.init();
            }

            init() {
                const elements = document.querySelectorAll('.movie-card, .genre-card, .section-header');
                elements.forEach(el => this.observer.observe(el));
            }

            handleIntersection(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                        this.observer.unobserve(entry.target);
                    }
                });
            }
        }

        // Enhanced loading states
        class LoadingManager {
            static showLoading(element) {
                element.classList.add('loading');
            }

            static hideLoading(element) {
                element.classList.remove('loading');
            }

            static createSkeleton(container, count = 3) {
                container.innerHTML = '';
                for (let i = 0; i < count; i++) {
                    const skeleton = document.createElement('div');
                    skeleton.className = 'movie-card skeleton';
                    skeleton.style.height = '200px';
                    container.appendChild(skeleton);
                }
            }
        }

        // Touch/swipe support for mobile carousels
        class TouchCarousel {
            constructor(carouselId) {
                this.carousel = document.getElementById(carouselId + '-carousel');
                this.startX = 0;
                this.scrollLeft = 0;
                this.init();
            }

            init() {
                if (!this.carousel) return;

                this.carousel.addEventListener('touchstart', (e) => this.handleTouchStart(e));
                this.carousel.addEventListener('touchmove', (e) => this.handleTouchMove(e));
                this.carousel.addEventListener('touchend', (e) => this.handleTouchEnd(e));
            }

            handleTouchStart(e) {
                this.startX = e.touches[0].pageX - this.carousel.offsetLeft;
                this.scrollLeft = this.carousel.scrollLeft;
            }

            handleTouchMove(e) {
                e.preventDefault();
                const x = e.touches[0].pageX - this.carousel.offsetLeft;
                const walk = (x - this.startX) * 2;
                this.carousel.scrollLeft = this.scrollLeft - walk;
            }

            handleTouchEnd(e) {
                // Add momentum scrolling or snap-to-item logic here if needed
            }
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize auto-scroll carousel
            new AutoScrollCarousel('trending', 5000);

            // Initialize search functionality
            new SearchHandler();

            // Initialize animations
            new AnimationObserver();

            // Initialize touch support for carousels
            new TouchCarousel('trending');
            new TouchCarousel('top-rated');

            // Add smooth scrolling to all internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add loading states to buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!this.classList.contains('no-loading')) {
                        LoadingManager.showLoading(this);
                        setTimeout(() => LoadingManager.hideLoading(this), 2000);
                    }
                });
            });

            console.log('MovieRex Enhanced UI initialized successfully!');
        });

        // Performance optimization: Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
@endsection
