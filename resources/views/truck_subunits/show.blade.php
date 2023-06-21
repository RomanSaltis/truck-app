@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Truck Subunit Details</h1>

        <table class="table">
            <tbody>
            <tr>
                <th>Main Truck</th>
                <td>{{ $truckSubunit->main_truck }}</td>
            </tr>
            <tr>
                <th>Subunit</th>
                <td>{{ $truckSubunit->subunit }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ $truckSubunit->start_date }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ $truckSubunit->end_date }}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('truck_subunits.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection
