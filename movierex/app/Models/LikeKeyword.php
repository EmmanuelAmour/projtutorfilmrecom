<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeKeyword extends Model
{
    use HasFactory;

    protected $table = 'like_keywords';
    protected $primaryKey = 'id_like_keywords';

    protected $fillable = [
        'id_keyword',
        'id_user',
    ];

    // Relationships
    public function keyword()
    {
        return $this->belongsTo(Keyword::class, 'id_keyword', 'id_keyword');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
