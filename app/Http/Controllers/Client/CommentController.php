<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:1000',
        'movie_id' => 'required|exists:movies,id',
    ]);

    $comment = Comment::create([
        'movie_id' => $request->movie_id,
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    return response()->json([
        'html' => view('client.components.comment-item', compact('comment'))->render()
    ]);
}

public function fetch(Movie $movie)
{
    $comments = $movie->comments()->with('user')->latest()->get();

    return response()->json([
        'html' => view('client.components.comment-list', compact('comments'))->render()
    ]);
}
}
