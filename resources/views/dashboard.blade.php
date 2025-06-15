<?php
// No need for use statement here; use fully qualified class names in Blade or import in controller.
?>

@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">Pick a Movie by Mood</h1>
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
                                    <a href="{{ route('movie.detail', ['slug' => \Illuminate\Support\Str::slug($movie['title'])]) }}">
                                        {{ $movie['title'] ?? '-' }}
                                    </a>
                                </h5>
                                <p class="card-text"><strong>Year:</strong> {{ $movie['year'] ?? '-' }}</p>
                                <p class="card-text"><strong>Genres:</strong> {{ isset($movie['genres']) ? implode(', ', $movie['genres']) : '-' }}</p>
                                <p class="card-text"><strong>Rating:</strong> {{ $movie['rating'] ?? '-' }}</p>
                                <div class="movie-plot" id="plot-{{ $loop->index }}" style="display:none;">
                                    <hr>
                                    <strong>Plot:</strong>
                                    <p>{{ $movie['plot'] ?? 'No plot available.' }}</p>
                                </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.movie-title').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var idx = this.getAttribute('data-movie');
                var plot = document.getElementById('plot-' + idx);
                if (plot.style.display === 'none') {
                    plot.style.display = 'block';
                } else {
                    plot.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush