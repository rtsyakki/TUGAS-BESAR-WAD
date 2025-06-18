@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>My Bookmarks</h2>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                </div>

                @if($bookmarks->count() > 0)
                    <div class="row">
                        @foreach($bookmarks as $bookmark)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $bookmark->movie->title }}</h5>
                                        <p class="card-text">
                                            <strong>Genre:</strong> {{ $bookmark->movie->genre }}<br>
                                            <strong>Tahun:</strong> {{ $bookmark->movie->year }}
                                        </p>

                                        @if($bookmark->notes)
                                            <div class="mb-2">
                                                <strong>Notes:</strong>
                                                <p class="text-muted small">{{ Str::limit($bookmark->notes, 100) }}</p>
                                            </div>
                                        @endif

                                        <p class="card-text flex-grow-1">{{ Str::limit($bookmark->movie->plot, 100) }}</p>

                                        <div class="mt-auto">

                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('bookmarks.edit', $bookmark->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('bookmarks.destroy', $bookmark->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus bookmark ini?')">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $bookmarks->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-bookmark display-1 text-muted"></i>
                        <h4 class="mt-3">Belum ada bookmark</h4>
                        <p class="text-muted">Mulai tambahkan film favorit Anda ke bookmark!</p>
                        <a href="{{ route('movie-picker.start') }}" class="btn btn-primary">
                            Cari Film Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection