<?php
// No need for use statement here; use fully qualified class names in Blade or import in controller.
?>

@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-row align-items-center justify-content-between mb-5">
            <h1 class="h2 mb-0">Pick a Movie by Mood</h1>
            <!-- Dropdown genre dihapus karena sudah ada di halaman Top Genre -->
        </div>

        <div class="text-center my-5">
            <a href="{{ route('movie-picker.start') }}" class="btn btn-lg btn-primary">Start Now</a>
        </div>

        @if(isset($search) && $search)
            <h4 class="mb-3">Search Results for: <em>{{ $search }}</em></h4>
            @if(count($movies))
                <div class="row">
                    @foreach($movies as $movie)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a
                                            href="{{ route('movie.detail', ['slug' => \Illuminate\Support\Str::slug($movie['title'])]) }}">
                                            {{ $movie['title'] ?? '-' }}
                                        </a>
                                    </h5>
                                    <p class="card-text"><strong>Year:</strong> {{ $movie['year'] ?? '-' }}</p>
                                    <p class="card-text"><strong>Genres:</strong>
                                        {{ isset($movie['genres']) ? implode(', ', $movie['genres']) : '-' }}</p>
                                    <p class="card-text"><strong>Rating:</strong> {{ $movie['rating'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">No movies found.</div>
            @endif
        @endif
    </div>
@endsection