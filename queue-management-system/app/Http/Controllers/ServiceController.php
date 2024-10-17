<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'duration' => 'integer|min:1',
            'price' => 'numeric|min:0',
        ]);

        $service->update($request->all());

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();

        return response()->json(null, 204);
    }
}