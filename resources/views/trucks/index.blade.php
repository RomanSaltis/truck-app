<!-- resources/views/trucks/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Trucks</h1>
        <a href="{{ route('trucks.create') }}" class="btn btn-primary mb-3">Create Truck</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Unit Number</th>
                <th>Year</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trucks as $truck)
                <tr>
                    <td>{{ $truck->id }}</td>
                    <td>{{ $truck->unit_number }}</td>
                    <td>{{ $truck->year }}</td>
                    <td>{{ $truck->notes }}</td>
                    <td>
                        <a href="{{ route('trucks.show', $truck->id) }}" class="btn btn-primary">View</a>
                        <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
