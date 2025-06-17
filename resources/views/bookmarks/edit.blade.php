@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Edit Bookmark</h4>
                            <a href="{{ route('bookmarks.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Back to Bookmarks
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Movie Info -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="text-primary">{{ $bookmark->movie->title }}</h5>
                                    <p class="mb-1"><strong>Genre:</strong> {{ $bookmark->movie->genre }}</p>
                                    <p class="mb-1"><strong>Tahun:</strong> {{ $bookmark->movie->year }}</p>
                                    <p class="mb-0 text-muted">{{ $bookmark->movie->plot }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <form action="{{ route('bookmarks.update', $bookmark->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan Pribadi</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Tulis catatan atau review pribadi tentang film ini...">{{ old('notes', $bookmark->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 1000 karakter</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('bookmarks.index') }}" class="btn btn-secondary me-md-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Update Bookmark
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection