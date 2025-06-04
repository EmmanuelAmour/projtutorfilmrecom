<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'profile_picture',
        'role',
        'birth_date',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    // Relationships
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user', 'id_user');
    }

    public function watchlist()
    {
        return $this->hasMany(Watchlist::class, 'id_user', 'id_user');
    }

    public function likedMovies()
    {
        return $this->belongsToMany(Movie::class, 'like_movies', 'id_user', 'id_movie')
            ->withTimestamps();
    }

    public function likedKeywords()
    {
        return $this->belongsToMany(Keyword::class, 'like_keywords', 'id_user', 'id_seo')
            ->withTimestamps();
    }

    public function likedGenres()
    {
        return $this->belongsToMany(Genre::class, 'like_genres', 'id_user', 'id_category')
            ->withTimestamps();
    }

    // Custom Methods
    public function manage_data()
    {
        // Implementation for managing user data
    }

    public function commenter($movie)
    {
        return $this->comments()->where('id_movie', $movie->id_movie)->exists();
    }

    public function like($item)
    {
        // Implementation for liking items
    }

    public function gerer_bookmark()
    {
        // Implementation for managing bookmarks
    }

    public function admin_privilege()
    {
        return $this->role === 'admin';
    }
}
