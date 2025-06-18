@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Statistik Film</h2>
    <div class="row">
        <div class="col-md-6">
            <h5>Distribusi Genre</h5>
            <canvas id="genreChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5>Distribusi Rating</h5>
            <canvas id="ratingChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari controller
    const genreLabels = {!! json_encode(array_keys($genreCounts->toArray())) !!};
    const genreData = {!! json_encode(array_values($genreCounts->toArray())) !!};

    const ratingLabels = {!! json_encode(array_keys($ratingCounts->toArray())) !!};
    const ratingData = {!! json_encode(array_values($ratingCounts->toArray())) !!};

    // Genre Chart
    new Chart(document.getElementById('genreChart'), {
        type: 'pie',
        data: {
            labels: genreLabels,
            datasets: [{
                data: genreData,
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#fd7e14'
                ],
            }]
        }
    });

    // Rating Chart
    new Chart(document.getElementById('ratingChart'), {
        type: 'bar',
        data: {
            labels: ratingLabels,
            datasets: [{
                label: 'Jumlah Film',
                data: ratingData,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection