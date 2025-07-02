<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            $genres = Genre::all();
            $view->with('genres', $genres);
        });
        View::composer('*', function ($view) {
            $countries = Country::all();
            $view->with('countries', $countries);
        });
        View::composer('*', function ($view) {
            $years = Movie::select('year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year');

            $view->with('years', $years);
        });
        View::composer('*', function ($view) {
            $topViewMovies = Movie::orderBy('views', 'desc')->take(6)->get();
            $view->with('topViewMovies', $topViewMovies);
        });
    }
}
