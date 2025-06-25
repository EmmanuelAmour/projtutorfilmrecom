<div class="movie-card {{ $isListView ? 'horizontal-card' : 'vertical-card' }} group">
    <div class="movie-poster-wrapper {{ $isListView ? 'list-poster' : '' }}">
        <img src="https://image.tmdb.org/t/p/w500/{{ $movie->poster_path }}" 
             alt="{{ $movie->title }}" 
             class="movie-poster"
             loading="lazy">

        <div class="movie-overlay">
            <div class="overlay-content">
                <div class="movie-actions-overlay">
                    <a href="{{ route('movie.show', ['id' => $movie->id]) }}" class="btn-icon btn-primary">
                        <i class="fas fa-play"></i>
                    </a>
                    <button class="btn-icon btn-secondary" onclick="toggleWatched({{ $movie->id }})">
                        <i class="fas fa-{{ $movie->watched ? 'eye' : 'eye-slash' }}"></i>
                    </button>
                    <button class="btn-icon btn-secondary">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="movie-badges-overlay">
            @if(!$movie->watched)
                <span class="badge badge-new">
                    <i class="fas fa-clock"></i>
                    To Watch
                </span>
            @else
                <span class="badge badge-watched">
                    <i class="fas fa-check"></i>
                    Watched
                </span>
            @endif
            
            @if($movie->vote_average)
                <div class="rating-badge">
                    <i class="fas fa-star"></i>
                    <span>{{ number_format($movie->vote_average, 1) }}</span>
                </div>
            @endif
        </div>

        <button class="remove-btn" onclick="removeFromWatchlist({{ $movie->id }})">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="movie-info">
        <div class="movie-badges">
            <span class="badge badge-genre">{{ $movie->genre ?? 'Unknown' }}</span>
            <span class="badge badge-date">
                <i class="fas fa-calendar"></i>
                {{ date('d M', strtotime($movie->release_date)) }}
            </span>
        </div>

        <h3 class="movie-title-card">{{ $movie->title }}</h3>
        <p class="movie-overview">{{ Str::limit($movie->overview, $isListView ? 120 : 150) }}</p>

        <div class="movie-footer">
            <div class="movie-rating">
                @if($movie->vote_average)
                    <i class="fas fa-star"></i>
                    <span>{{ number_format($movie->vote_average, 1) }}</span>
                @endif
                <span class="year">{{ date('Y', strtotime($movie->release_date)) }}</span>
                @if($movie->runtime)
                    <div class="runtime">
                        <i class="fas fa-clock"></i>
                        {{ $movie->runtime }}m
                    </div>
                @endif
            </div>
            
            <div class="movie-actions">
                <form action="{{ route('watchlist.toggle', $movie->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <label class="watch-toggle">
                        <input type="checkbox" 
                               {{ $movie->watched ? 'checked' : '' }}
                               onchange="this.form.submit()">
                        <span class="slider"></span>
                    </label>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Movie Card Styles */
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

.vertical-card {
    display: flex;
    flex-direction: column;
}

.horizontal-card {
    display: flex;
    flex-direction: row;
}

.movie-poster-wrapper {
    position: relative;
    height: 24rem;
    overflow: hidden;
}

.horizontal-card .movie-poster-wrapper.list-poster {
    width: 8rem;
    height: 12rem;
    flex-shrink: 0;
}

.movie-poster {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.movie-card:hover .movie-poster {
    transform: scale(1.05);
}

.movie-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 60%);
    opacity: 0;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.movie-card:hover .movie-overlay {
    opacity: 1;
}

.overlay-content {
    display: flex;
    align-items: center;
    justify-content: center;
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

.rating-badge {
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

.remove-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
    cursor: pointer;
    z-index: 10;
}

.movie-card:hover .remove-btn {
    opacity: 1;
}

.remove-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
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
    flex-wrap: wrap;
}

.movie-title-card {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
    transition: var(--transition);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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
    line-height: 1.5;
}

.movie-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.movie-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.movie-rating i {
    color: var(--primary-color);
}

.movie-rating .year {
    color: var(--text-secondary);
    margin-left: 0.5rem;
}

.runtime {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.movie-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

/* Custom Toggle Switch */
.watch-toggle {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.watch-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: var(--primary-color);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .horizontal-card {
        flex-direction: column;
    }
    
    .horizontal-card .movie-poster-wrapper.list-poster {
        width: 100%;
        height: 16rem;
    }
}
</style>
