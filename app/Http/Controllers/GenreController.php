<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;

class GenreController extends Controller
{
    // Method untuk halaman Top Genre (tanpa filter)
    public function topGenresPage()
    {
        // Load genres dari database, fallback ke JSON jika kosong
        $genres = Genre::pluck('name')->toArray();

        if (empty($genres)) {
            $genres = json_decode(file_get_contents(public_path('genres.json')), true);
        }

        $bookmarkedMovieIds = [];
        if (Auth::check()) {
            $bookmarkedMovieIds = Bookmark::where('user_id', Auth::id())->pluck('movie_id')->toArray();
        }

        return view('top-genres', [
            'genres' => $genres,
            'selectedGenre' => null,
            'topMovies' => [],
            'bookmarkedMovieIds' => $bookmarkedMovieIds
        ]);
    }

    // Method untuk filter di halaman Top Genre
    public function filterTopGenres(Request $request)
    {
        $selectedGenre = $request->genre;

        // Load genres
        $genres = Genre::pluck('name')->toArray();
        if (empty($genres)) {
            $genres = json_decode(file_get_contents(public_path('genres.json')), true);
        }

        $topMovies = [];
        if ($selectedGenre) {
            $topMovies = Movie::whereHas('genres', function ($query) use ($selectedGenre) {
                $query->where('name', $selectedGenre);
            })
                ->with('genres')
                ->orderByDesc('rating')
                ->limit(5)
                ->get()
                ->map(function ($movie) {
                    return [
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'year' => $movie->year,
                        'rating' => $movie->rating,
                        'plot' => $movie->plot,
                        'genres' => $movie->genres->pluck('name')->toArray()
                    ];
                })->toArray();
        }

        $bookmarkedMovieIds = [];
        if (Auth::check()) {
            $bookmarkedMovieIds = Bookmark::where('user_id', Auth::id())->pluck('movie_id')->toArray();
        }

        return view('top-genres', [
            'genres' => $genres,
            'selectedGenre' => $selectedGenre,
            'topMovies' => $topMovies,
            'bookmarkedMovieIds' => $bookmarkedMovieIds
        ]);
    }
}