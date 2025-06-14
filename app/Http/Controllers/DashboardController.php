<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        $json = file_get_contents(public_path('genres.json'));
        $genres = json_decode($json);
        return view('dashboard', [
            'genres' => $genres,
            'selectedGenre' => null,
            'filteredMovies' => []
        ]);
    }

    public function filter(Request $request)
    {
        $selectedGenre = $request->genre;
        $json = file_get_contents(public_path('genres.json'));
        $genres = json_decode($json);

        $moviesJson = file_get_contents(public_path('movies.json'));
        $movies = json_decode($moviesJson);

        $filteredMovies = [];
        if ($selectedGenre) {
            $filteredMovies = array_filter($movies, function ($movie) use ($selectedGenre) {
                return isset($movie->genres) && in_array($selectedGenre, $movie->genres);
            });

            // Urutkan berdasarkan rating tertinggi
            usort($filteredMovies, function ($a, $b) {
                return $b->rating <=> $a->rating;
            });

            // Ambil hanya 5 teratas
            $filteredMovies = array_slice($filteredMovies, 0, 5);
        }

        return view('dashboard', [
            'genres' => $genres,
            'selectedGenre' => $selectedGenre,
            'filteredMovies' => $filteredMovies
        ]);
    }
}