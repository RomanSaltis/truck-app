<?php

use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckSubunitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/trucks', [TruckController::class, 'index'])->name('trucks.index');
Route::get('/trucks/create', [TruckController::class, 'create'])->name('trucks.create');
Route::post('/trucks', [TruckController::class, 'store'])->name('trucks.store');
Route::get('/trucks/{id}', [TruckController::class, 'show'])->name('trucks.show');
Route::get('/trucks/{id}/edit', [TruckController::class, 'edit'])->name('trucks.edit');
Route::put('/trucks/{id}', [TruckController::class, 'update'])->name('trucks.update');
Route::delete('/trucks/{id}', [TruckController::class, 'destroy'])->name('trucks.destroy');

Route::get('/truck-subunits', [TruckSubunitController::class, 'index'])->name('truck_subunits.index');
Route::get('/truck-subunits/create', [TruckSubunitController::class, 'create'])->name('truck_subunits.create');
Route::post('/truck-subunits', [TruckSubunitController::class, 'store'])->name('truck_subunits.store');
Route::get('/truck-subunits/{id}', [TruckSubunitController::class, 'show'])->name('truck_subunits.show');
Route::get('/truck-subunits/{id}/edit', [TruckSubunitController::class, 'edit'])->name('truck_subunits.edit');
Route::put('/truck-subunits/{id}', [TruckSubunitController::class, 'update'])->name('truck_subunits.update');
Route::delete('/truck-subunits/{id}', [TruckSubunitController::class, 'destroy'])->name('truck_subunits.destroy');
