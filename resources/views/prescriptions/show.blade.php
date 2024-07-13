@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Manage Patients</div>
        <div class="card-body">
            @can('create-dector')
                <a href="{{ route('dectors.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add
                    New User</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Doctor Name</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">National ID Image</th>
                        <th scope="col">Age</th>
                        <th scope="col">Prescription Number</th>
                        <th scope="col">Dispensation Date</th>
                        {{-- <th scope="col">Medication</th>
                        <th scope="col">Time</th>
                        <th scope="col">Eating</th>
                        <th scope="col">Dosage Frequency</th> --}}
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->prescription->doctor_name }}</td>
                            <td>{{ $user->prescription->patient_name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $user->prescription->national_id_image) }}"
                                    alt="National ID Image" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>{{ $user->prescription->patient_age }}</td>
                            <td>{{ $user->prescription->prescription_number }}</td>
                            <td>{{ $user->prescription->dispensation_date }}</td>
                            {{-- <td>
                                @foreach ($user as $medication)
                                    {{ $medication->name }} ({{ $medication->description }})<br>
                                @endforeach
                            </td> --}}
                            {{-- <td>
                                @foreach ($user->times as $time)
                                    {{ $time }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($user->eating as $eat)
                                    {{ $eat }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($user->dosage_frequencies as $frequency)
                                    {{ $frequency }}<br>
                                @endforeach
                            </td>
                            <td>
                                {{-- Add actions if needed --}}
                            </td> 
                            <td>
                                <form action="" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="" class="btn btn-warning btn-sm"><i
                                            class="bi bi-eye"></i> Show</a>


                                        <a href="" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i> Edit</a>



                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Do you want to delete this product?');"><i
                                                class="bi bi-trash"></i> Delete</button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <span class="text-danger"><strong>No User Found!</strong></span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
