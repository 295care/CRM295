<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Quotation Baru - CRM 295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.sidebar-styles')
    @include('partials.app-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Slim Select2 override */
        .select2-container .select2-selection--single {
            height: 40px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            display: flex;
            align-items: center;
            background: #f9fafb;
            padding: 0 10px;
        }
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #1a6b74;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26,107,116,0.1);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 10px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1f2937;
            font-size: 14px;
            line-height: 38px;
            padding-left: 4px;
        }
        .select2-container { width: 100% !important; }
        .select2-dropdown { border-color: #d1d5db; border-radius: 8px; font-size: 14px; }
        .select2-results__option--highlighted { background: #1a6b74 !important; }
    </style>
</head>
<body>
<div class="app-shell">
    @include('partials.sidebar')
    <main class="app-main">
        <div class="page-wrap" style="max-width: 840px;">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Buat Quotation Baru</h1>
                    <p class="page-subtitle">Isi detail penawaran untuk client yang dipilih.</p>
                </div>
                <a class="btn btn-secondary" href="{{ $selectedClientId ? route('clients.show', $selectedClientId) : route('quotations.index') }}">Kembali</a>
            </div>

            <div class="panel">
                <form method="POST" action="{{ route('quotations.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="client_id" class="form-label">Client</label>
                        @if($selectedClientId)
                            <input type="hidden" name="client_id" value="{{ $selectedClientId }}">
                            <select class="form-control select2-client" disabled>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" @selected($c->id == $selectedClientId)>{{ $c->nama }}@if($c->perusahaan) - {{ $c->perusahaan }}@endif</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control select2-client" name="client_id" required>
                                <option value="">-- Pilih Client --</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->nama }}@if($c->perusahaan) - {{ $c->perusahaan }}@endif</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="tanggal_penawaran" class="form-label">Tanggal Penawaran</label>
                            <input type="date" class="form-control" id="tanggal_penawaran" name="tanggal_penawaran" value="{{ old('tanggal_penawaran', date('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_projek" class="form-label">Jenis Projek</label>
                            <select class="form-control" id="nama_projek" name="nama_projek" required>
                                <option value="">-- Pilih Jenis Projek --</option>
                                <option value="CCTV"       @selected(old('nama_projek') == 'CCTV')>CCTV</option>
                                <option value="MCFA"       @selected(old('nama_projek') == 'MCFA')>MCFA</option>
                                <option value="Gate"       @selected(old('nama_projek') == 'Gate')>Gate</option>
                                <option value="Videotron"  @selected(old('nama_projek') == 'Videotron')>Videotron</option>
                                <option value="Smartboard" @selected(old('nama_projek') == 'Smartboard')>Smartboard</option>
                                <option value="Smarthome"  @selected(old('nama_projek') == 'Smarthome')>Smarthome</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nilai_penawaran" class="form-label">Nilai Penawaran</label>
                            <input type="number" class="form-control" id="nilai_penawaran" name="nilai_penawaran" value="{{ old('nilai_penawaran') }}" required min="0" placeholder="0">
                        </div>

                        <div class="form-group">
                            <label for="hpp" class="form-label">HPP</label>
                            <input type="number" class="form-control" id="hpp" name="hpp" value="{{ old('hpp') }}" required min="0" placeholder="0">
                        </div>

                        <div class="form-group field-full">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending"  @selected(old('status')=='pending')>Pending</option>
                                <option value="nego"     @selected(old('status')=='nego')>Nego</option>
                                <option value="accepted" @selected(old('status')=='accepted')>Accepted</option>
                                <option value="rejected" @selected(old('status')=='rejected')>Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-bar">
                        <button type="submit" class="btn btn-primary">Simpan Quotation</button>
                        <a href="{{ $selectedClientId ? route('clients.show', $selectedClientId) : route('quotations.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-client').select2({ placeholder: "-- Pilih Client --", allowClear: true });
    });
</script>
</body>
</html>
