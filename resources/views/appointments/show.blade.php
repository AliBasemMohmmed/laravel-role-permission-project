@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Weekly Appointments</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Appointments for the Week</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Appointments</th>
                </tr>
            </thead>
            <tbody>
                @foreach (range(0, 6) as $day)
                    @php
                        $date = Carbon\Carbon::parse($currentWeek['start'])->addDays($day);
                        $dateFormatted = $date->format('Y-m-d');
                        $isVacation = in_array($dateFormatted, $vacationDates);
                    @endphp
                    <tr>
                        <td>
                            {{ $date->format('l, F j, Y') }}
                            @if ($isVacation)
                                <span class="badge badge-danger">Vacation</span>
                            @endif
                        </td>
                        <td>
                            @if ($isVacation)
                                <span class="text-muted">No appointments</span>
                            @else
                                @foreach ($appointments[$dateFormatted] ?? [] as $appointment)
                                    <div>
                                        {{ $appointment->appointment_time }} - Patient:
                                        {{ $appointment->patient->name }}
                                    </div>
                                @endforeach
                                @if (!isset($appointments[$dateFormatted]))
                                    <span class="text-muted">No appointments</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
@endsection
