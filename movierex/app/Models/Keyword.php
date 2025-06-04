<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_seo';

    protected $fillable = [
        'name',
        'meta_keywords',
    ];

    // Relationships
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'like_keywords', 'id_seo', 'id_user')
            ->withTimestamps();
    }

    // Custom Methods
    public function manage_data()
    {
        // Implementation for managing keyword data
    }
}
