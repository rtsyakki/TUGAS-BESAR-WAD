@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Header Simple -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Top Movies by Genre</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <!-- Genre Selection -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('genre.top.filter') }}">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="genre" class="form-label">Select Genre:</label>
                        </div>
                        <div class="col-md-6">
                            <select name="genre" id="genre" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Choose Genre --</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ ($selectedGenre ?? '') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        @if($selectedGenre && count($topMovies) > 0)
            <div class="mb-3">
                <h4>Top 5 Movies - {{ $selectedGenre }}</h4>
                <small class="text-muted">Sorted by highest rating</small>
            </div>

            @foreach($topMovies as $index => $movie)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-1 text-center">
                                <h3 class="text-primary mb-0">#{{ $index + 1 }}</h3>
                            </div>
                            <div class="col-md-9">
                                <h5 class="mb-1">{{ $movie['title'] }} ({{ $movie['year'] }})</h5>
                                <p class="mb-2">
                                    <strong>Genres:</strong> {{ implode(', ', $movie['genres']) }}
                                </p>
                                <p class="text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit($movie['plot'] ?? 'No plot available.', 120) }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <span class="badge bg-warning text-dark fs-6">{{ $movie['rating'] }}/10</span>
                            </div>
                            <div class="col-md-1 text-center">
                                <a href="{{ route('movie.detail', ['slug' => \Illuminate\Support\Str::slug($movie['title'])]) }}"
                                    class="btn btn-sm btn-outline-info">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4">
                <a href="{{ route('genre.top') }}" class="btn btn-outline-secondary">Clear Filter</a>
            </div>

        @elseif($selectedGenre)
            <div class="alert alert-warning text-center">
                <h5>No movies found for genre "{{ $selectedGenre }}"</h5>
                <a href="{{ route('genre.top') }}" class="btn btn-outline-primary">Try Another Genre</a>
            </div>

        @else
            <div class="text-center py-5 text-muted">
                <h4>Select a genre above to see top movies</h4>
                <p>Choose from {{ count($genres) }} available genres</p>
            </div>
        @endif
    </div>
@endsection