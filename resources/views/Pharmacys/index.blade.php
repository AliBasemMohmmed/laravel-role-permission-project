@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Pharmacy List</div>
    <div class="card-body">
        @can('create-pharmacy')
            <a href="{{ route('pharmacy.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Pharmacy</a>
        @endcan
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">اسم الصيدلية</th>
                <th scope="col">اسم الدكتور</th>
                <th scope="col">الشعار</th>
                <th scope="col">الموقع</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Pharmacy as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if ($product->user)
                            <a href="{{ route('users.show', $product->user->id) }}">{{ $product->user->name }}</a>
                        @else
                            No user assigned
                        @endif
                    </td>

                    <td>{{ $product->logo }}</td>
                    <td>{{ $product->location }}</td>

                    <td>
                        <form action="{{ route('pharmacy.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('pharmacy.show', $product->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                            @can('edit-product')
                                <a href="{{ route('pharmacy.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-product')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');"><i class="bi bi-trash"></i> Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="4">
                        <span class="text-danger">
                            <strong>No Product Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $Pharmacy->links() }}

    </div>
</div>
@endsection
