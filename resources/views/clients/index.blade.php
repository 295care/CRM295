<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clients - CRM 295</title>
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
                    <h1 class="page-title">Client Workspace</h1>
                    <p class="page-subtitle">Semua client yang dimiliki tim Anda dalam satu daftar.</p>
                </div>
                <a class="btn btn-primary" href="{{ route('clients.create') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Client
                </a>
            </div>

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="panel" style="padding: 14px 20px;">
                <form method="GET" action="{{ route('clients.index') }}" class="filter-bar" style="margin-bottom:0;">
                    <input id="q" type="text" name="q" value="{{ $search }}" placeholder="Ketik nama, perusahaan, atau nomor WA...">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    @if($search)
                        <a class="btn btn-secondary" href="{{ route('clients.index') }}">Reset</a>
                    @endif
                </form>
            </div>

            @if ($clients->isEmpty())
                <div class="empty-state">Belum ada data client. Tambahkan client pertama Anda sekarang.</div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Perusahaan</th>
                                <th>Nomor WA</th>
                                <th>Sumber</th>
                                <th>Jenis Bisnis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td><a href="{{ route('clients.show', $client) }}" class="td-link">{{ $client->nama }}</a></td>
                                    <td>{{ $client->perusahaan ?: '-' }}</td>
                                    <td>{{ $client->nomor_wa }}</td>
                                    <td><span class="badge badge-default">{{ ucfirst($client->sumber_client) }}</span></td>
                                    <td>{{ $client->jenis_bisnis ?: '-' }}</td>
                                    <td>
                                        <a href="{{ route('clients.show', $client) }}" class="action-link detail">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">{{ $clients->links() }}</div>
            @endif
        </div>
    </main>
</div>
</body>
</html>
