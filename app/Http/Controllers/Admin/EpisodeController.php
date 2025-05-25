<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    //
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer',
        ]);

        $movie = Movie::findOrFail($movieId);

        if ($movie->type !== 'series') {
            return redirect()->back()->with('error', 'Chỉ phim bộ mới có tập phim');
        }

        $movie->episodes()->create($request->only(['episode_number', 'title', 'video_url', 'duration']));

        return redirect()->route('admin.movies.show', $movie->slug)->with('success', 'Thêm tập phim thành công!');
    }

    public function edit(Episode $episode)
    {
        return view('admin.episodes.edit', compact('episode'));
    }

    public function update(Request $request, Episode $episode)
    {
        $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer',
        ]);

        $episode->update($request->only(['episode_number', 'title', 'video_url', 'duration']));

        return redirect()->route('admin.movies.show', $episode->movie->slug)->with('success', 'Cập nhật tập phim thành công!');
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();
        return redirect()->route('admin.movies.show', $episode->movie->slug)->with('success', 'Xóa tập phim thành công!');
    }

}
