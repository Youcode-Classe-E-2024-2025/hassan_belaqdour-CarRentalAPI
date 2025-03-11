<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::paginate(10);
        return response()->json($rentals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'status' => 'in:pending,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rental = Rental::create($request->all());
        return response()->json($rental, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        return response()->json($rental);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'car_id' => 'exists:cars,id',
            'rental_date' => 'date',
            'return_date' => 'date|after:rental_date',
            'status' => 'in:pending,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rental->update($request->all());
        return response()->json($rental, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();
        return response()->json(null, 204);
    }
}