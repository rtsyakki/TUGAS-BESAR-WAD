<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $movies = [];
        $query = $request->input('q');

        // Ambil data dari movies.json
        $json = file_get_contents(public_path('movies.json'));
        $allMovies = json_decode($json, true);

        if ($query) {
            $query = strtolower($query);

            // Cari yang title-nya diawali query
            $titleMovies = array_filter($allMovies, function ($movie) use ($query) {
                return isset($movie['title']) && str_starts_with(strtolower($movie['title']), $query);
            });

            if (count($titleMovies) > 0) {
                $movies = $titleMovies;
            } else {
                // Jika tidak ada, cari di year, genres, rating
                $movies = array_filter($allMovies, function ($movie) use ($query) {
                    $yearMatch = isset($movie['year']) && str_starts_with((string)$movie['year'], $query);
                    $genresMatch = isset($movie['genres']) && collect($movie['genres'])->filter(function($g) use ($query) {
                        return str_starts_with(strtolower($g), $query);
                    })->isNotEmpty();
                    $ratingMatch = isset($movie['rating']) && str_starts_with(strtolower($movie['rating']), $query);

                    return $yearMatch || $genresMatch || $ratingMatch;
                });
            }
        }

        return view('dashboard', [
            'movies' => $movies,
            'search' => $query,
        ]);
    }

    public function show($slug)
    {
        $json = file_get_contents(public_path('movies.json'));
        $allMovies = json_decode($json, true);

        // Cari movie berdasarkan slug (slug = title yang diubah jadi lowercase, spasi jadi -)
        $movie = collect($allMovies)->first(function ($movie) use ($slug) {
            $titleSlug = strtolower(str_replace([' ', ':', ',', '.', '!', '?', "'", '"'], ['-', '', '', '', '', '', '', ''], $movie['title']));
            $titleSlug = preg_replace('/-+/', '-', $titleSlug); // replace multiple - with single -
            return $titleSlug === $slug;
        });

        if (!$movie) {
            abort(404);
        }

        return view('movie-detail', compact('movie'));
      
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