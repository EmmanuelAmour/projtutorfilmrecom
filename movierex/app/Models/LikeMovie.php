<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeMovie extends Model
{
    use HasFactory;

    protected $table = 'like_movies';
    protected $primaryKey = 'id_like_movies';

    protected $fillable = [
        'id_movie',
        'id_user',
    ];

    // Relationships
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'id_movie', 'id_movie');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
