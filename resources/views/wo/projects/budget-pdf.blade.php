<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Report - {{ $project->name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 40px;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            margin: 0 0 5px 0;
            color: #0f172a;
        }
        .header p {
            margin: 0;
            color: #64748b;
        }
        .meta-grid {
            display: grid;
            grid-template-cols: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .meta-card h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin: 0 0 5px 0;
        }
        .meta-card p {
            font-size: 13px;
            font-weight: bold;
            margin: 0;
            color: #1e293b;
        }
        .summary-grid {
            display: grid;
            grid-template-cols: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .summary-box .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 5px;
            display: block;
        }
        .summary-box .value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }
        .summary-box.highlight .value {
            color: #ec4899;
        }
        .summary-box.success .value {
            color: #10b981;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
            font-size: 10px;
            text-transform: uppercase;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-dp { background-color: #e0e7ff; color: #3730a3; }
        .status-unpaid { background-color: #f1f5f9; color: #374151; }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Printable Header -->
    <div class="header">
        <div style="float: right;" class="no-print">
            <button onclick="window.print()" style="background-color: #ec4899; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 11px;">Cetak PDF</button>
        </div>
        <h1>Laporan Rincian Budget Pernikahan</h1>
        <p>Project: {{ $project->name }}</p>
    </div>

    <!-- Metadata Info -->
    <div class="meta-grid">
        <div class="meta-card">
            <h3>Nama Klien / Mempelai</h3>
            <p>{{ $project->client->groom_name }} & {{ $project->client->bride_name }}</p>
        </div>
        <div class="meta-card">
            <h3>Tanggal Pernikahan & Lokasi</h3>
            <p>{{ date('d M Y', strtotime($project->wedding_date)) }} - {{ $project->venue->name ?? 'Belum Ditentukan' }}</p>
        </div>
    </div>

    <!-- Summaries -->
    <div class="summary-grid">
        <div class="summary-box">
            <span class="label">Target Budget</span>
            <span class="value">Rp{{ number_format($project->total_budget, 0, ',', '.') }}</span>
        </div>
        <div class="summary-box highlight">
            <span class="label">Teralokasi (Estimasi)</span>
            <span class="value">Rp{{ number_format($allocatedBudget, 0, ',', '.') }}</span>
        </div>
        <div class="summary-box success">
            <span class="label">Realisasi Cost</span>
            <span class="value">Rp{{ number_format($actualCost, 0, ',', '.') }}</span>
        </div>
        <div class="summary-box">
            <span class="label">Sisa Target Budget</span>
            <span class="value" style="{{ $remainingTarget < 0 ? 'color: #ef4444;' : '' }}">
                @if($remainingTarget < 0)
                    Over Rp{{ number_format(abs($remainingTarget), 0, ',', '.') }}
                @else
                    Rp{{ number_format($remainingTarget, 0, ',', '.') }}
                @endif
            </span>
        </div>
    </div>

    <!-- Details Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 20%;">Vendor</th>
                <th style="width: 30%;">Keterangan</th>
                <th style="width: 15%;">Estimasi Cost</th>
                <th style="width: 15%;">Realisasi Cost</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($budgetItems as $item)
                <tr>
                    <td style="font-weight: bold; color: #ec4899;">{{ $item->category }}</td>
                    <td>{{ $item->vendor->name ?? '-' }}</td>
                    <td style="color: #64748b;">{{ $item->description ?? '-' }}</td>
                    <td>Rp{{ number_format($item->estimated_cost, 0, ',', '.') }}</td>
                    <td style="font-weight: bold;">Rp{{ number_format($item->actual_cost, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-badge 
                            @if($item->payment_status === 'paid') status-paid
                            @elseif($item->payment_status === 'dp') status-dp
                            @else status-unpaid @endif">
                            {{ $item->payment_status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada item budget terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dibuat otomatis oleh sistem WOApp pada {{ date('d M Y, H:i') }}
    </div>

    <!-- Auto Print Script -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
