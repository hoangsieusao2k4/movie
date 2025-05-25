<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Country;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    //
    public function index()
    {
        $movies = Movie::with(['genres', 'actors', 'director', 'country'])->get();
        // dd($movies);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $countries = Country::all();
        $genres = Genre::all();
        $actors = Actor::all();
        $directors = Director::all();
        return view('admin.movies.create', compact('genres', 'actors', 'directors', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|string|unique:movies|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            // 'thumbnail' => 'nullable|string',
            'trailer_url' => 'nullable|url',
            'video_url'=>'nullable|url',
            'type' => 'required|in:movie,series',
            'is_premium' => 'boolean',
            'status' => 'required|in:public,private,draft',
            'country_id' => 'required|exists:countries,id',
            'director_id' => 'nullable|exists:directors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'actors' => 'required|array',
            'actors.*' => 'exists:actors,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // tối đa 2MB
        ]);
        // dd($request->all());
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('movies', 'public');
        }

        // Tạo movie
        $movie = Movie::create(array_merge(
            $request->except(['genres', 'actors', 'thumbnail']),
            ['thumbnail' => $thumbnailPath]
        ));


        $movie->genres()->sync($request->genres);
        $movie->actors()->sync($request->actors);
        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }
    public function show($slug)
    {
        $movie = Movie::with(['genres', 'actors'])->where('slug', $slug)->firstOrFail();

        return view('admin.movies.show', compact("movie"));
    }
    public function edit($slug)
    {
        // dd($slug);
        $movie = Movie::where('slug', $slug)->firstOrFail();
        $countries = Country::all();
        $genres = Genre::all();
        $actors = Actor::all();
        $directors = Director::all();

        return view('admin.movies.edit', compact('movie', 'countries', 'genres', 'actors', 'directors'));
    }

    public function update(Request $request, $slug)
    {
        $movie = Movie::where('slug', $slug)->firstOrFail();
        $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|string|unique:movies,slug,' . $movie->id . '|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // tối đa 2MB
            'trailer_url' => 'nullable|url',
            'type' => 'required|in:movie,series',
            'is_premium' => 'boolean',
            'status' => 'required|in:public,private,draft',
            'country_id' => 'required|exists:countries,id',
            'director_id' => 'nullable|exists:directors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'actors' => 'required|array',
            'actors.*' => 'exists:actors,id',
        ]);
        // dd($request->all());
        $data = $request->except(['genres', 'actors', 'thumbnail']);

        // Xử lý upload ảnh nếu có
        // Xử lý upload ảnh nếu có
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($movie->thumbnail && Storage::exists($movie->thumbnail)) {
                Storage::delete($movie->thumbnail);
            }

            // Lưu ảnh mới
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('movies', $fileName); // Lưu vào storage/app/movies

            // Cập nhật đường dẫn ảnh trong DB (ví dụ: "movies/anh1.jpg")
            $data['thumbnail'] = 'movies/' . $fileName;
        }


        // Cập nhật thông tin phim
        $movie->update($data);
        // Đồng bộ genres và actors
        $movie->genres()->sync($request->genres);
        $movie->actors()->sync($request->actors);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công');
    }

    public function destroy($slug)
    {
        $movie = Movie::where('slug', $slug)->firstOrFail();
        $movie->genres()->detach();
        $movie->actors()->detach();
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Xóa phim thành công');
    }
}
