@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Truck Subunits</h1>

        <a href="{{ route('truck_subunits.create') }}" class="btn btn-primary mb-3">Create Truck Subunit</a>

        @if ($truckSubunits->isEmpty())
            <p>No truck subunits found.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Main Truck</th>
                    <th>Subunit</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($truckSubunits as $truckSubunit)
                    <tr>
                        <td>{{ $truckSubunit->main_truck }}</td>
                        <td>{{ $truckSubunit->subunit }}</td>
                        <td>{{ $truckSubunit->start_date }}</td>
                        <td>{{ $truckSubunit->end_date }}</td>
                        <td>
                            <a href="{{ route('truck_subunits.show', $truckSubunit->id) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('truck_subunits.edit', $truckSubunit->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('truck_subunits.destroy', $truckSubunit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this truck subunit?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
