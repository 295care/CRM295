<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activities - CRM295</title>
    <style>
        body { font-family: Manrope, sans-serif; margin: 0; background: #f3f1eb; color: #1f201d; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 40px; }
        .top { display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        h1 { margin: 0; font-size: 30px; }
        .btn { border: 1px solid #d9ddce; border-radius: 10px; padding: 8px 12px; text-decoration: none; color: #1f201d; background: #fff; font-weight: 700; }
        .panel { background: #fffdf8; border: 1px solid #d9ddce; border-radius: 14px; padding: 14px; margin-bottom: 12px; }
        .kpi { display: grid; gap: 8px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .kpi .item { background: #fff; border: 1px solid #d9ddce; border-radius: 10px; padding: 10px; }
        .kpi .label { font-size: 12px; color: #697065; text-transform: uppercase; }
        .kpi .value { font-size: 24px; font-weight: 800; }
        .filters { display: grid; gap: 8px; grid-template-columns: 2fr 1fr 1fr auto; }
        input, select { width: 100%; border: 1px solid #d9ddce; border-radius: 10px; padding: 10px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border-bottom: 1px solid #d9ddce; padding: 10px; text-align: left; font-size: 14px; }
        th { font-size: 12px; text-transform: uppercase; color: #697065; }
        .actions a { color: #1d6f78; text-decoration: none; font-weight: 700; margin-right: 8px; }
        .pagination { margin-top: 10px; }
        @media (max-width: 920px) { .filters { grid-template-columns: 1fr; } .kpi { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <h1>Activity Management</h1>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn" href="{{ route('dashboard.page') }}">Dashboard</a>
                <a class="btn" href="{{ route('leads.index') }}">Leads</a>
                <a class="btn" href="{{ route('followups.index') }}">Follow Up Tasks</a>
                <a class="btn" href="{{ route('reports.index') }}">Reports</a>
            </div>
        </div>

        @if (session('success'))
            <div class="panel" style="border-color:#9ed8c1; background:#dbf4ea; color:#18593d;">{{ session('success') }}</div>
        @endif

        <section class="panel kpi">
            <div class="item"><div class="label">Total Activity</div><div class="value">{{ number_format($kpi['total']) }}</div></div>
            <div class="item"><div class="label">Overdue</div><div class="value">{{ number_format($kpi['overdue']) }}</div></div>
            <div class="item"><div class="label">Activity Hari Ini</div><div class="value">{{ number_format($kpi['today']) }}</div></div>
        </section>

        <section class="panel">
            <form method="GET" action="{{ route('activities.index') }}" class="filters">
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari nama client atau perusahaan">
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    @foreach ($jenisOptions as $jenis)
                        <option value="{{ $jenis }}" @selected($filters['jenis'] === $jenis)>{{ strtoupper($jenis) }}</option>
                    @endforeach
                </select>
                <select name="timeline">
                    <option value="">Semua Timeline</option>
                    <option value="overdue" @selected($filters['timeline'] === 'overdue')>Overdue</option>
                    <option value="today" @selected($filters['timeline'] === 'today')>Hari Ini</option>
                    <option value="upcoming" @selected($filters['timeline'] === 'upcoming')>Upcoming</option>
                </select>
                <button class="btn" type="submit">Filter</button>
            </form>

            <div style="overflow:auto; margin-top:10px; border:1px solid #d9ddce; border-radius:10px;">
                <table>
                    <thead>
                        <tr>
                            <th>Lead</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Catatan</th>
                            <th>Next Follow Up</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td>
                                    <strong>{{ $activity->lead?->nama_client ?: '-' }}</strong>
                                    <div style="color:#697065; font-size:12px;">{{ $activity->lead?->perusahaan ?: 'Tanpa perusahaan' }}</div>
                                </td>
                                <td>{{ optional($activity->tanggal)->format('d M Y') }}</td>
                                <td>{{ strtoupper($activity->jenis) }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($activity->catatan, 80) }}</td>
                                <td>{{ $activity->next_follow_up ? optional($activity->next_follow_up)->format('d M Y H:i') : '-' }}</td>
                                <td class="actions">
                                    <a href="{{ route('activities.edit', $activity) }}">Edit</a>
                                    <a href="{{ route('leads.show', $activity->lead_id) }}">Lead</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="color:#697065;">Belum ada activity sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">{{ $activities->links() }}</div>
        </section>
    </div>
</body>
</html>
