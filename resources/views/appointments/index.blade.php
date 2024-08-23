@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Appointment Details</title>
        <!-- Load Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .card {
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #007bff;
                color: white;
                border-bottom: 1px solid #ddd;
            }

            .card-body {
                background-color: #f9f9f9;
            }

            .time-left {
                font-size: 1.25rem;
                font-weight: bold;
            }

            .urgent {
                color: #ff0000;
                /* Dark red */
            }

            .warning {
                color: #ffc107;
                /* Yellow */
            }

            .notification-sound {
                display: none;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>Appointment Details</h1>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Doctor:</strong> {{ $doctorName }}</p>
                    <p class="card-text"><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                    <p class="card-text"><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
                    <p class="card-text"><strong>Time Left:</strong>
                        <span id="time-left" class="time-left"></span>
                    </p>
                </div>
            </div>
            <audio id="notification-sound" class="notification-sound" src="{{ asset('audio/sound1.wav') }}"
                preload="auto"></audio>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const appointmentDate = new Date(
                    "{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}");
                const sound = document.getElementById('notification-sound');
                const timeLeftElement = document.getElementById('time-left');

                function calculateTimeLeft() {
                    const now = new Date();
                    const diff = appointmentDate - now;

                    if (diff <= 0) {
                        if (!window.notificationSent) {
                            sendNotification();
                            window.notificationSent = true;
                        }
                        timeLeftElement.textContent = "Time's up!";
                        timeLeftElement.classList.add('urgent');
                    } else {
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        timeLeftElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                        timeLeftElement.className = 'time-left';

                        if (diff <= (30 * 60 * 1000)) { // 30 minutes
                            timeLeftElement.classList.add('warning');
                        }
                    }
                }

                function sendNotification() {
                    if (sound) {
                        sound.play().catch(error => console.error('Error playing sound:', error));
                    }
                    alert('It\'s time for your appointment!');
                }

                setInterval(calculateTimeLeft, 1000);
            });
        </script>

        <!-- Load Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>

    </html>
@endsection
