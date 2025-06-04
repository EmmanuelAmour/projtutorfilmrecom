<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeGenre extends Model
{
    use HasFactory;

    protected $table = 'like_genres';
    protected $primaryKey = 'id_like_genres';

    protected $fillable = [
        'id_genre',
        'id_user',
    ];

    // Relationships
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'id_genre', 'id_genre');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
