<div class="empty-state">
    <div class="empty-icon">🎬</div>
    <h3 class="empty-title">No movies found</h3>
    <p class="empty-description">
        @if(request('search') || request('genre') != 'all')
            Try adjusting your search or filters to find more movies.
        @else
            Your watchlist is empty. Start adding movies to build your collection!
        @endif
    </p>
    <a href="{{ route('movies.index') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Browse Movies
    </a>
</div>
