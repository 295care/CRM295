<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Activity::query()->with('lead:id,nama_client,perusahaan,status,assigned_to');

        $jenis = $request->query('jenis');
        $timeline = $request->query('timeline');
        $search = trim((string) $request->query('q', ''));

        if ($search !== '') {
            $query->whereHas('lead', function ($leadQuery) use ($search): void {
                $leadQuery->where('nama_client', 'like', "%{$search}%")
                    ->orWhere('perusahaan', 'like', "%{$search}%");
            });
        }

        if ($jenis !== null && $jenis !== '') {
            $query->where('jenis', $jenis);
        }

        if ($timeline === 'overdue') {
            $query->whereNotNull('next_follow_up')->where('next_follow_up', '<', now());
        } elseif ($timeline === 'today') {
            $query->whereDate('next_follow_up', now()->toDateString());
        } elseif ($timeline === 'upcoming') {
            $query->where('next_follow_up', '>', now());
        }

        $activities = $query->latest('tanggal')->paginate(15)->withQueryString();

        $jenisOptions = Activity::query()
            ->select('jenis')
            ->distinct()
            ->orderBy('jenis')
            ->pluck('jenis');

        $kpi = [
            'total' => Activity::count(),
            'overdue' => Activity::whereNotNull('next_follow_up')->where('next_follow_up', '<', now())->count(),
            'today' => Activity::whereDate('tanggal', now()->toDateString())->count(),
        ];

        return view('activities.index', [
            'activities' => $activities,
            'jenisOptions' => $jenisOptions,
            'filters' => [
                'q' => $search,
                'jenis' => $jenis,
                'timeline' => $timeline,
            ],
            'kpi' => $kpi,
        ]);
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', [
            'activity' => $activity->load('lead:id,nama_client,perusahaan'),
        ]);
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', 'string', 'max:100'],
            'catatan' => ['required', 'string'],
            'next_follow_up' => ['nullable', 'date'],
        ]);

        $activity->update($validated);

        return redirect()
            ->route('leads.show', $activity->lead_id)
            ->with('success', 'Activity berhasil diupdate.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $leadId = $activity->lead_id;
        $activity->delete();

        return redirect()
            ->route('leads.show', $leadId)
            ->with('success', 'Activity berhasil dihapus.');
    }
}
