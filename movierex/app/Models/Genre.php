<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_genre';

    protected $fillable = [
        'name',
        'description',
        'id_genre_tmdb'
    ];

    // Relationships
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'like_genres', 'id_genre', 'id_user')
            ->withTimestamps();
    }

    // Custom Methods
    public function gestion_donnes()
    {
        // Implementation for managing genre data
    }
}
