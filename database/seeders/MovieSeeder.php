<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $movies = json_decode(file_get_contents(public_path('movies.json')), true);

        foreach ($movies as $movie) {
            // Insert movie
            $movieId = DB::table('movies')->insertGetId([
                'title' => $movie['title'],
                'year' => $movie['year'],
                'rating' => $movie['rating'],
                'plot' => $movie['plot'],
                'special' => json_encode($movie['special']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach genres (assume genres table has 'name' column)
            foreach ($movie['genres'] as $genreName) {
                $genre = DB::table('genres')->where('name', $genreName)->first();
                if ($genre) {
                    DB::table('genre_movie')->insert([
                        'movie_id' => $movieId,
                        'genre_id' => $genre->id,
                    ]);
                }
            }
        }
    }
}