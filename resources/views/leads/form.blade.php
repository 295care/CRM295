<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }} - CRM295</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f1eb;
            --panel: #fffdf8;
            --ink: #1f201d;
            --muted: #697065;
            --line: #d9ddce;
            --accent: #1d6f78;
            --danger: #cb4a35;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 10%, #e8f3ee 0, transparent 24%),
                radial-gradient(circle at 90% 0%, #f8dfc7 0, transparent 24%),
                var(--bg);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px 16px 40px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        h1 {
            margin: 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(22px, 4vw, 32px);
            letter-spacing: -0.02em;
        }

        .btn {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 14px;
            background: white;
            color: var(--ink);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #f5fffd;
            border-color: #175962;
        }

        .panel {
            background: color-mix(in srgb, var(--panel) 94%, #fff 6%);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 10px 20px rgba(30, 34, 28, 0.06);
        }

        .error-box {
            background: #ffe9e5;
            color: #832614;
            border: 1px solid #f8b9ab;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        label {
            font-size: 13px;
            color: var(--muted);
            font-weight: 700;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            background: #fff;
            font-family: inherit;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .footer {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        @media (min-width: 860px) {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid .full {
                grid-column: span 2;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>{{ $pageTitle }}</h1>
            <a class="btn" href="{{ isset($lead->id) ? route('leads.show', $lead) : route('leads.index') }}">Kembali</a>
        </div>

        <section class="panel">
            @if ($errors->any())
                <div class="error-box">
                    <strong>Periksa kembali input berikut:</strong>
                    <ul style="margin: 8px 0 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $formAction }}">
                @csrf
                @if ($formMethod !== 'POST')
                    @method($formMethod)
                @endif

                <div class="grid">
                    <div>
                        <label for="nama_client">Nama Client</label>
                        <input id="nama_client" type="text" name="nama_client" value="{{ old('nama_client', $lead->nama_client) }}" required>
                    </div>

                    <div>
                        <label for="perusahaan">Perusahaan</label>
                        <input id="perusahaan" type="text" name="perusahaan" value="{{ old('perusahaan', $lead->perusahaan) }}">
                    </div>

                    <div>
                        <label for="no_hp">No HP</label>
                        <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $lead->no_hp) }}" required>
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $lead->email) }}">
                    </div>

                    <div>
                        <label for="sumber_lead">Sumber Lead</label>
                        <input id="sumber_lead" type="text" name="sumber_lead" value="{{ old('sumber_lead', $lead->sumber_lead) }}" placeholder="referensi / IG / website">
                    </div>

                    <div>
                        <label for="assigned_to">Assigned To</label>
                        <select id="assigned_to" name="assigned_to" required>
                            <option value="">Pilih Sales</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) old('assigned_to', $lead->assigned_to) === (string) $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            @foreach (['Cold', 'Warm', 'Hot', 'Deal', 'Lost'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $lead->status) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="full">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat">{{ old('alamat', $lead->alamat) }}</textarea>
                    </div>

                    <div class="full">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes">{{ old('notes', $lead->notes) }}</textarea>
                    </div>
                </div>

                <div class="footer">
                    <a class="btn" href="{{ isset($lead->id) ? route('leads.show', $lead) : route('leads.index') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
