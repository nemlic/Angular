<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpamReport;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class SpamReportController extends Controller
{
    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $report = $post->spamReports()->create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
        ]);

        return response()->json($report, 201);
    }
}
