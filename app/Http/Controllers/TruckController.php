<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class TruckController extends Controller
{
    /**
     * Display a listing of the trucks
     *
     * @return View
     */
    public function index(): View
    {
        $trucks = Truck::all();
        return view('trucks.index', ['trucks' => $trucks]);
    }

    /**
     * Show the form for creating a new truck
     *
     * @return View
     */
    public function create(): View
    {
        return view('trucks.create');
    }

    /**
     * Store a newly created truck in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'unit_number' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes' => 'nullable|string',
        ]);

        $truck = new Truck();
        $truck->unit_number = $validatedData['unit_number'];
        $truck->year = $validatedData['year'];
        $truck->notes = $validatedData['notes'];
        $truck->save();

        return redirect()->route('trucks.index')->with('success', 'Truck created successfully!');
    }

    /**
     * Store a newly created truck in storage
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $truck = Truck::findOrFail($id);
        return view('trucks.show', ['truck' => $truck]);
    }

    /**
     * Show the form for editing the specified truck
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $truck = Truck::findOrFail($id);
        return view('trucks.edit', ['truck' => $truck]);
    }

    /**
     * Update the specified truck in storage
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'unit_number' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes' => 'nullable|string',
        ]);

        $truck = Truck::findOrFail($id);
        $truck->unit_number = $validatedData['unit_number'];
        $truck->year = $validatedData['year'];
        $truck->notes = $validatedData['notes'];
        $truck->save();

        return redirect()->route('trucks.index')->with('success', 'Truck updated successfully!');
    }

    /**
     * Remove the specified truck from storage
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $truck = Truck::findOrFail($id);
        $subunitsCount = $truck->subunits()->count();
        if ($subunitsCount > 0) {
            return redirect()->route('trucks.index')->with('error', 'Cannot delete the truck because it has associated subunits!');
        }

        try {
            $truck->delete();
        } catch (QueryException $e) {
            return redirect()->route('trucks.index')->with('error', 'An error occurred while deleting the truck.');
        }

        return redirect()->route('trucks.index')->with('success', 'Truck deleted successfully!');
    }
}
