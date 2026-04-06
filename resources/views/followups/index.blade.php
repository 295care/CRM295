<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Follow Up Tasks - CRM295</title>
    <style>
        body { font-family: Manrope, sans-serif; margin: 0; background: #f3f1eb; color: #1f201d; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 40px; }
        .top { display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        h1 { margin: 0; font-size: 30px; }
        .btn { border: 1px solid #d9ddce; border-radius: 10px; padding: 8px 12px; text-decoration: none; color: #1f201d; background: #fff; font-weight: 700; }
        .panel { background: #fffdf8; border: 1px solid #d9ddce; border-radius: 14px; padding: 14px; margin-bottom: 12px; }
        .tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 10px; }
        .tab { padding: 8px 12px; border: 1px solid #d9ddce; border-radius: 999px; text-decoration: none; color: #1f201d; background: #fff; font-weight: 700; }
        .tab.active { background: #1d6f78; color: #f5fffd; border-color: #175962; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border-bottom: 1px solid #d9ddce; padding: 10px; text-align: left; font-size: 14px; }
        th { font-size: 12px; text-transform: uppercase; color: #697065; }
        .badge { display: inline-block; border-radius: 999px; padding: 4px 8px; font-size: 11px; font-weight: 700; color: #fff; }
        .pagination { margin-top: 10px; }
    </style>
</head>
<body>
    @php
        $statusBadge = fn (string $status): string => match ($status) {
            'Cold' => '#8a8f98',
            'Warm' => '#f5b100',
            'Hot' => '#e7513d',
            'Deal' => '#1e9d60',
            default => '#2f3135',
        };
    @endphp

    <div class="container">
        <div class="top">
            <h1>Follow Up Tasks</h1>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn" href="{{ route('dashboard.page') }}">Dashboard</a>
                <a class="btn" href="{{ route('activities.index') }}">Activities</a>
                <a class="btn" href="{{ route('leads.index') }}">Leads</a>
                <a class="btn" href="{{ route('reports.index') }}">Reports</a>
            </div>
        </div>

        <section class="panel">
            <div class="tabs">
                <a class="tab {{ $mode === 'due' ? 'active' : '' }}" href="{{ route('followups.index', ['mode' => 'due']) }}">Due Today ({{ number_format($counts['due']) }})</a>
                <a class="tab {{ $mode === 'overdue' ? 'active' : '' }}" href="{{ route('followups.index', ['mode' => 'overdue']) }}">Overdue ({{ number_format($counts['overdue']) }})</a>
                <a class="tab {{ $mode === 'today' ? 'active' : '' }}" href="{{ route('followups.index', ['mode' => 'today']) }}">Today ({{ number_format($counts['today']) }})</a>
            </div>

            <div style="overflow:auto; border:1px solid #d9ddce; border-radius:10px;">
                <table>
                    <thead>
                        <tr>
                            <th>Lead</th>
                            <th>Perusahaan</th>
                            <th>Status Lead</th>
                            <th>Activity</th>
                            <th>Next Follow Up</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>{{ $task->lead?->nama_client ?: '-' }}</td>
                                <td>{{ $task->lead?->perusahaan ?: '-' }}</td>
                                <td><span class="badge" style="background: {{ $statusBadge($task->lead?->status ?? 'Lost') }};">{{ $task->lead?->status ?: '-' }}</span></td>
                                <td>{{ strtoupper($task->jenis) }} · {{ \Illuminate\Support\Str::limit($task->catatan, 48) }}</td>
                                <td>{{ optional($task->next_follow_up)->format('d M Y H:i') }}</td>
                                <td><a class="btn" href="{{ route('leads.show', $task->lead_id) }}">Buka Lead</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="color:#697065;">Tidak ada follow-up untuk mode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">{{ $tasks->links() }}</div>
        </section>
    </div>
</body>
</html>
