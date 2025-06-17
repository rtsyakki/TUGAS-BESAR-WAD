<?php

namespace App\Http\Controllers;

use App\Models\Actor;

class ActorController extends Controller
{
    public function top()
    {
        // Fetch top actors from the database, sorted by popularity
        $actors = Actor::orderByDesc('popularity')->get();

        return view('actors.top', compact('actors'));
    }

    public function movies($id)
    {
        $actor = Actor::with('movies')->findOrFail($id);
        $movies = $actor->movies;

        return view('actors.movies', compact('actor', 'movies'));
    }
}
