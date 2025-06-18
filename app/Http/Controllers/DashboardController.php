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

        // Load genres data
        $genresJson = file_get_contents(public_path('genres.json'));
        $genres = json_decode($genresJson, true); // ubah jadi true untuk konsistensi

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
                    $yearMatch = isset($movie['year']) && str_starts_with((string) $movie['year'], $query);
                    $genresMatch = isset($movie['genres']) && collect($movie['genres'])->filter(function ($g) use ($query) {
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
            'genres' => $genres,
            'selectedGenre' => null,
            'filteredMovies' => []
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

    public function charts()
    {
        // Hitung jumlah film per genre
        $genreCounts = \App\Models\Genre::withCount('movies')->get()->pluck('movies_count', 'name');

        // Hitung jumlah film per rating
        $ratingCounts = \App\Models\Movie::select('rating')
            ->whereNotNull('rating')
            ->groupBy('rating')
            ->selectRaw('rating, COUNT(*) as total')
            ->pluck('total', 'rating');

        return view('dashboard-charts', [
            'genreCounts' => $genreCounts,
            'ratingCounts' => $ratingCounts,
        ]);
    }

    // Menghapus method filter() karena sudah ada di GenreController
}