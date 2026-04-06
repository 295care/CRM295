<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - CRM295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f1eb;
            --panel: #fffdf8;
            --ink: #1f201d;
            --muted: #697065;
            --line: #d9ddce;
            --accent: #1d6f78;
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
                radial-gradient(circle at 15% 15%, #e8f3ee 0, transparent 24%),
                radial-gradient(circle at 95% 5%, #f8dfc7 0, transparent 24%),
                var(--bg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px 40px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        h1 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(24px, 4vw, 34px);
            letter-spacing: -0.03em;
        }

        .btn {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 9px 12px;
            text-decoration: none;
            color: var(--ink);
            background: #fff;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--accent);
            color: #f5fffd;
            border-color: #175962;
        }

        .panel {
            background: color-mix(in srgb, var(--panel) 94%, #fff 6%);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 10px 20px rgba(30, 34, 28, 0.06);
            margin-bottom: 12px;
        }

        .panel h2 {
            margin: 0 0 10px;
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            letter-spacing: -0.02em;
        }

        .toolbar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        select {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 9px 10px;
            background: #fff;
            min-width: 140px;
        }

        .filter-grid {
            display: grid;
            gap: 8px;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            width: 100%;
        }

        .toolbar-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        .kpi {
            display: grid;
            gap: 8px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .kpi .item {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .kpi .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
            font-weight: 700;
        }

        .kpi .value {
            margin-top: 4px;
            font-family: 'Sora', sans-serif;
            font-size: 24px;
        }

        .health-grid {
            display: grid;
            gap: 8px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 10px;
        }

        .health-item {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .health-item .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
            font-weight: 700;
        }

        .health-item .value {
            margin-top: 4px;
            font-family: 'Sora', sans-serif;
            font-size: 24px;
        }

        .severity-pill {
            display: inline-block;
            border-radius: 999px;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .severity-low {
            background: #dff5e9;
            color: #16613d;
            border: 1px solid #a9dfc1;
        }

        .severity-medium {
            background: #fff5d8;
            color: #7f5b00;
            border: 1px solid #f3d68a;
        }

        .severity-high {
            background: #ffe5e0;
            color: #8a2d1f;
            border: 1px solid #f2b0a3;
        }

        .health-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 8px;
        }

        .health-list li {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            align-items: center;
        }

        .health-list li.severity-low {
            border-left: 5px solid #1e9d60;
        }

        .health-list li.severity-medium {
            border-left: 5px solid #f5b100;
        }

        .health-list li.severity-high {
            border-left: 5px solid #e7513d;
        }

        .layout {
            display: grid;
            gap: 12px;
            grid-template-columns: 1fr;
        }

        .bars {
            display: grid;
            gap: 8px;
        }

        .bar-item {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px;
        }

        .bar-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .track {
            border-radius: 999px;
            background: #e8eadf;
            height: 10px;
            overflow: hidden;
            display: flex;
        }

        .deal-fill { background: var(--deal); }
        .lost-fill { background: var(--lost); }

        .table-wrap {
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: auto;
        }

        table {
            width: 100%;
            min-width: 640px;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
        }

        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
        }

        .muted { color: var(--muted); font-size: 13px; }

        @media (max-width: 980px) {
            .kpi {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .health-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        @media (min-width: 980px) {
            .layout {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $maxMonth = max(1, $monthlyClosing->map(fn ($item) => $item['deal_total'] + $item['lost_total'])->max());

        $severityLevel = function (int $count): array {
            if ($count >= 8) {
                return ['class' => 'severity-high', 'label' => 'High'];
            }

            if ($count >= 3) {
                return ['class' => 'severity-medium', 'label' => 'Medium'];
            }

            return ['class' => 'severity-low', 'label' => 'Low'];
        };

        $totalSeverity = $severityLevel((int) $reminderHealth['total_overdue']);
        $unassignedSeverity = $severityLevel((int) $reminderHealth['unassigned_overdue']);
    @endphp

    <div class="container">
        <div class="top">
            <h1>Reporting Center</h1>
            <div class="toolbar">
                <a class="btn" href="{{ route('dashboard.page') }}">Dashboard</a>
                <a class="btn" href="{{ route('leads.index') }}">Leads</a>
                <a class="btn" href="{{ route('activities.index') }}">Activities</a>
                <a class="btn" href="{{ route('quotations.index') }}">Quotations</a>
            </div>
        </div>

        <section class="panel">
            <form method="GET" action="{{ route('reports.index') }}" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center; justify-content:space-between;">
                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap; width: 100%;">
                    <div class="filter-grid">
                        <div>
                            <label for="year" style="font-weight:700; color:var(--muted); font-size:13px;">Tahun Report</label>
                            <select id="year" name="year">
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" @selected((int) $selectedYear === (int) $year)>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sales_id" style="font-weight:700; color:var(--muted); font-size:13px;">Sales</label>
                            <select id="sales_id" name="sales_id">
                                <option value="">Semua Sales</option>
                                @foreach ($salesOptions as $sales)
                                    <option value="{{ $sales->id }}" @selected((string) ($filters['sales_id'] ?? '') === (string) $sales->id)>{{ $sales->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" style="font-weight:700; color:var(--muted); font-size:13px;">Status Lead</label>
                            <select id="status" name="status">
                                <option value="">Semua Status</option>
                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sumber_lead" style="font-weight:700; color:var(--muted); font-size:13px;">Sumber Lead</label>
                            <select id="sumber_lead" name="sumber_lead">
                                <option value="">Semua Sumber</option>
                                @foreach ($sumberLeadOptions as $source)
                                    <option value="{{ $source }}" @selected(($filters['sumber_lead'] ?? '') === $source)>{{ $source }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="from_date" style="font-weight:700; color:var(--muted); font-size:13px;">Dari Tanggal</label>
                            <input id="from_date" type="date" name="from_date" value="{{ $filters['from_date'] ?? '' }}" style="width:100%; border:1px solid var(--line); border-radius:10px; padding:9px 10px;">
                        </div>
                        <div>
                            <label for="to_date" style="font-weight:700; color:var(--muted); font-size:13px;">Sampai Tanggal</label>
                            <input id="to_date" type="date" name="to_date" value="{{ $filters['to_date'] ?? '' }}" style="width:100%; border:1px solid var(--line); border-radius:10px; padding:9px 10px;">
                        </div>
                    </div>

                    <div class="toolbar-actions">
                        <button class="btn btn-primary" type="submit">Terapkan</button>
                        <a class="btn" href="{{ route('reports.index', ['year' => $selectedYear]) }}">Reset Filter</a>
                    </div>
                </div>
                <div class="toolbar-actions">
                    <a class="btn" href="{{ route('reports.export', [
                        'year' => $selectedYear,
                        'sales_id' => $filters['sales_id'] ?? null,
                        'status' => $filters['status'] ?? null,
                        'sumber_lead' => $filters['sumber_lead'] ?? null,
                        'from_date' => $filters['from_date'] ?? null,
                        'to_date' => $filters['to_date'] ?? null,
                    ]) }}">Export Lead CSV</a>
                    <a class="btn" href="{{ route('reports.export.sales-monthly', [
                        'year' => $selectedYear,
                        'sales_id' => $filters['sales_id'] ?? null,
                        'status' => $filters['status'] ?? null,
                        'sumber_lead' => $filters['sumber_lead'] ?? null,
                        'from_date' => $filters['from_date'] ?? null,
                        'to_date' => $filters['to_date'] ?? null,
                    ]) }}">Export Sales Monthly CSV</a>
                </div>
            </form>
        </section>

        <section class="panel kpi">
            <div class="item">
                <div class="label">Total Leads</div>
                <div class="value">{{ number_format($overview['total_leads']) }}</div>
            </div>
            <div class="item">
                <div class="label">Deal</div>
                <div class="value" style="color: var(--deal);">{{ number_format($overview['deal_total']) }}</div>
            </div>
            <div class="item">
                <div class="label">Lost</div>
                <div class="value" style="color: var(--lost);">{{ number_format($overview['lost_total']) }}</div>
            </div>
            <div class="item">
                <div class="label">Pipeline Value</div>
                <div class="value">Rp {{ number_format($overview['pipeline_value'], 0, ',', '.') }}</div>
            </div>
        </section>

        <section class="panel">
            <h2>Reminder Health</h2>
            <div class="health-grid">
                <div class="health-item">
                    <div class="label">Total Overdue</div>
                    <div class="value">{{ number_format($reminderHealth['total_overdue']) }}</div>
                    <span class="severity-pill {{ $totalSeverity['class'] }}">{{ $totalSeverity['label'] }}</span>
                </div>
                <div class="health-item">
                    <div class="label">Unassigned Overdue</div>
                    <div class="value">{{ number_format($reminderHealth['unassigned_overdue']) }}</div>
                    <span class="severity-pill {{ $unassignedSeverity['class'] }}">{{ $unassignedSeverity['label'] }}</span>
                </div>
                <div class="health-item">
                    <div class="label">Target Date</div>
                    <div class="value" style="font-size: 18px;">{{ \Carbon\Carbon::parse($reminderHealth['target_date'])->format('d M Y') }}</div>
                </div>
            </div>

            @if (collect($reminderHealth['sales'])->isEmpty())
                <p class="muted">Tidak ada overdue follow-up untuk filter aktif.</p>
            @else
                <ul class="health-list">
                    @foreach ($reminderHealth['sales'] as $row)
                        @php
                            $salesSeverity = $severityLevel((int) $row['overdue_count']);
                        @endphp
                        <li class="{{ $salesSeverity['class'] }}">
                            <div>
                                <strong>{{ $row['sales_name'] }}</strong>
                                <div class="muted">Oldest: {{ $row['next_oldest_followup'] ?: '-' }}</div>
                                <span class="severity-pill {{ $salesSeverity['class'] }}">{{ $salesSeverity['label'] }}</span>
                            </div>
                            <div style="text-align:right;">
                                <strong>{{ number_format($row['overdue_count']) }}</strong>
                                <div class="muted">overdue</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="layout">
            <article class="panel">
                <h2>Closing vs Lost per Bulan</h2>
                <div class="bars">
                    @foreach ($monthlyClosing as $month)
                        @php
                            $total = $month['deal_total'] + $month['lost_total'];
                            $dealWidth = $total > 0 ? ($month['deal_total'] / $maxMonth) * 100 : 0;
                            $lostWidth = $total > 0 ? ($month['lost_total'] / $maxMonth) * 100 : 0;
                        @endphp
                        <div class="bar-item">
                            <div class="bar-meta">
                                <strong>{{ $month['month_label'] }}</strong>
                                <span>Deal {{ $month['deal_total'] }} · Lost {{ $month['lost_total'] }}</span>
                            </div>
                            <div class="track">
                                <div class="deal-fill" style="width: {{ $dealWidth }}%;"></div>
                                <div class="lost-fill" style="width: {{ $lostWidth }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="panel">
                <h2>Performa per Sales</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Sales</th>
                                <th>Total Leads</th>
                                <th>Deal</th>
                                <th>Lost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($perSales as $row)
                                <tr>
                                    <td>{{ $row->assignedUser?->name ?: 'Unassigned' }}</td>
                                    <td>{{ number_format($row->total_leads) }}</td>
                                    <td>{{ number_format($row->deal_total) }}</td>
                                    <td>{{ number_format($row->lost_total) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="muted">Belum ada data sales untuk tahun ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="panel">
            <h2>Top Client/Prospek by Quotation Value</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th>Assigned</th>
                            <th>Total Quotation</th>
                            <th>Jumlah Quotation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perClient as $lead)
                            <tr>
                                <td><a href="{{ route('leads.show', $lead) }}" style="color:#1d6f78; font-weight:700; text-decoration:none;">{{ $lead->nama_client }}</a></td>
                                <td>{{ $lead->perusahaan ?: '-' }}</td>
                                <td>{{ $lead->status }}</td>
                                <td>{{ $lead->assignedUser?->name ?: '-' }}</td>
                                <td>Rp {{ number_format($lead->total_quotation_value ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($lead->quotations_count) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="muted">Belum ada data client untuk tahun ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel">
            <h2>Funnel Conversion Rate</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Tahap</th>
                            <th>Naik Tahap</th>
                            <th>Drop</th>
                            <th>Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funnelTransitions as $transition)
                            <tr>
                                <td>{{ $transition['label'] }}</td>
                                <td>{{ number_format($transition['success']) }}</td>
                                <td>{{ number_format($transition['drop']) }}</td>
                                <td>{{ number_format($transition['rate'], 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="muted" style="margin-top:8px;">Rate dihitung dari histori perpindahan status pada periode filter aktif.</p>
        </section>
    </div>
</body>
</html>
