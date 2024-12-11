<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($postId)
    {
        $post = Post::findOrFail($postId);

        $like = $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return response()->json($like, 201);
    }

    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return response()->json(null, 204);
        }

        return response()->json(['error' => 'Like not found'], 404);
    }
}
