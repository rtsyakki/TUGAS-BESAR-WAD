
@extends('layouts.app')

@section('content')
<<<<<<< Updated upstream
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">5 Movie Terbaik Genre {{ $genre }}</h2>
    @if(count($topMovies) > 0)
        <ul class="list-disc pl-8">
            @foreach($topMovies as $movie)
                <li class="mb-2">
                    <strong>{{ $movie->title }}</strong> ({{ $movie->year }})<br>
                    Rating: {{ $movie->rating }}<br>
                    <span class="text-sm text-gray-600">{{ $movie->plot }}</span>
                </li>
=======
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Top Movies by Genre</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">← Back</a>
        </div>

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
>>>>>>> Stashed changes
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-500">Tidak ada film untuk genre ini.</p>
    @endif
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection