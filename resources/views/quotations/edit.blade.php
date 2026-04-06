<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Quotation - CRM295</title>
    <style>
        body { font-family: Manrope, sans-serif; margin: 0; background: #f3f1eb; color: #1f201d; }
        .container { max-width: 760px; margin: 0 auto; padding: 24px 16px 40px; }
        .panel { background: #fffdf8; border: 1px solid #d9ddce; border-radius: 14px; padding: 14px; }
        .btn { border: 1px solid #d9ddce; border-radius: 10px; padding: 9px 12px; text-decoration: none; color: #1f201d; background: #fff; font-weight: 700; }
        .btn-primary { background: #1d6f78; color: #f5fffd; border-color: #175962; }
        .btn-danger { background: #fff1ee; border-color: #f1c7bf; color: #982f1e; }
        label { display: block; margin-bottom: 6px; font-size: 12px; text-transform: uppercase; color: #697065; }
        input, select, textarea { width: 100%; border: 1px solid #d9ddce; border-radius: 10px; padding: 10px; margin-bottom: 10px; }
        .footer { display: flex; gap: 8px; justify-content: space-between; flex-wrap: wrap; }
        .grid { display: grid; gap: 10px; grid-template-columns: 1fr 1fr; }
        @media (max-width: 720px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:12px; flex-wrap:wrap;">
            <h1 style="margin:0;">Edit Quotation</h1>
            <a class="btn" href="{{ route('leads.show', $quotation->lead_id) }}">Kembali ke Lead</a>
        </div>

        @if ($errors->any())
            <div class="panel" style="border-color:#f8b9ab; background:#ffe9e5; color:#832614; margin-bottom:10px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="panel">
            <div style="margin-bottom:10px; color:#697065;">Lead: <strong>{{ $quotation->lead?->nama_client }}</strong> · {{ $quotation->lead?->perusahaan ?: 'Tanpa perusahaan' }}</div>

            <form id="delete-quotation-form" method="POST" action="{{ route('quotations.destroy', $quotation) }}" onsubmit="return confirm('Hapus quotation ini?')">
                @csrf
                @method('DELETE')
            </form>

            <form method="POST" action="{{ route('quotations.update', $quotation) }}">
                @csrf
                @method('PUT')

                <div class="grid">
                    <div>
                        <label for="tanggal_penawaran">Tanggal Penawaran</label>
                        <input id="tanggal_penawaran" type="date" name="tanggal_penawaran" value="{{ old('tanggal_penawaran', optional($quotation->tanggal_penawaran)->format('Y-m-d')) }}" required>
                    </div>
                    <div>
                        <label for="nomor_penawaran">Nomor Penawaran</label>
                        <input id="nomor_penawaran" type="text" name="nomor_penawaran" value="{{ old('nomor_penawaran', $quotation->nomor_penawaran) }}">
                    </div>
                    <div>
                        <label for="nilai_penawaran">Nilai Penawaran</label>
                        <input id="nilai_penawaran" type="number" min="0" step="0.01" name="nilai_penawaran" value="{{ old('nilai_penawaran', $quotation->nilai_penawaran) }}" required>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            @foreach (['pending', 'nego', 'accepted', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $quotation->status) === $status)>{{ strtoupper($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan">{{ old('keterangan', $quotation->keterangan) }}</textarea>

                <div class="footer">
                    <button class="btn btn-danger" type="submit" form="delete-quotation-form">Hapus</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
