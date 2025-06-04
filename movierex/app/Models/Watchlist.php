<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $table = 'watchlist';
    protected $primaryKey = 'id_watchlist';

    protected $fillable = [
        'id_movie',
        'id_user',
        'ss',
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
