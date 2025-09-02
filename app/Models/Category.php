<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Use 'slug' as the route key name for URL binding
    }
}
