<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quotations - CRM295</title>
    <style>
        body { font-family: Manrope, sans-serif; margin: 0; background: #f3f1eb; color: #1f201d; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 40px; }
        .top { display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        h1 { margin: 0; font-size: 30px; }
        .btn { border: 1px solid #d9ddce; border-radius: 10px; padding: 8px 12px; text-decoration: none; color: #1f201d; background: #fff; font-weight: 700; }
        .panel { background: #fffdf8; border: 1px solid #d9ddce; border-radius: 14px; padding: 14px; margin-bottom: 12px; }
        .summary { display: grid; gap: 8px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .summary .item { background: #fff; border: 1px solid #d9ddce; border-radius: 10px; padding: 10px; }
        .summary .label { font-size: 12px; color: #697065; text-transform: uppercase; }
        .summary .value { font-size: 24px; font-weight: 800; }
        .filters { display: grid; gap: 8px; grid-template-columns: 2fr 1fr auto; }
        input, select { width: 100%; border: 1px solid #d9ddce; border-radius: 10px; padding: 10px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border-bottom: 1px solid #d9ddce; padding: 10px; text-align: left; font-size: 14px; }
        th { font-size: 12px; text-transform: uppercase; color: #697065; }
        .actions a { color: #1d6f78; text-decoration: none; font-weight: 700; margin-right: 8px; }
        .pagination { margin-top: 10px; }
        @media (max-width: 920px) { .filters { grid-template-columns: 1fr; } .summary { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <h1>Quotation Management</h1>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn" href="{{ route('dashboard.page') }}">Dashboard</a>
                <a class="btn" href="{{ route('leads.index') }}">Leads</a>
                <a class="btn" href="{{ route('activities.index') }}">Activities</a>
                <a class="btn" href="{{ route('reports.index') }}">Reports</a>
            </div>
        </div>

        @if (session('success'))
            <div class="panel" style="border-color:#9ed8c1; background:#dbf4ea; color:#18593d;">{{ session('success') }}</div>
        @endif

        <section class="panel summary">
            <div class="item"><div class="label">Total Quotation</div><div class="value">{{ number_format($summary['total']) }}</div></div>
            <div class="item"><div class="label">Pipeline Value</div><div class="value">Rp {{ number_format($summary['pipeline_value'], 0, ',', '.') }}</div></div>
            <div class="item"><div class="label">Accepted Bulan Ini</div><div class="value">{{ number_format($summary['accepted_this_month']) }}</div></div>
        </section>

        <section class="panel">
            <form method="GET" action="{{ route('quotations.index') }}" class="filters">
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari nomor quotation, nama client, perusahaan">
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach (['pending', 'nego', 'accepted', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ strtoupper($status) }}</option>
                    @endforeach
                </select>
                <button class="btn" type="submit">Filter</button>
            </form>

            <div style="overflow:auto; margin-top:10px; border:1px solid #d9ddce; border-radius:10px;">
                <table>
                    <thead>
                        <tr>
                            <th>No Penawaran</th>
                            <th>Lead</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->nomor_penawaran ?: '-' }}</td>
                                <td>
                                    <strong>{{ $quotation->lead?->nama_client ?: '-' }}</strong>
                                    <div style="color:#697065; font-size:12px;">{{ $quotation->lead?->perusahaan ?: 'Tanpa perusahaan' }}</div>
                                </td>
                                <td>{{ optional($quotation->tanggal_penawaran)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($quotation->nilai_penawaran, 0, ',', '.') }}</td>
                                <td>{{ strtoupper($quotation->status) }}</td>
                                <td class="actions">
                                    <a href="{{ route('quotations.edit', $quotation) }}">Edit</a>
                                    <a href="{{ route('leads.show', $quotation->lead_id) }}">Lead</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="color:#697065;">Belum ada quotation sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">{{ $quotations->links() }}</div>
        </section>
    </div>
</body>
</html>
