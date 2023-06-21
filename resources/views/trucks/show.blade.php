<!-- resources/views/trucks/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Truck Details</h1>

        <table class="table">
            <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $truck->id }}</td>
            </tr>
            <tr>
                <th>Unit Number</th>
                <td>{{ $truck->unit_number }}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{ $truck->year }}</td>
            </tr>
            <tr>
                <th>Notes</th>
                <td>{{ $truck->notes }}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('trucks.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
