<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Genre;
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
        return view('client.home', compact('latestSingles', 'latestSeries',));
    }
    public function show($slug)
    {
        $movie = Movie::with(['director', 'country', 'genres', 'actors', 'episodes'])
            ->where('slug', $slug)
            ->firstOrFail();
        $movie->increment('views');
        if ($movie->is_premium) {
            // Nếu chưa đăng nhập
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem phim Premium.');
            }

            // Nếu không phải Premium hoặc đã hết hạn
            if (!auth()->user()->is_premium  ) {
                return redirect()->route('premium.form')->with('error', 'Bạn cần đăng ký Premium để xem phim này.');
            }
        }

        return view('client.details', compact('movie'));
    }
    public function watch($slug, $episodeId = null)
    {
        $movie = Movie::with(['genres', 'actors', 'country', 'director', 'episodes'])->where('slug', $slug)->firstOrFail();

        if ($movie->type == 'movie') {
            $videoUrl = $movie->video_url;
        } else {
            $episode = $movie->episodes->where('id', $episodeId)->first() ?? $movie->episodes->first();
            $videoUrl = $episode->video_url;
            // dd(getYoutubeEmbedUrl($videoUrl));
        }

        return view('client.watch', compact('movie', 'videoUrl'));
    }
    public function genres(Request $request)
    {


        $query = Movie::query();

        $selectedGenreName = null;

        if ($request->has('genre')) {
            $genre = Genre::where('slug', $request->genre)->first();

            if ($genre) {
                $selectedGenreName = $genre->name;

                $query->whereHas('genres', function ($q) use ($genre) {
                    $q->where('genres.id', $genre->id);
                });
            }
        }

        $movies = $query->paginate(12);

        return view('client.categories.genres', [
            'movies' => $movies,
            'selectedGenre' => $selectedGenreName, // <-- truyền tên đầy đủ ra view
        ]);
    }
    public function movie()
    {
        $movies = Movie::where('type', 'movie')->latest()->paginate(12);
        return view('client.categories.movie', compact('movies'));
    }
    public function series()
    {
        $movies = Movie::where('type', 'series')->latest()->paginate(12);
        return view('client.categories.series', compact('movies'));
    }
    public function country($slug)
    {
        $country = Country::where('slug', $slug)->firstOrFail();

        $movies = Movie::where('country_id', $country->id)
            ->latest()
            ->paginate(12);
        // dd($movies);
        return view('client.categories.countries', compact('movies', 'country'));
    }
    public function year($year)
    {
        $movies = Movie::where('year', $year)
            ->latest()
            ->paginate(12);

        return view('client.categories.year', compact('movies', 'year'));
    }
}
