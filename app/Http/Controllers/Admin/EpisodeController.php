<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{
    //
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'episode_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|file',
            'duration' => 'nullable|integer',
        ]);

        $movie = Movie::findOrFail($movieId);

        if ($movie->type !== 'series') {
            return redirect()->back()->with('error', 'Chỉ phim bộ mới có tập phim');
        }
        $videoPath = null;
        if ($request->hasFile('video_url')) {
            $videoPath = $request->file('video_url')->store('episodes', 'public');
        }
        $movie->episodes()->create([
            'episode_number' => $request->episode_number,
            'title' => $request->title,
            'video_url' => $videoPath, // Lưu đường dẫn vào DB
            'duration' => $request->duration,
        ]);


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
            'video_url' => 'required|file',
            'duration' => 'nullable|integer',
        ]);

        $data = $request->only(['episode_number', 'title', 'duration']);

        // Nếu người dùng upload video mới
        if ($request->hasFile('video_url')) {
            // Xóa file cũ nếu có
            if ($episode->video_url && Storage::disk('public')->exists($episode->video_url)) {
                Storage::disk('public')->delete($episode->video_url);
            }

            // Upload file mới
            $videoPath = $request->file('video_url')->store('episodes', 'public');
            $data['video_url'] = $videoPath;
        }

        $episode->update($data);




        return redirect()->route('admin.movies.show', $episode->movie->slug)->with('success', 'Cập nhật tập phim thành công!');
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();
        return redirect()->route('admin.movies.show', $episode->movie->slug)->with('success', 'Xóa tập phim thành công!');
    }
}
