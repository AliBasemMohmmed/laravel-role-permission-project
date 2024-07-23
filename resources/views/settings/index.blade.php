@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-primary border-light rounded-3">
                    <div class="card-header bg-gradient-primary text-white border-0 rounded-top">
                        <h5 class="mb-0">User Settings</h5>
                    </div>
                    <div class="card-body">
                        @if ($setting)
                            <div class="mb-4 p-3 bg-light rounded-3 border border-light">
                                <h5 class="text-primary"><strong>Work Hours:</strong></h5>
                                <p class="fs-4">{{ $setting->start_time }} - {{ $setting->end_time }}</p>
                            </div>

                            <div class="mb-4 p-3 bg-light rounded-3 border border-light">
                                <h5 class="text-primary"><strong>Work Days:</strong></h5>
                                <p class="fs-4">
                                    @if (is_array($setting->working_days) && !empty($setting->working_days))
                                        {{ implode(', ', $setting->working_days) }}
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-4 p-3 bg-light rounded-3 border border-light">
                                <h5 class="text-primary"><strong>Vacation Days:</strong></h5>
                                <p class="fs-4">
                                    @if (is_array($setting->vacation_days) && !empty($setting->vacation_days))
                                        {{ implode(', ', $setting->vacation_days) }}
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-4 p-3 bg-light rounded-3 border border-light">
                                <h5 class="text-primary"><strong>Patient Limit:</strong></h5>
                                <p class="fs-4">{{ $setting->daily_patient_limit ?? 'Not set' }}</p>
                            </div>

                            <a href="{{ route('settings.edit', $setting->id) }}"
                                class="btn btn-warning shadow-sm rounded-pill">Edit Settings</a>
                        @else
                            <p class="text-center">
                                No settings found.
                                <a href="{{ route('settings.create') }}"
                                    class="btn btn-primary shadow-sm rounded-pill">Create settings</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(to right, #007bff, #0056b3);
        }

        .shadow-lg {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .rounded-3 {
            border-radius: 1rem;
        }

        .rounded-top {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .border-light {
            border-color: #e3e6f0 !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .fs-4 {
            font-size: 1.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004080;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, 0.075) !important;
        }

        .rounded-pill {
            border-radius: 50rem;
        }
    </style>
@endpush
