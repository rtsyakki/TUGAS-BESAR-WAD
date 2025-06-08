<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'year', 'rating', 'plot', 'special'
    ];

    protected $casts = [
        'special' => 'array',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
