@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Truck Subunit</h1>

        <form action="{{ route('truck_subunits.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="main_truck" class="form-label">Main Truck</label>
                <select name="main_truck" id="main_truck" class="form-control" required>
                    <option value="">Select Main Truck</option>
                    @foreach ($trucks as $id => $unit_number)
                        <option value="{{ $id }}">{{ $unit_number }}</option>
                    @endforeach
                </select>
                @error('main_truck')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subunit" class="form-label">Subunit</label>
                <select name="subunit" id="subunit" class="form-control" required>
                    <option value="">Select Subunit</option>
                    @foreach ($trucks as $id => $unit_number)
                        <option value="{{ $id }}">{{ $unit_number }}</option>
                    @endforeach
                </select>
                @error('subunit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
                @error('start_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
                @error('end_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
