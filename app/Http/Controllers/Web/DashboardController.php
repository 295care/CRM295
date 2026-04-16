<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalClients = Client::query()->count();
        $sourceCounts = Client::query()
            ->selectRaw('sumber_client, count(*) as total')
            ->groupBy('sumber_client')
            ->orderByDesc('total')
            ->get();

        $latestClients = Client::query()
            ->latest('id')
            ->limit(8)
            ->get();
            
        $jenisProjekCounts = \App\Models\Quotation::query()
            ->selectRaw('nama_projek, count(*) as total')
            ->whereNotNull('nama_projek')
            ->where('nama_projek', '!=', '')
            ->groupBy('nama_projek')
            ->orderByDesc('total')
            ->get();
            
        $quotationOverviewQuery = \App\Models\Quotation::query();
        
        $overview = [
            'total_penawaran' => (clone $quotationOverviewQuery)->count(),
            'deal_total' => (clone $quotationOverviewQuery)->where('status', 'accepted')->count(),
            'batal_total' => (clone $quotationOverviewQuery)->where('status', 'rejected')->count(),
            'calon_deal_value' => (clone $quotationOverviewQuery)->whereIn('status', ['pending', 'nego'])->sum('nilai_penawaran'),
            'deal_value' => (clone $quotationOverviewQuery)->where('status', 'accepted')->sum('nilai_penawaran'),
            'hpp_value' => (clone $quotationOverviewQuery)->where('status', 'accepted')->sum('hpp'),
        ];

        return view('dashboard', [
            'totalClients' => $totalClients,
            'sourceCounts' => $sourceCounts,
            'latestClients' => $latestClients,
            'jenisProjekCounts' => $jenisProjekCounts,
            'overview' => $overview,
        ]);
    }
}