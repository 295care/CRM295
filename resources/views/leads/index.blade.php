<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leads - CRM295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f1eb;
            --panel: #fffdf8;
            --ink: #1f201d;
            --muted: #697065;
            --line: #d9ddce;
            --accent: #1d6f78;
            --danger: #cb4a35;
            --cold: #8a8f98;
            --warm: #f5b100;
            --hot: #e7513d;
            --deal: #1e9d60;
            --lost: #2f3135;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 0% 0%, #e8f3ee 0, transparent 28%),
                radial-gradient(circle at 100% 0%, #f8dfc7 0, transparent 28%),
                var(--bg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px 40px;
        }

        .topbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        h1 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(24px, 4vw, 34px);
            letter-spacing: -0.03em;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 14px;
            background: white;
            color: var(--ink);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #f5fffd;
            border-color: #175962;
        }

        .panel {
            background: color-mix(in srgb, var(--panel) 94%, #fff 6%);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 16px;
            box-shadow: 0 10px 20px rgba(30, 34, 28, 0.06);
        }

        .stats {
            margin-top: 14px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .stat-item {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .stat-item .label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
        }

        .stat-item .value {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            margin-top: 4px;
        }

        .filters {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 10px;
        }

        .filters input,
        .filters select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            background: #fff;
        }

        .table-wrap {
            margin-top: 14px;
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 820px;
            background: #fff;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
            background: #f9faf5;
        }

        .status {
            display: inline-block;
            border-radius: 999px;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
        }

        .row-actions {
            display: flex;
            gap: 8px;
        }

        .row-actions a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
        }

        .alert {
            background: #dbf4ea;
            border: 1px solid #9ed8c1;
            color: #18593d;
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .empty {
            border: 1px dashed var(--line);
            border-radius: 12px;
            color: var(--muted);
            padding: 14px;
            margin-top: 12px;
            background: #fff;
        }

        .pagination {
            margin-top: 14px;
        }

        @media (min-width: 900px) {
            .filters {
                grid-template-columns: 2.2fr 1fr 1fr 1fr auto;
                align-items: center;
            }

            .stats {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body>
    @php
        $statusColor = fn (string $status): string => match ($status) {
            'Cold' => 'var(--cold)',
            'Warm' => 'var(--warm)',
            'Hot' => 'var(--hot)',
            'Deal' => 'var(--deal)',
            default => 'var(--lost)',
        };
    @endphp

    <div class="container">
        <div class="topbar">
            <h1>Leads Workspace</h1>
            <div class="actions">
                <a class="btn" href="{{ route('dashboard.page') }}">Dashboard</a>
                <a class="btn" href="{{ route('reports.index') }}">Reports</a>
                <a class="btn btn-primary" href="{{ route('leads.create') }}">Tambah Lead</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <section class="panel">
            <form method="GET" action="{{ route('leads.index') }}" class="filters">
                <input
                    type="text"
                    name="q"
                    value="{{ $filters['q'] }}"
                    placeholder="Cari nama client, perusahaan, atau nomor HP"
                >

                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach (['Cold', 'Warm', 'Hot', 'Deal', 'Lost'] as $option)
                        <option value="{{ $option }}" @selected($filters['status'] === $option)>{{ $option }}</option>
                    @endforeach
                </select>

                <select name="assigned_to">
                    <option value="">Semua Sales</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string) $filters['assigned_to'] === (string) $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>

                <select name="sort">
                    <option value="latest" @selected($filters['sort'] === 'latest')>Terbaru</option>
                    <option value="oldest" @selected($filters['sort'] === 'oldest')>Terlama</option>
                    <option value="name" @selected($filters['sort'] === 'name')>Nama Client</option>
                </select>

                <button class="btn btn-primary" type="submit">Filter</button>
            </form>

            <div class="stats">
                @foreach (['Cold', 'Warm', 'Hot', 'Deal', 'Lost'] as $s)
                    <div class="stat-item">
                        <div class="label">{{ $s }}</div>
                        <div class="value" style="color: {{ $statusColor($s) }};">{{ number_format($statusCounts[$s] ?? 0) }}</div>
                    </div>
                @endforeach
                <div class="stat-item">
                    <div class="label">Total Lead</div>
                    <div class="value">{{ number_format($leads->total()) }}</div>
                </div>
            </div>

            @if ($leads->isEmpty())
                <div class="empty">Belum ada lead sesuai filter. Coba ubah filter atau tambah lead baru.</div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Perusahaan</th>
                                <th>Kontak</th>
                                <th>Status</th>
                                <th>Assigned</th>
                                <th>Updated</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $lead)
                                <tr>
                                    <td>
                                        <strong>{{ $lead->nama_client }}</strong>
                                        <div style="color: var(--muted); font-size: 12px;">{{ $lead->email ?: 'Tanpa email' }}</div>
                                    </td>
                                    <td>{{ $lead->perusahaan ?: '-' }}</td>
                                    <td>{{ $lead->no_hp }}</td>
                                    <td>
                                        <span class="status" style="background: {{ $statusColor($lead->status) }};">{{ $lead->status }}</span>
                                    </td>
                                    <td>{{ $lead->assignedUser?->name ?: '-' }}</td>
                                    <td>{{ $lead->updated_at?->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="row-actions">
                                            <a href="{{ route('leads.show', $lead) }}">Detail</a>
                                            <a href="{{ route('leads.edit', $lead) }}">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">{{ $leads->links() }}</div>
            @endif
        </section>
    </div>
</body>
</html>
