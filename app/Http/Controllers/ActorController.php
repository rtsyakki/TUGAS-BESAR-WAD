<?php

namespace App\Http\Controllers;

use App\Models\Actor;

class ActorController extends Controller
{
    public function top()
    {
        $actors = Actor::orderByDesc('popularity')->take(10)->get();
        return view('actors.top', compact('actors'));
    }

    public function movies($id)
    {
        $actor = Actor::with('movies')->findOrFail($id);
        return view('actors.movies', compact('actor'));
    }
}
