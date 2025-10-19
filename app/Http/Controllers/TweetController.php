<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with(['user', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tweet) {
                return [
                    'id' => $tweet->id,
                    'content' => $tweet->content,
                    'user' => [
                        'id' => $tweet->user->id,
                        'email' => $tweet->user->email,
                    ],
                    'likes_count' => $tweet->likes->count(),
                    'liked_by_user' => $tweet->likedByUser(),
                    'created_at' => $tweet->created_at->format('M d, Y h:i A'),
                ];
            });

        return Inertia::render('Tweet', [
            'tweets' => $tweets,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet = auth()->user()->tweets()->create($validated);

        return response()->json([
            'id' => $tweet->id,
            'content' => $tweet->content,
            'user' => [
                'id' => $tweet->user->id,
                'email' => $tweet->user->email,
            ],
            'likes_count' => 0,
            'liked_by_user' => false,
            'created_at' => $tweet->created_at->format('M d, Y h:i A'),
        ]);
    }

    public function like($id)
    {
        $tweet = Tweet::findOrFail($id);
        $userId = auth()->id();

        if (!$tweet->likes()->where('user_id', $userId)->exists()) {
            $tweet->likes()->create(['user_id' => $userId]);
        }

        return response()->json([
            'likes_count' => $tweet->likes()->count(),
            'liked_by_user' => true,
        ]);
    }

    public function unlike($id)
    {
        $tweet = Tweet::findOrFail($id);
        $userId = auth()->id();

        $tweet->likes()->where('user_id', $userId)->delete();

        // Recount after deletion
        $likesCount = $tweet->likes()->count();

        return response()->json([
            'likes_count' => $likesCount,
            'liked_by_user' => false,
        ]);
    }
}
