<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    public function index()
    {
        $waitingList = WaitingList::with(['user', 'service'])->get();
        return response()->json($waitingList);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'requested_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $waitingListItem = WaitingList::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'requested_date' => $request->requested_date,
            'notes' => $request->notes,
        ]);

        return response()->json($waitingListItem, 201);
    }

    public function show(WaitingList $waitingListItem)
    {
        return response()->json($waitingListItem->load(['user', 'service']));
    }

    public function update(Request $request, WaitingList $waitingListItem)
    {
        $this->authorize('update', $waitingListItem);

        $request->validate([
            'status' => 'in:pending,notified,booked,cancelled',
            'notes' => 'nullable|string',
        ]);

        $waitingListItem->update($request->only(['status', 'notes']));

        return response()->json($waitingListItem);
    }

    public function destroy(WaitingList $waitingListItem)
    {
        $this->authorize('delete', $waitingListItem);

        $waitingListItem->delete();

        return response()->json(null, 204);
    }
}