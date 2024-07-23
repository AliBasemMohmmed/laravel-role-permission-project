@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="float-start">معلومات الصيدلية</span>
                            <a href="{{ route('pharmacy.index') }}" class="btn btn-sm btn-light">&larr; العودة</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- عرض تفاصيل الصيدلية في بطاقات -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="fw-bold">الاسم:</label>
                                        <p>{{ $pharmacy->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="fw-bold">الموقع:</label>
                                        <p>{{ $pharmacy->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body text-center">
                                        <label class="fw-bold">الشعار:</label>
                                        <img src="{{ asset($pharmacy->logo) }}" alt="شعار الصيدلية" class="img-fluid rounded" style="max-width: 150px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="fw-bold">اسم الطبيب:</label>
                                        <p>{{ $pharmacy->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- عرض نسب الجنس في بطاقة -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="fw-bold">نسبة الذكور:</label>
                                        <p>{{ number_format(($maleCount / $totalPatients) * 100, 2) }}%</p>
                                        <label class="fw-bold">نسبة الإناث:</label>
                                        <p>{{ number_format(($femaleCount / $totalPatients) * 100, 2) }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- عرض رسم بياني لعدد الزيارات باستخدام Chart.js في بطاقة -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <canvas id="pharmacyVisitsChart" style="height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- استيراد مكتبة Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
