<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Quotation {{ $quotation->nama_projek }} - CRM 295</title>
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
        <div class="page-wrap" style="max-width: 840px;">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Update Quotation</h1>
                    <p class="page-subtitle">{{ $quotation->nama_projek }} &mdash; {{ $quotation->client->nama ?? '-' }}</p>
                </div>
                <a class="btn btn-secondary" href="{{ route('clients.show', $quotation->client_id) }}">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel">
                <form method="POST" action="{{ route('quotations.update', $quotation) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="nama_projek">Jenis Projek</label>
                            <select class="form-control" id="nama_projek" name="nama_projek" required>
                                <option value="">-- Pilih Jenis Projek --</option>
                                <option value="CCTV"       @selected(old('nama_projek', $quotation->nama_projek) == 'CCTV')>CCTV</option>
                                <option value="MCFA"       @selected(old('nama_projek', $quotation->nama_projek) == 'MCFA')>MCFA</option>
                                <option value="Gate"       @selected(old('nama_projek', $quotation->nama_projek) == 'Gate')>Gate</option>
                                <option value="Videotron"  @selected(old('nama_projek', $quotation->nama_projek) == 'Videotron')>Videotron</option>
                                <option value="Smartboard" @selected(old('nama_projek', $quotation->nama_projek) == 'Smartboard')>Smartboard</option>
                                <option value="Smarthome"  @selected(old('nama_projek', $quotation->nama_projek) == 'Smarthome')>Smarthome</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tanggal_penawaran">Tanggal Penawaran</label>
                            <input class="form-control" id="tanggal_penawaran" type="date" name="tanggal_penawaran" value="{{ old('tanggal_penawaran', optional($quotation->tanggal_penawaran)->format('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="nilai_penawaran">Nilai Penawaran</label>
                            <input class="form-control" id="nilai_penawaran" type="number" min="0" step="0.01" name="nilai_penawaran" value="{{ old('nilai_penawaran', $quotation->nilai_penawaran) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="hpp">HPP</label>
                            <input class="form-control" id="hpp" type="number" min="0" step="0.01" name="hpp" value="{{ old('hpp', $quotation->hpp) }}" required>
                        </div>

                        <div class="form-group field-full">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending"  @selected(old('status', $quotation->status)=='pending')>Pending</option>
                                <option value="nego"     @selected(old('status', $quotation->status)=='nego')>Nego</option>
                                <option value="accepted" @selected(old('status', $quotation->status)=='accepted')>Accepted</option>
                                <option value="rejected" @selected(old('status', $quotation->status)=='rejected')>Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-bar">
                        <button type="submit" class="btn btn-primary">Update Quotation</button>
                        <a href="{{ route('quotations.history', $quotation) }}" class="btn btn-warning">Lihat History</a>
                        <a href="{{ route('clients.show', $quotation->client_id) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
