@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Pharmacy Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pharmacy.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Display pharmacy details -->
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6">
                            {{ $Pharmacy->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="location" class="col-md-4 col-form-label text-md-end text-start"><strong>Location:</strong></label>
                        <div class="col-md-6">
                            {{ $Pharmacy->location }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="logo" class="col-md-4 col-form-label text-md-end text-start"><strong>Logo:</strong></label>
                        <div class="col-md-6">
                            <!-- Assuming logo is stored as an image path -->
                            <img src="{{ asset($Pharmacy->logo) }}" alt="Pharmacy Logo" style="max-width: 150px;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role_id" class="col-md-4 col-form-label text-md-end text-start"><strong>Doctor Name:</strong></label>
                        <div class="col-md-6">
                            {{ $Pharmacy->user->name }}
                        </div>
                    </div>

                    <!-- Display gender ratios -->
                    <div class="mb-3">
                        <p>نسبة الذكور: {{ ($maleCount / $totalPatients) * 100 }}%</p>
                        <p>نسبة الإناث: {{ ($femaleCount / $totalPatients) * 100 }}%</p>
                    </div>

                    <!-- Chart.js for displaying pharmacy visits -->
                    <canvas id="pharmacyVisitsChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('pharmacyVisitsChart').getContext('2d');
        var pharmacyNames = @json($pharmacyVisits->pluck('name'));
        var visitsCount = @json($pharmacyVisits->pluck('visits_count'));

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pharmacyNames,
                datasets: [{
                    label: 'عدد الزيارات',
                    data: visitsCount,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
