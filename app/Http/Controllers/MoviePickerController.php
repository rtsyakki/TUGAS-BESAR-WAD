<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Movie;
use App\Models\Genre;

class MoviePickerController extends Controller
{
    public function showStart()
    {
        return view('movie_picker.start');
    }

    public function processQuiz(Request $request)
    {
        $step = $request->input('step', 1);
        $answers = Session::get('quiz_answers', []);

        // Simpan jawaban step saat ini
        switch ($step) {
            case 1:
                $answers['mood'] = $request->input('mood');
                break;
            case 2:
                $answers['situation'] = $request->input('situation');
                break;
            case 3:
                $answers['genre'] = $request->input('genre');
                break;
            case 4:
                $answers['release_year'] = $request->input('release_year');
                break;
            case 5:
                $answers['rating'] = $request->input('rating');
                break;
            case 6:
                $answers['special_category'] = $request->input('special_category');
                break;
        }
        Session::put('quiz_answers', $answers);

        // Jika belum selesai, lanjut ke step berikutnya
        if ($step < 6) {
            return redirect()->route('movie-picker.quiz.form', ['step' => $step + 1]);
        } else {
            return redirect()->route('movie-picker.result');
        }
    }

    public function showResult()
    {
        $answers = Session::get('quiz_answers');
        $movie = $this->getRecommendedMovie($answers);
        return view('movie_picker.result', compact('movie'));
    }

    public function getAnother()
    {
        $answers = Session::get('quiz_answers');
        $movie = $this->getRecommendedMovie($answers, true);
        return view('movie_picker.result', compact('movie'));
    }

    public function retakeQuiz()
    {
        Session::forget('quiz_answers');
        return redirect()->route('movie-picker.start');
    }

    public function showQuiz(Request $request)
    {
        $step = $request->query('step', 1);
        $answers = Session::get('quiz_answers', []);
        $genres = Genre::orderBy('name')->pluck('name')->toArray();
        // Ambil juga rating & special dari database jika ingin dinamis
        $ratings = Movie::distinct()->pluck('rating')->toArray();
        $specials = Movie::select('special')->get()->pluck('special')->flatten()->unique()->values()->toArray();

        return view('movie_picker.quiz', compact('step', 'answers', 'genres', 'ratings', 'specials'));
    }

    private function getRecommendedMovie($answers)
    {
        // Query movies dari database
        $query = Movie::with('genres');

        // Filter berdasarkan jawaban quiz
        if (!empty($answers['genre']) && $answers['genre'] != 'Semua Genre') {
            $query->whereHas('genres', function($q) use ($answers) {
                $q->where('name', $answers['genre']);
            });
        }
        if (!empty($answers['release_year']) && $answers['release_year'] != 'Tidak masalah') {
            $now = date('Y');
            $minYear = [
                '5 tahun terakhir' => $now - 5,
                '10 tahun terakhir' => $now - 10,
                '25 tahun terakhir' => $now - 25,
            ][$answers['release_year']] ?? null;
            if ($minYear) {
                $query->where('year', '>=', $minYear);
            }
        }
        if (!empty($answers['rating']) && $answers['rating'] != 'Tidak') {
            $query->where('rating', $answers['rating']);
        }
        if (
            !empty($answers['special_category']) &&
            $answers['special_category'] != 'Bebas'
        ) {
            $query->whereJsonContains('special', $answers['special_category']);
        }

        $movies = $query->get();

        // Jika tidak ada hasil, return null
        if ($movies->isEmpty()) {
            return null;
        }

        // Pilih satu film random dari hasil filter
        $movie = $movies->random();
        $movie->genre = $movie->genres->pluck('name')->implode(', ');

        return $movie;
    }

    public function showRandom()
    {
        $movie = Movie::with('genres')->inRandomOrder()->first();
        $movie->genre = $movie->genres->pluck('name')->implode(', ');
        return view('movie_picker.result', compact('movie'));
    }
}
