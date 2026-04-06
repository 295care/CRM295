<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Lead - CRM295</title>
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
                radial-gradient(circle at 10% 20%, #e8f3ee 0, transparent 24%),
                radial-gradient(circle at 90% 0%, #f8dfc7 0, transparent 24%),
                var(--bg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 16px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .title h1 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(22px, 4vw, 33px);
            letter-spacing: -0.03em;
        }

        .title p {
            margin: 6px 0 0;
            color: var(--muted);
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

        .btn-danger {
            background: #fff1ee;
            border-color: #f1c7bf;
            color: #982f1e;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
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

        .error-box {
            background: #ffe9e5;
            color: #832614;
            border: 1px solid #f8b9ab;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .panel {
            background: color-mix(in srgb, var(--panel) 94%, #fff 6%);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 10px 20px rgba(30, 34, 28, 0.06);
        }

        .panel h2 {
            margin: 0 0 10px;
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            letter-spacing: -0.02em;
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .meta .item {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .meta .item .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
            font-weight: 700;
        }

        .meta .item .value {
            margin-top: 5px;
            font-size: 14px;
            font-weight: 600;
            word-break: break-word;
        }

        .status {
            display: inline-block;
            border-radius: 999px;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
        }

        label {
            display: block;
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            background: #fff;
            font-family: inherit;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 8px;
        }

        .list-item {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .empty {
            border: 1px dashed var(--line);
            border-radius: 12px;
            color: var(--muted);
            padding: 12px;
            background: #fff;
        }

        .form-footer {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        @media (min-width: 920px) {
            .layout {
                grid-template-columns: 1.15fr 1fr;
            }

            .meta {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .grid.two {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $statusColor = match ($lead->status) {
            'Cold' => 'var(--cold)',
            'Warm' => 'var(--warm)',
            'Hot' => 'var(--hot)',
            'Deal' => 'var(--deal)',
            default => 'var(--lost)',
        };
    @endphp

    <div class="container">
        <div class="topbar">
            <div class="title">
                <h1>{{ $lead->nama_client }}</h1>
                <p>{{ $lead->perusahaan ?: 'Tanpa perusahaan' }}</p>
            </div>
            <div class="actions">
                <a class="btn" href="{{ route('leads.index') }}">Kembali ke Leads</a>
                <a class="btn" href="{{ route('leads.edit', $lead) }}">Edit Lead</a>
                <form method="POST" action="{{ route('leads.destroy', $lead) }}" onsubmit="return confirm('Hapus lead ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                <strong>Beberapa input tidak valid:</strong>
                <ul style="margin: 8px 0 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="panel" style="margin-bottom: 12px;">
            <h2>Profil Lead</h2>
            <div class="meta">
                <div class="item">
                    <div class="label">Status</div>
                    <div class="value"><span class="status" style="background: {{ $statusColor }};">{{ $lead->status }}</span></div>
                </div>
                <div class="item">
                    <div class="label">Assigned</div>
                    <div class="value">{{ $lead->assignedUser?->name ?: '-' }}</div>
                </div>
                <div class="item">
                    <div class="label">No HP</div>
                    <div class="value">{{ $lead->no_hp }}</div>
                </div>
                <div class="item">
                    <div class="label">Email</div>
                    <div class="value">{{ $lead->email ?: '-' }}</div>
                </div>
                <div class="item">
                    <div class="label">Sumber Lead</div>
                    <div class="value">{{ $lead->sumber_lead ?: '-' }}</div>
                </div>
                <div class="item">
                    <div class="label">Updated</div>
                    <div class="value">{{ $lead->updated_at?->format('d M Y H:i') }}</div>
                </div>
            </div>
            <div style="margin-top: 10px;" class="muted">
                <strong>Alamat:</strong> {{ $lead->alamat ?: '-' }}<br>
                <strong>Notes:</strong> {{ $lead->notes ?: '-' }}
            </div>
        </section>

        <div class="layout">
            <div class="panel">
                <h2>Quick Actions</h2>

                <form method="POST" action="{{ route('leads.status.update', $lead) }}" style="margin-bottom: 12px;">
                    @csrf
                    <div class="grid two">
                        <div>
                            <label for="status">Update Status</label>
                            <select id="status" name="status" required>
                                @foreach (['Cold', 'Warm', 'Hot', 'Deal', 'Lost'] as $status)
                                    <option value="{{ $status }}" @selected($lead->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="note">Catatan Perubahan</label>
                            <input id="note" type="text" name="note" placeholder="opsional">
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Simpan Status</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('leads.activities.store', $lead) }}" style="margin-bottom: 12px;">
                    @csrf
                    <h2 style="margin-bottom: 8px;">Tambah Activity</h2>
                    <div class="grid two">
                        <div>
                            <label for="tanggal">Tanggal</label>
                            <input id="tanggal" type="date" name="tanggal" value="{{ now()->toDateString() }}" required>
                        </div>
                        <div>
                            <label for="jenis">Jenis</label>
                            <select id="jenis" name="jenis" required>
                                @foreach (['call', 'meeting', 'wa', 'email', 'visit'] as $jenis)
                                    <option value="{{ $jenis }}">{{ strtoupper($jenis) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 10px;">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" required></textarea>
                    </div>
                    <div style="margin-top: 10px;">
                        <label for="next_follow_up">Next Follow Up</label>
                        <input id="next_follow_up" type="datetime-local" name="next_follow_up">
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Tambah Activity</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('leads.quotations.store', $lead) }}">
                    @csrf
                    <h2 style="margin-bottom: 8px;">Tambah Quotation</h2>
                    @if ($lead->status !== 'Hot')
                        <div class="empty" style="margin-bottom: 10px;">Quotation hanya dapat ditambahkan saat status lead Hot.</div>
                    @endif
                    <div class="grid two">
                        <div>
                            <label for="tanggal_penawaran">Tanggal Penawaran</label>
                            <input id="tanggal_penawaran" type="date" name="tanggal_penawaran" value="{{ now()->toDateString() }}" required>
                        </div>
                        <div>
                            <label for="nomor_penawaran">Nomor Penawaran</label>
                            <input id="nomor_penawaran" type="text" name="nomor_penawaran">
                        </div>
                    </div>
                    <div class="grid two" style="margin-top: 10px;">
                        <div>
                            <label for="nilai_penawaran">Nilai Penawaran</label>
                            <input id="nilai_penawaran" type="number" min="0" step="0.01" name="nilai_penawaran" required>
                        </div>
                        <div>
                            <label for="quotation_status">Status Quotation</label>
                            <select id="quotation_status" name="status" required>
                                @foreach (['pending', 'nego', 'accepted', 'rejected'] as $qStatus)
                                    <option value="{{ $qStatus }}">{{ strtoupper($qStatus) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 10px;">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan"></textarea>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit" @disabled($lead->status !== 'Hot')>Tambah Quotation</button>
                    </div>
                </form>
            </div>

            <div style="display: grid; gap: 12px;">
                <section class="panel">
                    <h2>Status History</h2>
                    @if ($lead->statusHistories->isEmpty())
                        <div class="empty">Belum ada riwayat status.</div>
                    @else
                        <ul class="list">
                            @foreach ($lead->statusHistories as $history)
                                <li class="list-item">
                                    <strong>{{ $history->from_status ?: 'Start' }} -> {{ $history->to_status }}</strong>
                                    <div class="muted">{{ optional($history->changed_at)->format('d M Y H:i') }} · {{ $history->changedByUser?->name ?: 'System' }}</div>
                                    <div class="muted">{{ $history->note ?: '-' }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>

                <section class="panel">
                    <h2>Activity Log</h2>
                    @if ($lead->activities->isEmpty())
                        <div class="empty">Belum ada activity.</div>
                    @else
                        <ul class="list">
                            @foreach ($lead->activities as $activity)
                                <li class="list-item">
                                    <strong>{{ strtoupper($activity->jenis) }} · {{ optional($activity->tanggal)->format('d M Y') }}</strong>
                                    <div class="muted">{{ $activity->catatan }}</div>
                                    <div class="muted">Next follow up: {{ $activity->next_follow_up ? optional($activity->next_follow_up)->format('d M Y H:i') : '-' }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>

                <section class="panel">
                    <h2>Quotations</h2>
                    @if ($lead->quotations->isEmpty())
                        <div class="empty">Belum ada quotation.</div>
                    @else
                        <ul class="list">
                            @foreach ($lead->quotations as $quotation)
                                <li class="list-item">
                                    <strong>{{ $quotation->nomor_penawaran ?: 'Tanpa nomor' }} · {{ strtoupper($quotation->status) }}</strong>
                                    <div class="muted">Tanggal: {{ optional($quotation->tanggal_penawaran)->format('d M Y') }}</div>
                                    <div class="muted">Nilai: Rp {{ number_format($quotation->nilai_penawaran, 0, ',', '.') }}</div>
                                    <div class="muted">{{ $quotation->keterangan ?: '-' }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            </div>
        </div>
    </div>
</body>
</html>
