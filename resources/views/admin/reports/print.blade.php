<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan - SIPENGADUAN</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0d6efd;
            margin: 0;
            font-size: 24px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11px;
        }
        
        th {
            background-color: #0d6efd;
            color: white;
            text-align: left;
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .summary {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #f8f9fa;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .mb-2 {
            margin-bottom: 8px;
        }
        
        .mb-3 {
            margin-bottom: 12px;
        }
        
        .mb-4 {
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGADUAN SARANA SEKOLAH</h1>
        <div class="subtitle">Sistem Pengaduan Sarana Sekolah - SIPENGADUAN</div>
        <div class="subtitle">Tanggal Cetak: {{ now()->format('d F Y H:i') }}</div>
    </div>

    @php
        $total = $reports->count();
        $completed = $reports->where('status', 'selesai')->count();
        $processing = $reports->where('status', 'diproses')->count();
        $pending = $reports->where('status', 'menunggu')->count();
        $rejected = $reports->where('status', 'ditolak')->count();
        
        // Calculate average completion time
        $totalDays = 0;
        $completedCount = 0;
        foreach($reports as $report) {
            if($report->completed_at) {
                $days = $report->created_at->diffInDays($report->completed_at);
                $totalDays += $days;
                $completedCount++;
            }
        }
        $avgDays = $completedCount > 0 ? round($totalDays / $completedCount, 1) : 0;
    @endphp

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Periode Laporan:</div>
            <div>
                @if(request('month') && request('year'))
                    {{ DateTime::createFromFormat('!m', request('month'))->format('F') }} {{ request('year') }}
                @elseif(request('year'))
                    Tahun {{ request('year') }}
                @elseif(request('month'))
                    Bulan {{ DateTime::createFromFormat('!m', request('month'))->format('F') }}
                @else
                    Semua Periode
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Total Pengaduan:</div>
            <div>{{ $total }} Pengaduan</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status Selesai:</div>
            <div>{{ $completed }} ({{ $total > 0 ? round(($completed/$total)*100, 1) : 0 }}%)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Rata-rata Waktu:</div>
            <div>{{ $avgDays }} Hari</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pelapor</th>
                <th width="20%">Judul Pengaduan</th>
                <th width="12%">Kategori</th>
                <th width="10%">Status</th>
                <th width="10%">Lokasi</th>
                <th width="10%">Tanggal Selesai</th>
                <th width="8%">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->title }}</td>
                <td>{{ $report->category->name }}</td>
                <td>
                    @php
                        $statusColors = [
                            'menunggu' => '#ffc107',
                            'diproses' => '#0d6efd',
                            'selesai' => '#198754',
                            'ditolak' => '#dc3545'
                        ];
                    @endphp
                    <span class="badge" style="background-color: {{ $statusColors[$report->status] }}; color: white;">
                        {{ ucfirst($report->status) }}
                    </span>
                </td>
                <td>{{ $report->location ?? '-' }}</td>
                <td>
                    @if($report->completed_at)
                        {{ $report->completed_at->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if($report->completed_at)
                        {{ $report->created_at->diffInDays($report->completed_at) }} hari
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3 style="color: #0d6efd; margin-top: 0;">Ringkasan Statistik</h3>
        
        <div class="summary-row">
            <span>Total Pengaduan:</span>
            <span><strong>{{ $total }}</strong> Pengaduan</span>
        </div>
        
        <div class="summary-row">
            <span>Status Menunggu:</span>
            <span>{{ $pending }} ({{ $total > 0 ? round(($pending/$total)*100, 1) : 0 }}%)</span>
        </div>
        
        <div class="summary-row">
            <span>Status Diproses:</span>
            <span>{{ $processing }} ({{ $total > 0 ? round(($processing/$total)*100, 1) : 0 }}%)</span>
        </div>
        
        <div class="summary-row">
            <span>Status Selesai:</span>
            <span>{{ $completed }} ({{ $total > 0 ? round(($completed/$total)*100, 1) : 0 }}%)</span>
        </div>
        
        <div class="summary-row">
            <span>Status Ditolak:</span>
            <span>{{ $rejected }} ({{ $total > 0 ? round(($rejected/$total)*100, 1) : 0 }}%)</span>
        </div>
        
        <div class="summary-row">
            <span>Rata-rata Waktu Penyelesaian:</span>
            <span><strong>{{ $avgDays }}</strong> Hari</span>
        </div>
    </div>

    <div class="footer">
        <div>Dicetak dari Sistem SIPENGADUAN</div>
        <div>Tanggal: {{ now()->format('d F Y H:i') }}</div>
        <div>Halaman 1 dari 1</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>