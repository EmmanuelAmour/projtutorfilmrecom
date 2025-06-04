<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_movie';

    protected $fillable = [
        'title',
        'intro',
        'outro',
        'image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    // Relationships
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_movie', 'id_movie');
    }

    public function watchlist()
    {
        return $this->hasMany(Watchlist::class, 'id_movie', 'id_movie');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'like_movies', 'id_movie', 'id_user')
            ->withTimestamps();
    }

    // Custom Methods
    public function manage_data()
    {
        // Implementation for managing movie data
    }
}
