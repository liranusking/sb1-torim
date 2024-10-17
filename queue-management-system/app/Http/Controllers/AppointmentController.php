<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'service'])->get();
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $end_time = (new \DateTime($request->start_time))->modify("+{$service->duration} minutes");

        DB::beginTransaction();
        try {
            $appointment = Appointment::create([
                'user_id' => $request->user()->id,
                'service_id' => $request->service_id,
                'start_time' => $request->start_time,
                'end_time' => $end_time,
                'notes' => $request->notes,
            ]);

            DB::commit();
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create appointment'], 500);
        }
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load(['user', 'service']));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $request->validate([
            'service_id' => 'exists:services,id',
            'start_time' => 'date',
            'status' => 'in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            if ($request->has('service_id') || $request->has('start_time')) {
                $service = Service::findOrFail($request->service_id ?? $appointment->service_id);
                $start_time = $request->start_time ?? $appointment->start_time;
                $end_time = (new \DateTime($start_time))->modify("+{$service->duration} minutes");

                $appointment->update([
                    'service_id' => $request->service_id ?? $appointment->service_id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                ]);
            }

            $appointment->update($request->only(['status', 'notes']));

            DB::commit();
            return response()->json($appointment);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update appointment'], 500);
        }
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return response()->json(null, 204);
    }
}