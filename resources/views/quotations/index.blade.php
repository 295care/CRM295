<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quotation Management - CRM 295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.sidebar-styles')
    @include('partials.app-styles')
</head>
<body>
<div class="app-shell">
    @include('partials.sidebar')
    <main class="app-main">
        <div class="page-wrap">
            <div class="page-header">
                <h1 class="page-title">Quotation Management</h1>
                <a href="{{ route('quotations.create') }}" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Quotation
                </a>
            </div>

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Summary Stats --}}
            <div class="stat-grid" style="margin-bottom:20px;">
                <div class="stat-card">
                    <div class="stat-label">Total Quotation</div>
                    <div class="stat-value">{{ number_format($summary['total']) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Quotation Berjalan</div>
                    <div class="stat-value accent">{{ number_format($summary['quotation_ongoing']) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Deal Bulan Ini</div>
                    <div class="stat-value success">{{ number_format($summary['deal_this_month']) }}</div>
                </div>
            </div>

            {{-- Filter + Table --}}
            <div class="panel" style="padding-bottom:0;">
                <form method="GET" action="{{ route('quotations.index') }}" class="filter-bar">
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari nomor quotation, nama client, perusahaan">
                    <select name="status">
                        <option value="">Semua Status</option>
                        @foreach (['pending', 'nego', 'accepted', 'rejected'] as $status)
                            <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>

                <div class="table-wrap" style="border-left:none; border-right:none; border-bottom:none; border-radius:0; margin-top:12px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Jenis Projek</th>
                                <th>Tanggal</th>
                                <th>Nilai Penawaran</th>
                                <th>HPP</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quotations as $quotation)
                                <tr>
                                    <td>
                                        @if($quotation->client)
                                            <a href="{{ route('clients.show', $quotation->client) }}" class="td-link">{{ $quotation->client->nama }}</a>
                                        @else
                                            <span style="color:#d1d5db;">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $quotation->nama_projek ?: '-' }}</td>
                                    <td style="color:#9ca3af; font-size:12px;">{{ optional($quotation->tanggal_penawaran)->format('d M Y') ?: '-' }}</td>
                                    <td style="font-weight:600;">Rp {{ number_format($quotation->nilai_penawaran, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($quotation->hpp ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower($quotation->status) }}">{{ ucfirst($quotation->status) }}</span>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <a href="{{ route('quotations.edit', $quotation) }}" class="action-link edit">Update</a>
                                        <a href="{{ route('quotations.history', $quotation) }}" class="action-link history">History</a>
                                        <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center; color:#9ca3af; padding:32px;">Belum ada quotation sesuai filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pagination">{{ $quotations->links() }}</div>
        </div>
    </main>
</div>
</body>
</html>
