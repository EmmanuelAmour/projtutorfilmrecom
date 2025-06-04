<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comment';

    protected $fillable = [
        'id_movie',
        'id_user',
        'comment',
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

    // Custom Methods
    public function manage_data()
    {
        // Implementation for managing comment data
    }
}
