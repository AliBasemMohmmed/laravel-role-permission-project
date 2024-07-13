@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        إضافة صيدلية جديدة
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pharmacy.index') }}" class="btn btn-primary btn-sm">&larr; رجوع</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('pharmacy.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">الاسم</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="location" class="col-md-4 col-form-label text-md-end text-start">الموقع</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    id="location" name="location" value="{{ old('location') }}">
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="logo" class="col-md-4 col-form-label text-md-end text-start">
                                 Image</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                    id="logo" name="logo" required>
                                @error('logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-end text-start">اسم الدكتور</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('role_id') is-invalid @enderror"
                                    id="role_id" name="user_id" value="{{ old('user_id') }}">
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="mb-3 row">
                        <label for="latitude" class="col-md-4 col-form-label text-md-end text-start">خط العرض</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly>
                            @error('latitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="longitude" class="col-md-4 col-form-label text-md-end text-start">خط الطول</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly>
                            @error('longitude')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                        <div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="إضافة صيدلية">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;

        function initMap() {
            const initialPosition = {
                lat: -34.397,
                lng: 150.644
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: initialPosition,
                zoom: 8,
            });

            marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                draggable: true,
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            if (typeof google !== 'undefined') {
                initMap();
            } else {
                console.error('Google Maps JavaScript API failed to load.');
            }
        });
    </script>
@endsection
