<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\TweetService;
use App\Http\Requests\CreateTweetRequest;

class TweetController extends Controller
{
    public function __construct(
        private TweetService $tweetService
    ) {}

    public function index()
    {
        $tweets = $this->tweetService->getAllTweets();

        return Inertia::render('Tweet', [
            'tweets' => $tweets,
        ]);
    }

    public function store(CreateTweetRequest $request)
    {
        $dto = $request->toDTO();
        $tweet = $this->tweetService->createTweet($dto);

        return response()->json($tweet);
    }

    public function like($id)
    {
        $result = $this->tweetService->likeTweet(
            $id,
            auth()->id()
        );

        return response()->json($result);
    }

    public function unlike($id)
    {
        $result = $this->tweetService->unlikeTweet(
            $id,
            auth()->id()
        );

        return response()->json($result);
    }
}
