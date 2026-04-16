<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Client - CRM 295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.sidebar-styles')
    @include('partials.app-styles')
    <style>
        .profile-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #9ca3af;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e2022;
        }
    </style>
</head>
<body>
<div class="app-shell">
    @include('partials.sidebar')
    <main class="app-main">
        <div class="page-wrap">
            <div class="page-header">
                <div>
                    <h1 class="page-title">{{ $client->nama }}</h1>
                    <p class="page-subtitle">{{ $client->perusahaan ?: 'Tanpa perusahaan' }}</p>
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a class="btn btn-primary" href="{{ route('clients.edit', $client) }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Client
                    </a>
                    <a class="btn btn-secondary" href="{{ route('clients.index') }}">Kembali</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Profile Info --}}
            <div class="panel">
                <h2 class="section-title">Profil Client</h2>
                <div class="profile-grid">
                    <div class="meta-item">
                        <span class="meta-label">Nama</span>
                        <span class="meta-value">{{ $client->nama }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Perusahaan</span>
                        <span class="meta-value">{{ $client->perusahaan ?: '-' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Nomor WA</span>
                        <span class="meta-value">{{ $client->nomor_wa }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Sumber Client</span>
                        <span class="meta-value"><span class="badge badge-default">{{ ucfirst($client->sumber_client) }}</span></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Jenis Bisnis</span>
                        <span class="meta-value">{{ $client->jenis_bisnis ?: '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Quotations --}}
            <div class="panel">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                    <h2 class="section-title" style="margin:0;">Quotation Client</h2>
                    <a href="{{ route('quotations.create', ['client_id' => $client->id]) }}" class="btn btn-primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Quotation
                    </a>
                </div>

                @if ($client->quotations->isEmpty())
                    <div class="empty-state">Belum ada quotation untuk client ini.</div>
                @else
                    <div class="table-wrap">
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
                                @foreach ($client->quotations as $quotation)
                                    <tr>
                                        <td style="font-weight:600;">{{ $quotation->client->nama ?? '-' }}</td>
                                        <td>{{ $quotation->nama_projek ?? '-' }}</td>
                                        <td style="color:#9ca3af; font-size:12px;">{{ optional($quotation->tanggal_penawaran)->format('d M Y') ?: '-' }}</td>
                                        <td style="font-weight:600;">Rp {{ number_format((float) $quotation->nilai_penawaran, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format((float) $quotation->hpp, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ strtolower($quotation->status) }}">{{ ucfirst($quotation->status) }}</span>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <a href="{{ route('quotations.edit', $quotation->id) }}" class="action-link edit">Update</a>
                                            <a href="{{ route('quotations.history', $quotation->id) }}" class="action-link history">History</a>
                                            <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus quotation ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link delete">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
</body>
</html>
