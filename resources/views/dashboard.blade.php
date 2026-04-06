<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-start: #f6efe5;
            --bg-end: #ecf2e8;
            --panel: #fffef9;
            --ink: #232420;
            --muted: #6f7268;
            --line: #d9dccf;
            --accent: #0b7285;
            --accent-soft: #d9eff2;
            --warning: #f5b100;
            --danger: #e7513d;
            --success: #1e9d60;
            --slate: #8a8f98;
            --lost: #2f3135;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 85% 10%, #f7dabb 0, transparent 26%),
                radial-gradient(circle at 15% 30%, #d5ece0 0, transparent 24%),
                linear-gradient(140deg, var(--bg-start), var(--bg-end));
        }

        .wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 28px 20px 42px;
        }

        .hero {
            background: linear-gradient(120deg, #143d47, #0f5764 60%, #196977);
            color: #f8fffd;
            border-radius: 24px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 30px rgba(20, 61, 71, 0.22);
            animation: rise 420ms ease-out both;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 999px;
            right: -120px;
            top: -120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0));
        }

        .hero h1 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(24px, 4vw, 36px);
            letter-spacing: -0.03em;
        }

        .hero p {
            margin: 8px 0 0;
            max-width: 700px;
            color: rgba(246, 255, 252, 0.88);
            line-height: 1.6;
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .auth-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-chip {
            border: 1px solid rgba(248, 255, 253, 0.35);
            border-radius: 999px;
            background: rgba(248, 255, 253, 0.12);
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .logout-btn {
            border: 1px solid rgba(248, 255, 253, 0.35);
            border-radius: 999px;
            background: rgba(248, 255, 253, 0.08);
            color: #f8fffd;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
        }

        .hero-nav {
            margin-top: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .hero-nav a {
            text-decoration: none;
            color: #f8fffd;
            border: 1px solid rgba(248, 255, 253, 0.35);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 700;
            background: rgba(248, 255, 253, 0.08);
        }

        .grid {
            margin-top: 18px;
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .card {
            background: color-mix(in srgb, var(--panel) 92%, white 8%);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 10px 18px rgba(36, 40, 30, 0.06);
            animation: rise 520ms ease-out both;
        }

        .kpi {
            grid-column: span 12;
        }

        .kpi .label {
            color: var(--muted);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        .kpi .value {
            margin-top: 8px;
            font-family: 'Sora', sans-serif;
            font-size: clamp(28px, 4vw, 38px);
            letter-spacing: -0.03em;
        }

        .kpi .hint {
            margin-top: 6px;
            color: var(--muted);
            font-size: 14px;
        }

        .funnel,
        .sales,
        .followups {
            grid-column: span 12;
        }

        .title {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .funnel-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 12px;
        }

        .funnel-row {
            display: grid;
            gap: 8px;
        }

        .funnel-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            color: var(--ink);
        }

        .bar {
            width: 100%;
            height: 12px;
            border-radius: 999px;
            background: #e8eadf;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: inherit;
            transform-origin: left;
            animation: grow 860ms ease-out both;
        }

        .sales-list,
        .followup-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .sales-item,
        .followup-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            background: #fff;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: #13363d;
            background: var(--accent-soft);
            white-space: nowrap;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .empty {
            color: var(--muted);
            background: #fbfbf6;
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 14px;
        }

        .status-pill {
            border-radius: 999px;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
        }

        @media (min-width: 768px) {
            .wrap {
                padding: 34px 28px 48px;
            }

            .kpi {
                grid-column: span 6;
            }

            .funnel {
                grid-column: span 7;
            }

            .sales,
            .followups {
                grid-column: span 5;
            }
        }

        @media (min-width: 1024px) {
            .kpi {
                grid-column: span 3;
            }
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes grow {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <div class="hero-top">
                <div>
                    <h1>CRM Pipeline Dashboard</h1>
                    <p>Ringkasan prospek, performa sales, dan follow-up aktif untuk membantu tim melihat kondisi funnel harian dengan cepat.</p>
                </div>
                <div class="auth-box">
                    <span class="auth-chip">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-btn" type="submit">Logout</button>
                    </form>
                </div>
            </div>
            <nav class="hero-nav">
                <a href="{{ route('leads.index') }}">Leads</a>
                <a href="{{ route('activities.index') }}">Activities</a>
                <a href="{{ route('quotations.index') }}">Quotations</a>
                <a href="{{ route('followups.index') }}">Follow Up Tasks</a>
                <a href="{{ route('reports.index') }}">Reports</a>
            </nav>
        </section>

        <section class="grid">
            <article class="card kpi" style="animation-delay: 80ms;">
                <div class="label">Total Lead</div>
                <div class="value">{{ number_format($totalLeads) }}</div>
                <div class="hint">Semua status prospek aktif dan selesai.</div>
            </article>

            <article class="card kpi" style="animation-delay: 140ms;">
                <div class="label">Closing Bulan Ini</div>
                <div class="value">{{ number_format($closingThisMonth) }}</div>
                <div class="hint">Lead dengan status Deal di bulan berjalan.</div>
            </article>

            <article class="card kpi" style="animation-delay: 200ms;">
                <div class="label">Pipeline Value</div>
                <div class="value">Rp {{ number_format($pipelineValue, 0, ',', '.') }}</div>
                <div class="hint">Total quotation dengan status pending dan nego.</div>
            </article>

            <article class="card kpi" style="animation-delay: 260ms;">
                <div class="label">Lost Rate</div>
                <div class="value">{{ number_format($lostRate, 1) }}%</div>
                <div class="hint">Overdue follow-up: {{ number_format($overdueFollowUps) }}</div>
            </article>

            <article class="card funnel" style="animation-delay: 320ms;">
                <h2 class="title">Funnel Status</h2>
                @php
                    $maxFunnel = collect($funnel)->max('value') ?: 1;
                @endphp
                <ul class="funnel-list">
                    @foreach ($funnel as $row)
                        <li class="funnel-row">
                            <div class="funnel-meta">
                                <strong>{{ $row['label'] }}</strong>
                                <span>{{ number_format($row['value']) }}</span>
                            </div>
                            <div class="bar">
                                <div class="bar-fill" style="width: {{ ($row['value'] / $maxFunnel) * 100 }}%; background: {{ $row['color'] }};"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </article>

            <article class="card sales" style="animation-delay: 380ms;">
                <h2 class="title">Performa Sales</h2>
                @if ($perSales->isEmpty())
                    <div class="empty">Belum ada data assignment sales.</div>
                @else
                    <ul class="sales-list">
                        @foreach ($perSales as $row)
                            <li class="sales-item">
                                <div>
                                    <strong>{{ $row->assignedUser?->name ?? 'Unassigned' }}</strong>
                                    <div class="muted">Assigned Leads</div>
                                </div>
                                <span class="badge">{{ number_format($row->total) }} Lead</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>

            <article class="card followups" style="animation-delay: 440ms;">
                <h2 class="title">Upcoming Follow-up</h2>
                @if ($upcomingFollowUps->isEmpty())
                    <div class="empty">Tidak ada follow-up terjadwal dalam waktu dekat.</div>
                @else
                    <ul class="followup-list">
                        @foreach ($upcomingFollowUps as $item)
                            @php
                                $statusColor = match ($item->lead?->status) {
                                    'Cold' => 'var(--slate)',
                                    'Warm' => 'var(--warning)',
                                    'Hot' => 'var(--danger)',
                                    'Deal' => 'var(--success)',
                                    default => 'var(--lost)',
                                };
                            @endphp
                            <li class="followup-item">
                                <div>
                                    <strong>{{ $item->lead?->nama_client ?? 'Lead tidak ditemukan' }}</strong>
                                    <div class="muted">{{ $item->lead?->perusahaan ?: 'Tanpa perusahaan' }} · {{ optional($item->next_follow_up)->format('d M Y H:i') }}</div>
                                </div>
                                <span class="status-pill" style="background: {{ $statusColor }};">{{ $item->lead?->status ?? 'Unknown' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>
        </section>
    </div>
</body>
</html>