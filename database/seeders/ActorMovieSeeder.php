<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;
use App\Models\Movie;

class ActorMovieSeeder extends Seeder
{
    public function run(): void
    {
        $attach = function ($actorName, array $movieTitles) {
            $actor = Actor::where('name', $actorName)->first();
            if ($actor) {
                $movieIds = Movie::whereIn('title', $movieTitles)->pluck('id')->toArray();
                $actor->movies()->syncWithoutDetaching($movieIds);
            }
        };

        $attach('Robert Downey Jr.', ['Avengers: Endgame']);
        $attach('Chris Hemsworth', ['Avengers: Endgame']);
        $attach('Tom Holland', ['Spider-Man: No Way Home', 'Avengers: Endgame']);
        $attach('Zendaya', ['Spider-Man: No Way Home']);
        $attach('Leonardo DiCaprio', ['Killers of the Flower Moon']);
        $attach('Timothée Chalamet', ['Dune', 'Dune: Part Two', 'Wonka']);
        $attach('Emma Stone', ['La La Land']);
        $attach('Florence Pugh', ['Dune: Part Two']);
        $attach('Scarlett Johansson', ['Avengers: Endgame']);
    }
}