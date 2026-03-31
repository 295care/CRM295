<?php

namespace App\Http\Controllers\Api;

use App\Models\Quotation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('lead')
            ->latest()
            ->get();

        return response()->json($quotations);
    }

    public function store(StoreQuotationRequest $request)
    {
        $quotation = Quotation::create($request->validated());

        $lead = $quotation->lead;
        if ($quotation->status === 'accepted') {
            $lead->update(['status' => 'Deal']);
        }

        return response()->json([
            'message' => 'Penawaran berhasil dibuat',
            'data' => $quotation->load('lead'),
        ], 201);
    }

    public function show(Quotation $quotation)
    {
        return response()->json(
            $quotation->load('lead')
        );
    }

    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $quotation->update($request->validated());
        $lead = $quotation->lead;

        if ($quotation->status === 'accepted') {
            $lead->update(['status' => 'Deal']);
        }

        return response()->json([
            'message' => 'Penawaran berhasil diupdate',
            'data' => $quotation->load('lead'),
        ]);
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return response()->json([
            'message' => 'Penawaran berhasil dihapus',
        ]);
    }
}