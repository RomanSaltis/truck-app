@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Truck Subunit</h1>

        @include('partials.validation_errors')

        <form action="{{ route('truck_subunits.update', $truckSubunit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="main_truck" class="form-label">Main Truck</label>
                <select class="form-control" id="main_truck" name="main_truck" required>
                    @foreach ($trucks as $truckId => $truckUnitNumber)
                        <option value="{{ $truckId }}" {{ $truckId == $truckSubunit->main_truck ? 'selected' : '' }}>{{ $truckUnitNumber }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="subunit" class="form-label">Subunit</label>
                <select class="form-control" id="subunit" name="subunit" required>
                    @foreach ($trucks as $truckId => $truckUnitNumber)
                        @if ($truckId != $truckSubunit->main_truck)
                            <option value="{{ $truckId }}" {{ $truckId == $truckSubunit->subunit ? 'selected' : '' }}>{{ $truckUnitNumber }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $truckSubunit->start_date }}" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $truckSubunit->end_date }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
