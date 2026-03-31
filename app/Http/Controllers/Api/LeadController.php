<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with('assignedUser')
            ->latest()
            ->get();

        return response()->json($leads);
    }

    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->validated());

        $lead->statusHistories()->create([
            'from_status' => null,
            'to_status' => $lead->status,
            'changed_by' => $lead->assigned_to,
            'changed_at' => now(),
            'note' => 'Status awal lead dibuat',
        ]);

        return response()->json([
            'message' => 'Lead berhasil dibuat',
            'data' => $lead->load('assignedUser', 'statusHistories'),
        ], 201);
    }

    public function show(Lead $lead)
    {
        $lead->load([
            'assignedUser',
            'activities',
            'quotations',
            'statusHistories',
        ]);

        return response()->json($lead);
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $oldStatus = $lead->status;

        $lead->update($request->validated());

        if ($oldStatus !== $lead->status) {
            $lead->statusHistories()->create([
                'from_status' => $oldStatus,
                'to_status' => $lead->status,
                'changed_by' => $lead->assigned_to,
                'changed_at' => now(),
                'note' => 'Status lead diubah',
            ]);
        }

        return response()->json([
            'message' => 'Lead berhasil diupdate',
            'data' => $lead->load('assignedUser', 'statusHistories'),
        ]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json([
            'message' => 'Lead berhasil dihapus',
        ]);
    }
}