<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Country extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($country) {
            $country->slug = Str::slug($country->name);
        });
    }

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

}
