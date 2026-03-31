<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('lead')
            ->latest()
            ->get();

        return response()->json($activities);
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->validated());

        return response()->json([
            'message' => 'Activity berhasil dibuat',
            'data' => $activity->load('lead'),
        ], 201);
    }

    public function show(Activity $activity)
    {
        return response()->json(
            $activity->load('lead')
        );
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());

        return response()->json([
            'message' => 'Activity berhasil diupdate',
            'data' => $activity->load('lead'),
        ]);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json([
            'message' => 'Activity berhasil dihapus',
        ]);
    }
}