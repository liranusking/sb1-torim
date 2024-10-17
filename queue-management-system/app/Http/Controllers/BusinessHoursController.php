<?php

namespace App\Http\Controllers;

use App\Models\BusinessHours;
use Illuminate\Http\Request;

class BusinessHoursController extends Controller
{
    public function index(Request $request)
    {
        $businessHours = BusinessHours::where('user_id', $request->user()->id)->get();
        return response()->json($businessHours);
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $businessHours = BusinessHours::create([
            'user_id' => $request->user()->id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json($businessHours, 201);
    }

    public function update(Request $request, BusinessHours $businessHours)
    {
        $this->authorize('update', $businessHours);

        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $businessHours->update($request->only(['start_time', 'end_time']));

        return response()->json($businessHours);
    }

    public function destroy(BusinessHours $businessHours)
    {
        $this->authorize('delete', $businessHours);

        $businessHours->delete();

        return response()->json(null, 204);
    }
}