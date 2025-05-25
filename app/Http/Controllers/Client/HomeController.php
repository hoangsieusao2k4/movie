<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        // $hotMovies = Movie::orderByDesc('views')->take(10)->get();

        $latestSingles = Movie::where('type', 'movie')->latest()->take(6)->get();

        $latestSeries = Movie::where('type', 'series')->latest()->take(6)->with('episodes')->get();
        // dd($latestSeries,$latestSingles);
        return view('client.home', compact('latestSingles', 'latestSeries'));
    }
    public function show($slug)
    {
        $movie = Movie::with(['director', 'country', 'genres', 'actors', 'episodes'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('client.details', compact('movie'));
    }
}
