<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\TruckSubunit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TruckSubunitController extends Controller
{
    /**
     * Display a listing of the truck subunits
     *
     * @return View
     */

    public function index(): View
    {
        $truckSubunits = TruckSubunit::all();

        return view('truck_subunits.index', compact('truckSubunits'));
    }

    /**
     * Show the form for creating a new truck subunit
     *
     * @return View
     */
    public function create(): View
    {
        $trucks = Truck::pluck('unit_number', 'id');

        return view('truck_subunits.create', compact('trucks'));
    }

    /**
     * Store a newly created truck subunit in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateTruckSubunit($request);

        $mainTruckId = $request->input('main_truck');
        $subunitId = $request->input('subunit');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($this->checkExistingMainTruckSubunit($mainTruckId, $startDate, $endDate)) {
            return redirect()
                ->back()
                ->withErrors(['main_truck' => 'The main truck is already a subunit of another truck.'])
                ->withInput();
        }

        if ($this->checkExistingSubunit($subunitId, $startDate, $endDate)) {
            return redirect()
                ->back()
                ->withErrors(['subunit' => 'The subunit is already assigned as a subunit for another truck during the same time period.'])
                ->withInput();
        }

        if ($this->checkExistingSubunitMainTruck($subunitId, $startDate, $endDate)) {
            return redirect()
                ->back()
                ->withErrors(['subunit' => 'The subunit is already assigned as a main truck for another subunit during the same time period.'])
                ->withInput();
        }

        $overlappingSubunits = $this->checkOverlappingSubunits($mainTruckId, $startDate, $endDate, $request->input('id'));

        if ($overlappingSubunits) {
            return redirect()
                ->back()
                ->withErrors(['start_date' => 'The subunit dates overlap with existing subunits.'])
                ->withInput();
        }

        TruckSubunit::create($validatedData);

        return redirect()->route('truck_subunits.index')
            ->with('success', 'Truck subunit created successfully.');
    }

    /**
     * Display the specified truck subunit
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $truckSubunit = TruckSubunit::findOrFail($id);

        return view('truck_subunits.show', compact('truckSubunit'));
    }

    /**
     * Show the form for editing the specified truck subunit
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $trucks = Truck::pluck('unit_number', 'id');
        $truckSubunit = TruckSubunit::findOrFail($id);

        return view('truck_subunits.edit', compact('trucks', 'truckSubunit'));
    }

    /**
     * Update the specified truck subunit in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validatedData = $this->validateTruckSubunit($request);

        $mainTruckId = $request->input('main_truck');
        $subunitId = $request->input('subunit');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($this->checkExistingMainTruckSubunit($mainTruckId, $startDate, $endDate, $id)) {
            return redirect()
                ->back()
                ->withErrors(['main_truck' => 'The main truck is already a subunit of another truck.'])
                ->withInput();
        }

        if ($this->checkExistingSubunit($subunitId, $startDate, $endDate, $id)) {
            return redirect()
                ->back()
                ->withErrors(['subunit' => 'The subunit is already assigned as a subunit for another truck during the same time period.'])
                ->withInput();
        }

        if ($this->checkExistingSubunitMainTruck($subunitId, $startDate, $endDate, $id)) {
            return redirect()
                ->back()
                ->withErrors(['subunit' => 'The subunit is already assigned as a main truck for another subunit during the same time period.'])
                ->withInput();
        }

        $overlappingSubunits = $this->checkOverlappingSubunits($mainTruckId, $startDate, $endDate, $id);

        if ($overlappingSubunits) {
            return redirect()
                ->back()
                ->withErrors(['start_date' => 'The subunit dates overlap with existing subunits.'])
                ->withInput();
        }

        $truckSubunit = TruckSubunit::findOrFail($id);
        $truckSubunit->update($validatedData);

        return redirect()
            ->route('truck_subunits.index')
            ->with('success', 'Truck subunit updated successfully.');
    }

    /**
     * Validate the truck subunit data.
     *
     * @param Request $request
     * @return array
     *
     * @throws ValidationException
     */
    private function validateTruckSubunit(Request $request): array
    {
        return $request->validate([
            'main_truck' => 'required|different:subunit',
            'subunit' => 'required|different:main_truck',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'main_truck.different' => 'Main Truck and Subunit must be different.',
            'subunit.different' => 'Subunit and Main Truck must be different.',
            'end_date.after_or_equal' => 'End Date must be equal to or after the Start Date.',
        ]);
    }

    /**
     * Check if an existing main truck subunit exists.
     *
     * @param int $mainTruckId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId
     * @return bool
     */
    private function checkExistingMainTruckSubunit(int $mainTruckId, string $startDate, string $endDate, ?int $excludeId = null): bool
    {
        return TruckSubunit::where('subunit', $mainTruckId)
            ->where(function ($query) use ($startDate, $endDate, $excludeId) {
                $query->where(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $startDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                })->orWhere(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '>=', $startDate)
                        ->where('start_date', '<=', $endDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                });
            })
            ->exists();
    }

    /**
     * Check if an existing subunit exists.
     *
     * @param int $subunitId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId
     * @return bool
     */
    private function checkExistingSubunit(int $subunitId, string $startDate, string $endDate, ?int $excludeId = null): bool
    {
        return TruckSubunit::where('subunit', $subunitId)
            ->where(function ($query) use ($startDate, $endDate, $excludeId) {
                $query->where(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $startDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                })->orWhere(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '>=', $startDate)
                        ->where('start_date', '<=', $endDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                });
            })
            ->exists();
    }

    /**
     * Check if an existing subunit main truck exists.
     *
     * @param int $subunitId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId
     * @return bool
     */
    private function checkExistingSubunitMainTruck(int $subunitId, string $startDate, string $endDate, ?int $excludeId = null): bool
    {
        return TruckSubunit::where('main_truck', $subunitId)
            ->where(function ($query) use ($startDate, $endDate, $excludeId) {
                $query->where(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $startDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                })->orWhere(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '>=', $startDate)
                        ->where('start_date', '<=', $endDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                });
            })
            ->exists();
    }

    /**
     * Check if there are overlapping subunits.
     *
     * @param int $mainTruckId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeId
     * @return bool
     */
    private function checkOverlappingSubunits(int $mainTruckId, string $startDate, string $endDate, ?int $excludeId = null): bool
    {
        return TruckSubunit::where('main_truck', $mainTruckId)
            ->where(function ($query) use ($startDate, $endDate, $excludeId) {
                $query->where(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $startDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                })->orWhere(function ($q) use ($startDate, $endDate, $excludeId) {
                    $q->where('start_date', '>=', $startDate)
                        ->where('start_date', '<=', $endDate)
                        ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId));
                });
            })
            ->exists();
    }

    /**
     * Remove the specified truck subunit from storage
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $truckSubunit = TruckSubunit::findOrFail($id);

        $truckSubunit->delete();

        return redirect()->route('truck_subunits.index')->with('success', 'Truck subunit deleted successfully.');
    }
}
