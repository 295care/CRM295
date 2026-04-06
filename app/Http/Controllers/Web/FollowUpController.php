<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowUpController extends Controller
{
    public function index(Request $request): View
    {
        $mode = $request->query('mode', 'due');

        $query = Activity::query()
            ->with('lead:id,nama_client,perusahaan,status,assigned_to')
            ->whereNotNull('next_follow_up');

        if ($mode === 'overdue') {
            $query->where('next_follow_up', '<', now());
        } elseif ($mode === 'today') {
            $query->whereDate('next_follow_up', now()->toDateString());
        } else {
            $query->where('next_follow_up', '<=', now()->endOfDay());
        }

        $tasks = $query->orderBy('next_follow_up')->paginate(20)->withQueryString();

        $counts = [
            'due' => Activity::whereNotNull('next_follow_up')->where('next_follow_up', '<=', now()->endOfDay())->count(),
            'overdue' => Activity::whereNotNull('next_follow_up')->where('next_follow_up', '<', now())->count(),
            'today' => Activity::whereDate('next_follow_up', now()->toDateString())->count(),
        ];

        return view('followups.index', [
            'tasks' => $tasks,
            'mode' => $mode,
            'counts' => $counts,
        ]);
    }
}
