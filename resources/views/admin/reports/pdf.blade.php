<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengaduan - SIPENGADUAN</title>
    <style>
        @page {
            margin: 2cm 1cm;
            size: A4 landscape;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0d6efd;
            margin: 0 0 5px;
            font-size: 22pt;
            font-weight: bold;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 12pt;
            margin: 3px 0;
        }
        
        .header .date {
            color: #999;
            font-size: 10pt;
            margin-top: 5px;
        }
        
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #495057;
            font-size: 10pt;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-size: 12pt;
            font-weight: 500;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 9pt;
        }
        
        th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            padding: 8px 5px;
            border: 1px solid #0a58ca;
            text-align: center;
        }
        
        td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-align: center;
            min-width: 60px;
        }
        
        .badge-menunggu { background-color: #ffc107; color: #212529; }
        .badge-diproses { background-color: #0d6efd; }
        .badge-selesai { background-color: #198754; }
        .badge-ditolak { background-color: #dc3545; }
        
        .summary-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .summary-title {
            background: #0d6efd;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12pt;
            border-radius: 5px 5px 0 0;
        }
        
        .summary-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
            background: #f8f9fa;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #dee2e6;
        }
        
        .summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-label {
            font-weight: bold;
            color: #495057;
        }
        
        .summary-value {
            font-weight: 500;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 8pt;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            th {
                background-color: #0d6efd !important;
                color: white !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGADUAN SARANA SEKOLAH</h1>
        <div class="subtitle">Sistem Pengaduan Sarana Sekolah - SIPENGADUAN</div>
        <div class="date">Tanggal Cetak: {{ now()->format('d F Y H:i') }}</div>
    </div>

    @php
        $total = $reports->count();
        $completed = $reports->where('status', 'selesai')->count();
        $processing = $reports->where('status', 'diproses')->count();
        $pending = $reports->where('status', 'menunggu')->count();
        $rejected = $reports->where('status', 'ditolak')->count();
        
        $totalDays = 0;
        $completedCount = 0;
        foreach($reports as $report) {
            if($report->completed_at) {
                $days = \Carbon\Carbon::parse($report->created_at)->diffInDays(\Carbon\Carbon::parse($report->completed_at));
                $totalDays += $days;
                $completedCount++;
            }
        }
        $avgDays = $completedCount > 0 ? round($totalDays / $completedCount, 1) : 0;
    @endphp

    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Periode Laporan:</div>
                <div class="info-value">
                    @if(request('month') && request('year') && request('month') != 'all' && request('year') != 'all')
                        {{ DateTime::createFromFormat('!m', request('month'))->format('F') }} {{ request('year') }}
                    @elseif(request('year') && request('year') != 'all')
                        Tahun {{ request('year') }}
                    @elseif(request('month') && request('month') != 'all')
                        Bulan {{ DateTime::createFromFormat('!m', request('month'))->format('F') }}
                    @else
                        Semua Periode
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Pengaduan:</div>
                <div class="info-value">{{ $total }} Pengaduan</div>
            </div>
            <div class="info-item">
                <div class="info-label">Pengaduan Selesai:</div>
                <div class="info-value">{{ $completed }} ({{ $total > 0 ? round(($completed/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="info-item">
                <div class="info-label">Rata-rata Waktu:</div>
                <div class="info-value">{{ $avgDays }} Hari</div>
            </div>
            <div class="info-item">
                <div class="info-label">Menunggu:</div>
                <div class="info-value">{{ $pending }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Diproses:</div>
                <div class="info-value">{{ $processing }}</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pelapor</th>
                <th width="20%">Judul Pengaduan</th>
                <th width="12%">Kategori</th>
                <th width="10%">Status</th>
                <th width="12%">Lokasi</th>
                <th width="10%">Tgl Selesai</th>
                <th width="6%">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->title }}</td>
                <td>{{ $report->category->name }}</td>
                <td class="text-center">
                    @php
                        $statusClass = match($report->status) {
                            'menunggu' => 'badge-menunggu',
                            'diproses' => 'badge-diproses',
                            'selesai' => 'badge-selesai',
                            'ditolak' => 'badge-ditolak',
                            default => ''
                        };
                        $statusText = match($report->status) {
                            'menunggu' => 'Menunggu',
                            'diproses' => 'Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                            default => $report->status
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </td>
                <td>{{ $report->location ?? '-' }}</td>
                <td class="text-center">
                    @if($report->completed_at)
                        {{ \Carbon\Carbon::parse($report->completed_at)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if($report->completed_at)
                        {{ \Carbon\Carbon::parse($report->created_at)->diffInDays(\Carbon\Carbon::parse($report->completed_at)) }} hr
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 30px;">
                    <div style="font-size: 14pt; color: #999;">Tidak ada data pengaduan</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-section">
        <div class="summary-title">
            RINGKASAN STATISTIK
        </div>
        <div class="summary-content">
            <div>
                <div class="summary-item">
                    <span class="summary-label">Total Pengaduan:</span>
                    <span class="summary-value">{{ $total }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Menunggu:</span>
                    <span class="summary-value">{{ $pending }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Diproses:</span>
                    <span class="summary-value">{{ $processing }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Selesai:</span>
                    <span class="summary-value">{{ $completed }}</span>
                </div>
            </div>
            <div>
                <div class="summary-item">
                    <span class="summary-label">Ditolak:</span>
                    <span class="summary-value">{{ $rejected }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Rata-rata Waktu:</span>
                    <span class="summary-value">{{ $avgDays }} hari</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tingkat Selesai:</span>
                    <span class="summary-value">{{ $total > 0 ? round(($completed/$total)*100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div>Dicetak dari Sistem SIPENGADUAN</div>
        <div>Tanggal: {{ now()->format('d F Y H:i') }}</div>
        <div>Halaman 1 dari 1</div>
    </div>
</body>
</html>