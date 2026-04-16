<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Client {{ $client->nama }} - CRM 295</title>
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
                    <h1 class="page-title">Edit Client</h1>
                    <p class="page-subtitle">{{ $client->nama }} &mdash; Perbarui data client agar tetap akurat.</p>
                </div>
                <a class="btn btn-secondary" href="{{ route('clients.show', $client) }}">Kembali</a>
            </div>

            <div class="panel">
                <form method="POST" action="{{ route('clients.update', $client) }}">
                    @csrf
                    @method('PUT')

                    @php
                       $isCustomBusiness = !in_array($client->jenis_bisnis, $businessTypeOptions) && !empty($client->jenis_bisnis);
                       $selectedBusinessType = old('jenis_bisnis', $isCustomBusiness ? $customBusinessTypeValue : $client->jenis_bisnis);
                       $customBusinessValue = old('jenis_bisnis_custom', $isCustomBusiness ? $client->jenis_bisnis : '');
                    @endphp

                    <div class="form-grid">
                        <div class="form-group field-full">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" id="nama" type="text" name="nama" value="{{ old('nama', $client->nama) }}" required>
                            @error('nama') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="perusahaan">Perusahaan</label>
                            <input class="form-control" id="perusahaan" type="text" name="perusahaan" value="{{ old('perusahaan', $client->perusahaan) }}">
                            @error('perusahaan') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="nomor_wa">Nomor WA</label>
                            <input class="form-control" id="nomor_wa" type="text" name="nomor_wa" value="{{ old('nomor_wa', $client->nomor_wa) }}" required>
                            @error('nomor_wa') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group field-full">
                            <label class="form-label" for="sumber_client">Sumber Client</label>
                            <select class="form-control" id="sumber_client" name="sumber_client" required>
                                <option value="">Pilih sumber client</option>
                                @foreach ($sumberClientOptions as $sumberClient)
                                    <option value="{{ $sumberClient }}" @selected(old('sumber_client', $client->sumber_client) === $sumberClient)>{{ ucfirst($sumberClient) }}</option>
                                @endforeach
                            </select>
                            @error('sumber_client') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group field-full">
                            <label class="form-label" for="jenis_bisnis">Jenis Bisnis</label>
                            <select class="form-control" id="jenis_bisnis" name="jenis_bisnis" required>
                                <option value="">Pilih jenis bisnis</option>
                                @foreach ($businessTypeOptions as $businessType)
                                    <option value="{{ $businessType }}" @selected($selectedBusinessType === $businessType)>{{ ucfirst($businessType) }}</option>
                                @endforeach
                                <option value="{{ $customBusinessTypeValue }}" @selected($selectedBusinessType === $customBusinessTypeValue)>Ketik sendiri</option>
                            </select>
                            @error('jenis_bisnis') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group field-full" id="jenis_bisnis_custom_wrapper" style="display:none;">
                            <label class="form-label" for="jenis_bisnis_custom">Ketik Jenis Bisnis</label>
                            <input class="form-control" id="jenis_bisnis_custom" type="text" name="jenis_bisnis_custom" value="{{ $customBusinessValue }}" placeholder="Contoh: kesehatan, retail, manufaktur">
                            @error('jenis_bisnis_custom') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="action-bar">
                        <button class="btn btn-primary" type="submit">Update Client</button>
                        <a class="btn btn-secondary" href="{{ route('clients.show', $client) }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script>
    (() => {
        const jenisBisnisSelect = document.getElementById('jenis_bisnis');
        const customWrapper = document.getElementById('jenis_bisnis_custom_wrapper');
        const customInput = document.getElementById('jenis_bisnis_custom');
        const customOptionValue = @json($customBusinessTypeValue);

        if (!jenisBisnisSelect || !customWrapper || !customInput) return;

        const syncCustomField = () => {
            const isCustom = jenisBisnisSelect.value === customOptionValue;
            customWrapper.style.display = isCustom ? 'block' : 'none';
            customInput.required = isCustom;
            if (!isCustom) customInput.value = '';
        };

        jenisBisnisSelect.addEventListener('change', syncCustomField);
        syncCustomField();
    })();
</script>
</body>
</html>
