<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
    {
        $totalLeads = Lead::count();

        $cold = Lead::where('status', 'Cold')->count();
        $warm = Lead::where('status', 'Warm')->count();
        $hot = Lead::where('status', 'Hot')->count();
        $deal = Lead::where('status', 'Deal')->count();
        $lost = Lead::where('status', 'Lost')->count();

        $closingThisMonth = Lead::where('status', 'Deal')
            ->whereMonth('updated_at', now()->month)
            ->count();

        $pipelineValue = Quotation::whereIn('status', ['pending', 'nego'])
            ->sum('nilai_penawaran');

        $perSales = Lead::with('assignedUser')
        ->selectRaw('assigned_to, count(*) as total')
        ->groupBy('assigned_to')
        ->get();

        return response()->json([
            'total_leads' => $totalLeads,

            'status_summary' => [
                'cold' => $cold,
                'warm' => $warm,
                'hot' => $hot,
                'deal' => $deal,
                'lost' => $lost,
            ],

            'closing_this_month' => $closingThisMonth,
            'pipeline_value' => $pipelineValue,

            'per_sales' => $perSales,
        ]);
    }
}