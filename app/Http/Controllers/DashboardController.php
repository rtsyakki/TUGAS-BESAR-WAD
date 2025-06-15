<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }
}