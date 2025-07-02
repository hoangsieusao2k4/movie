<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'year',
        'thumbnail',
        'trailer_url',
        'video_url',
        'type',
        'is_premium',
        'status',
        'country_id',
        'director_id'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'year' => 'integer',
    ];
    public static function boot()
    {
        parent::boot();

        // Lắng nghe sự kiện tạo mới và cập nhật để tự động tạo slug
        static::saving(function ($movie) {
            $movie->slug = Str::slug($movie->title);
        });
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function director()
    {
        return $this->belongsTo(Director::class, 'director_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie', 'movie_id', 'actor_id');
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
