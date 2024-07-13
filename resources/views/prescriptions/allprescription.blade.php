@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">prescription List</div>
    <div class="card-body">
        @can('create-prescription')
            <a href="{{ route('prescriptions.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New prescription</a>
        @endcan
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prescriptions as $prescription)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $prescription->name }}</td>
                    <td>{{ $prescription->description }}</td>
                    <td>
                        <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                            @can('edit-prescription')
                                <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-prescription')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this prescription?');"><i class="bi bi-trash"></i> Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="4">
                        <span class="text-danger">
                            <strong>No prescription Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $prescriptions->links() }}

    </div>
</div>
@endsection
