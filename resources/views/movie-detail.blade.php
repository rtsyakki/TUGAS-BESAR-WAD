@extends('layouts.app')

@section('content')
<div class="container py-5">
    <button type="button" class="btn btn-secondary mb-4" onclick="window.history.back();">&larr; Back</button>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $movie['title'] }}</h2>
            <p><strong>Year:</strong> {{ $movie['year'] }}</p>
            <p><strong>Genres:</strong> {{ isset($movie['genres']) ? implode(', ', $movie['genres']) : '-' }}</p>
            <p><strong>Rating:</strong> {{ $movie['rating'] }}</p>
            <p><strong>Plot:</strong> {{ $movie['plot'] }}</p>
            <p><strong>Special:</strong> {{ isset($movie['special']) ? implode(', ', $movie['special']) : '-' }}</p>
        </div>
    </div>
</div>
@endsection