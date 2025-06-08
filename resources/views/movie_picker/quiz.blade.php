@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <h2 class="mb-4">Movie Picker Quiz</h2>
    <form action="{{ route('movie-picker.quiz') }}" method="POST">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">
        @if ($step == 1)
            <div class="mb-3">
                <label class="form-label">Bagaimana perasaan Anda hari ini?</label>
                <select name="mood" class="form-select" required>
                    <option value="Happy" {{ (isset($answers['mood']) && $answers['mood']=='Happy') ? 'selected' : '' }}>Happy</option>
                    <option value="Neutral" {{ (isset($answers['mood']) && $answers['mood']=='Neutral') ? 'selected' : '' }}>Neutral</option>
                    <option value="Sad" {{ (isset($answers['mood']) && $answers['mood']=='Sad') ? 'selected' : '' }}>Sad</option>
                </select>
            </div>
        @elseif ($step == 2)
            <div class="mb-3">
                <label class="form-label">Apa acara atau situasi Anda saat ini?</label>
                <select name="situation" class="form-select" required>
                    <option {{ (isset($answers['situation']) && $answers['situation']=='Menonton sendiri') ? 'selected' : '' }}>Menonton sendiri</option>
                    <option {{ (isset($answers['situation']) && $answers['situation']=='Kencan') ? 'selected' : '' }}>Kencan</option>
                    <option {{ (isset($answers['situation']) && $answers['situation']=='Malam film bersama teman') ? 'selected' : '' }}>Malam film bersama teman</option>
                    <option {{ (isset($answers['situation']) && $answers['situation']=='Malam kencan dengan pasangan') ? 'selected' : '' }}>Malam kencan dengan pasangan</option>
                    <option {{ (isset($answers['situation']) && $answers['situation']=='Menonton bersama keluarga') ? 'selected' : '' }}>Menonton bersama keluarga</option>
                </select>
            </div>
        @elseif ($step == 3)
            <div class="mb-3">
                <label class="form-label">Genre film yang diminati?</label>
                <select name="genre" class="form-select" required>
                    <option value="Semua Genre" {{ (isset($answers['genre']) && $answers['genre']=='Semua Genre') ? 'selected' : '' }}>Semua Genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre }}" {{ (isset($answers['genre']) && $answers['genre']==$genre) ? 'selected' : '' }}>{{ $genre }}</option>
                    @endforeach
                </select>
            </div>
        @elseif ($step == 4)
            <div class="mb-3">
                <label class="form-label">Seberapa baru film yang Anda inginkan?</label>
                <select name="release_year" class="form-select" required>
                    <option {{ (isset($answers['release_year']) && $answers['release_year']=='Tidak masalah') ? 'selected' : '' }}>Tidak masalah</option>
                    <option {{ (isset($answers['release_year']) && $answers['release_year']=='5 tahun terakhir') ? 'selected' : '' }}>5 tahun terakhir</option>
                    <option {{ (isset($answers['release_year']) && $answers['release_year']=='10 tahun terakhir') ? 'selected' : '' }}>10 tahun terakhir</option>
                    <option {{ (isset($answers['release_year']) && $answers['release_year']=='25 tahun terakhir') ? 'selected' : '' }}>25 tahun terakhir</option>
                </select>
            </div>
        @elseif ($step == 5)
            <div class="mb-3">
                <label class="form-label">Apakah rating usia film penting bagi Anda?</label>
                <select name="rating" class="form-select" required>
                    <option value="Tidak" {{ (isset($answers['rating']) && $answers['rating']=='Tidak') ? 'selected' : '' }}>Tidak</option>
                    @foreach ($ratings as $rating)
                        <option value="{{ $rating }}" {{ (isset($answers['rating']) && $answers['rating']==$rating) ? 'selected' : '' }}>{{ $rating }}</option>
                    @endforeach
                </select>
            </div>
        @elseif ($step == 6)
            <div class="mb-3">
                <label class="form-label">Kategori khusus yang diminati?</label>
                <select name="special_category" class="form-select" required>
                    <option value="Bebas" {{ (isset($answers['special_category']) && $answers['special_category']=='Bebas') ? 'selected' : '' }}>Bebas</option>
                    @foreach ($specials as $special)
                        <option value="{{ $special }}" {{ (isset($answers['special_category']) && $answers['special_category']==$special) ? 'selected' : '' }}>{{ $special }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="d-flex justify-content-between">
            @if ($step > 1)
                <a href="{{ route('movie-picker.quiz.form', ['step' => $step - 1]) }}" class="btn btn-secondary">Previous</a>
            @else
                <span></span>
            @endif
            <button type="submit" class="btn btn-primary">
                {{ $step == 6 ? 'Check Results' : 'Next' }}
            </button>
        </div>
    </form>
</div>
@endsection