@extends('layouts.app')

@section('content')
    <div class="container py-5 text-center">
        {{-- Popup sukses di paling atas --}}
        <div id="bookmark-success" class="alert alert-success alert-dismissible fade show d-none" role="alert">
            Film berhasil ditambahkan ke bookmark!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <h2 class="mb-4">Rekomendasi Film untuk Anda</h2>
        @if ($movie)
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <h4 class="card-title">{{ $movie->title }}</h4>
                    <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p class="card-text"><strong>Tahun:</strong> {{ $movie->year }}</p>
                    <p class="card-text">{{ $movie->plot }}</p>

                    <!-- Bookmark Button -->
                    @auth
                        <button class="btn btn-outline-primary bookmark-btn" data-movie-id="{{ $movie->id }}">
                            <i class="bi bi-bookmark-plus"></i> Add to Bookmark
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-bookmark-plus"></i> Login untuk bookmark
                        </a>
                    @endauth
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

        <div class="mt-4">
            <form action="{{ route('movie-picker.another') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">Get Another Recommendation</button>
            </form>
            <a href="{{ route('movie-picker.retake') }}" class="btn btn-link">Retake Quiz</a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookmarkBtn = document.querySelector('.bookmark-btn');
        const popup = document.getElementById('bookmark-success');
        if (bookmarkBtn) {
            bookmarkBtn.addEventListener('click', function () {
                const movieId = this.dataset.movieId;
                fetch('{{ route("bookmarks.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        movie_id: movieId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (popup) {
                            popup.classList.remove('d-none');
                        }
                        this.innerHTML = '<i class="bi bi-bookmark-check"></i> Added to Bookmark';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-success');
                        this.disabled = true;
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat menambahkan bookmark');
                    }
                })
                .catch(() => {
                    alert('Terjadi kesalahan saat menambahkan bookmark');
                });
            });
        }
    });
</script>
@endsection