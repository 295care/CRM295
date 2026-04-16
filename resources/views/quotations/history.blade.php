<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>History Quotation {{ $quotation->nama_projek }} - CRM 295</title>
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
                <div>
                    <h1 class="page-title">History Quotation</h1>
                    <p class="page-subtitle">{{ $quotation->nama_projek }} &mdash; {{ $quotation->client->nama ?? '-' }}</p>
                </div>
                <div style="display:flex; gap:8px;">
                    <a class="btn btn-primary" href="{{ route('quotations.edit', $quotation) }}">Update Quotation</a>
                    <a class="btn btn-secondary" href="{{ route('quotations.index') }}">Kembali</a>
                </div>
            </div>

            @if($histories->isEmpty())
                <div class="empty-state">Belum ada history perubahan untuk quotation ini.</div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal / Waktu</th>
                                <th>Status</th>
                                <th>Nilai Penawaran</th>
                                <th>HPP</th>
                                <th>Diupdate Oleh</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                                <tr>
                                    <td style="color:#4b5563; font-size:13px;">{{ $history->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower($history->status) }}">{{ $history->status }}</span>
                                    </td>
                                    <td style="font-weight:600;">Rp {{ number_format($history->nilai_penawaran, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($history->hpp, 0, ',', '.') }}</td>
                                    <td>{{ $history->changedBy ? $history->changedBy->name : '-' }}</td>
                                    <td style="color:#9ca3af;">{{ $history->catatan ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>
</div>
</body>
</html>
