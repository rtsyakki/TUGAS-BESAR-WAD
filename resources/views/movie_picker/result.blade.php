@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">Rekomendasi Film untuk Anda</h2>
    @if ($movie)
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="card-title">{{ $movie->title }}</h4>
                <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                <p class="card-text"><strong>Tahun:</strong> {{ $movie->year }}</p>
                <p class="card-text">{{ $movie->plot }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Maaf, tidak ada movie yang sesuai dengan pilihan kamu.
        </div>
        <form method="POST" action="{{ route('movie-picker.random') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Tampilkan Movie Random</button>
        </form>
    @endif
    <form action="{{ route('movie-picker.another') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-primary mt-4">Get Another Recommendation</button>
    </form>
    <a href="{{ route('movie-picker.retake') }}" class="btn btn-link mt-4">Retake Quiz</a>
</div>
@endsection