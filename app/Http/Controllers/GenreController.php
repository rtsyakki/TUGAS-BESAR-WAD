<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class GenreController extends Controller
{
<<<<<<< Updated upstream
    public function topGenres()
    {
        $json = File::get(public_path('genres.json'));
        $genres = json_decode($json);
=======
    public function topGenresPage()
    {
        $genres = Genre::pluck('name')->toArray();
>>>>>>> Stashed changes

        // Jika hanya ingin menampilkan semua genre dari JSON
        return view('top-genres', ['topGenres' => $genres]);
    }
    
    public function moviesByGenre($genre)
    {
        $json = file_get_contents(public_path('movies.json'));
        $movies = json_decode($json);

        $filtered = array_filter($movies, function ($movie) use ($genre) {
            return in_array($genre, $movie->genres);
        });

        $ratingOrder = ['G' => 4, 'PG' => 3, 'PG-13' => 2, 'R' => 1];
        usort($filtered, function ($a, $b) use ($ratingOrder) {
            $ra = $ratingOrder[$a->rating] ?? 0;
            $rb = $ratingOrder[$b->rating] ?? 0;
            return $rb <=> $ra;
        });

        $topMovies = array_slice($filtered, 0, 5);

        return response()->json($topMovies);
    }

    public function moviesByGenrePage(Request $request)
    {
        $genre = $request->query('genre');
        $json = file_get_contents(public_path('movies.json'));
        $movies = json_decode($json);

        $filtered = array_filter($movies, function ($movie) use ($genre) {
            return isset($movie->genres) && in_array($genre, $movie->genres);
        });

        $ratingOrder = ['G' => 4, 'PG' => 3, 'PG-13' => 2, 'R' => 1];
        usort($filtered, function ($a, $b) use ($ratingOrder) {
            $ra = $ratingOrder[$a->rating] ?? 0;
            $rb = $ratingOrder[$b->rating] ?? 0;
            return $rb <=> $ra;
        });

        $topMovies = array_slice($filtered, 0, 5);

        return view('top-genres', [
            'genre' => $genre,
            'topMovies' => $topMovies
        ]);
    }

<<<<<<< Updated upstream
    public function apiMoviesByGenre($genre)
    {
        $json = file_get_contents(public_path('movies.json'));
        $movies = json_decode($json);

        $filtered = array_filter($movies, function ($movie) use ($genre) {
            return isset($movie->genres) && in_array($genre, $movie->genres);
        });
=======
    public function filterTopGenres(Request $request)
    {
        $selectedGenre = $request->genre;
 
        $genres = Genre::pluck('name')->toArray();
        if (empty($genres)) {
            $genres = json_decode(file_get_contents(public_path('genres.json')), true);
        }
>>>>>>> Stashed changes

        // Urutkan berdasarkan rating tertinggi ke terendah
        usort($filtered, function ($a, $b) {
            return $b->rating <=> $a->rating;
        });

        // Ambil 5 teratas (atau semua jika kurang dari 5)
        $topMovies = array_slice($filtered, 0, 5);

        return response()->json($topMovies);
    }
}