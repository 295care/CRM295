<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Activity - CRM295</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:12px; flex-wrap:wrap;">
            <h1 style="margin:0;">Edit Activity</h1>
            <a class="btn" href="{{ route('leads.show', $activity->lead_id) }}">Kembali ke Lead</a>
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
            <div style="margin-bottom:10px; color:#697065;">Lead: <strong>{{ $activity->lead?->nama_client }}</strong> · {{ $activity->lead?->perusahaan ?: 'Tanpa perusahaan' }}</div>

            <form id="delete-activity-form" method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Hapus activity ini?')">
                @csrf
                @method('DELETE')
            </form>

            <form method="POST" action="{{ route('activities.update', $activity) }}">
                @csrf
                @method('PUT')

                <label for="tanggal">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', optional($activity->tanggal)->format('Y-m-d')) }}" required>

                <label for="jenis">Jenis</label>
                <input id="jenis" type="text" name="jenis" value="{{ old('jenis', $activity->jenis) }}" required>

                <label for="catatan">Catatan</label>
                <textarea id="catatan" name="catatan" required>{{ old('catatan', $activity->catatan) }}</textarea>

                <label for="next_follow_up">Next Follow Up</label>
                <input id="next_follow_up" type="datetime-local" name="next_follow_up" value="{{ old('next_follow_up', $activity->next_follow_up ? optional($activity->next_follow_up)->format('Y-m-d\\TH:i') : '') }}">

                <div class="footer">
                    <button class="btn btn-danger" type="submit" form="delete-activity-form">Hapus</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
