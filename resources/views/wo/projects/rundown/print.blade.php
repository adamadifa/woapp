<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rundown Acara - {{ $project->name }}</title>
    <style>
        body {
            font-family: 'Inter', BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: #1a1a1a;
            background-color: #fff;
            margin: 0;
            padding: 40px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 12px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        .meta-item strong {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .meta-item span {
            font-size: 13px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f1f1f1;
            border-bottom: 2px solid #ddd;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            text-align: left;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .time-col {
            font-weight: 700;
            font-family: monospace;
            font-size: 13px;
            white-space: nowrap;
            width: 120px;
        }
        .activity-col {
            font-weight: 600;
            font-size: 13px;
        }
        .pic-col {
            font-weight: 500;
            font-size: 12px;
            color: #444;
            width: 150px;
        }
        .notes-col {
            color: #555;
            font-size: 12px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        @media print {
            body {
                padding: 0;
                font-size: 12px;
            }
            .meta-grid {
                background-color: transparent;
                border: none;
                border-bottom: 1px solid #ddd;
                border-radius: 0;
                padding: 10px 0;
            }
            th {
                background-color: transparent;
                border-bottom: 2px solid #000;
            }
            td {
                border-bottom: 1px solid #ddd;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
        }
        .btn {
            background-color: #ec4899;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .btn:hover {
            background-color: #db2777;
        }
    </style>
</head>
<body>
    <div class="print-btn-bar no-print">
        <button onclick="window.print()" class="btn">Cetak Rundown / Simpan PDF</button>
    </div>

    <div class="header">
        <h1>Rundown & Susunan Acara</h1>
        <p>Wedding Project Event Timeline — WOApp Platform</p>
    </div>

    <div class="meta-grid">
        <div class="meta-item">
            <strong>Nama Event</strong>
            <span>{{ $project->name }}</span>
        </div>
        <div class="meta-item">
            <strong>Tanggal Wedding</strong>
            <span>{{ \Carbon\Carbon::parse($project->wedding_date)->translatedFormat('d F Y') }}</span>
        </div>
        <div class="meta-item">
            <strong>Lokasi / Venue</strong>
            <span>{{ $project->venue->name ?? 'Belum ditentukan' }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 100px;">Waktu</th>
                <th style="width: 250px;">Aktivitas / Acara</th>
                <th style="width: 150px;">PIC (Penanggung Jawab)</th>
                <th>Catatan / Perlengkapan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rundownItems as $item)
                <tr>
                    <td class="time-col">
                        {{ date('H:i', strtotime($item->time_start)) }} - {{ date('H:i', strtotime($item->time_end)) }}
                    </td>
                    <td class="activity-col">
                        {{ $item->activity }}
                    </td>
                    <td class="pic-col">
                        @if($item->pic)
                            <span style="background-color: #f3f4f6; padding: 2px 6px; border-radius: 4px; border: 1px solid #e5e7eb;">
                                {{ $item->pic }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="notes-col">
                        {{ $item->notes ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999; padding: 40px 0;">
                        Belum ada aktivitas rundown terdaftar untuk event ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem WOApp pada {{ date('d-m-Y H:i') }}.
    </div>

    <script>
        // Auto trigger print dialog on page load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
