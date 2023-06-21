<!-- resources/views/trucks/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Truck</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('trucks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="unit_number">Unit Number</label>
                <input type="text" class="form-control" id="unit_number" name="unit_number" required>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') + 5 }}" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
