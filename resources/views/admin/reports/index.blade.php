@extends('layouts.app')

@section('title', 'Laporan Pengaduan')

@section('content')
<div class="container-fluid">
    <!-- Header dengan tombol di bawah -->
    <div class="mb-4">
        <h2 class="h3 mb-2">
            <i class="bi bi-file-text me-2"></i>Laporan Pengaduan
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.print') }}?{{ http_build_query(request()->query()) }}" 
               class="btn btn-sm btn-primary" 
               target="_blank">
                <i class="bi bi-printer me-1"></i>Cetak Laporan
            </a>
            <!-- TOMBOL DOWNLOAD PDF DIHAPUS -->
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="month" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="year" class="form-select">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Total Pengaduan</h6>
                    <h2 class="display-4 text-primary">{{ $totalComplaints }}</h2>
                    <p class="text-muted">Dalam periode yang dipilih</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Pengaduan Selesai</h6>
                    <h2 class="display-4 text-success">{{ $completedComplaints }}</h2>
                    <p class="text-muted">{{ $completionRate }}% rate penyelesaian</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Rata-rata Waktu</h6>
                    <h2 class="display-4 text-info">
                        @php
                            $avgDays = 0;
                            if($completedComplaints > 0) {
                                $totalDays = 0;
                                foreach($reports as $report) {
                                    if($report->completed_at) {
                                        $days = $report->created_at->diffInDays($report->completed_at);
                                        $totalDays += $days;
                                    }
                                }
                                $avgDays = round($totalDays / $completedComplaints, 1);
                            }
                        @endphp
                        {{ $avgDays }}
                    </h2>
                    <p class="text-muted">Hari penyelesaian</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Data Laporan
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.print') }}?{{ http_build_query(request()->query()) }}" 
                   target="_blank" 
                   class="btn btn-sm btn-outline-light">
                    <i class="bi bi-printer me-1"></i>Print View
                </a>
                <!-- TOMBOL PDF DI CARD HEADER DIHAPUS -->
            </div>
        </div>
        <div class="card-body">
            @if($reports->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Judul Pengaduan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->created_at->format('d/m/Y') }}</td>
                            <td>{{ $report->user->name }}</td>
                            <td>{{ Str::limit($report->title, 30) }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $report->category->color }}">
                                    {{ $report->category->name }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'menunggu' => 'warning',
                                        'diproses' => 'info',
                                        'selesai' => 'success',
                                        'ditolak' => 'danger'
                                    ];
                                    $statusTexts = [
                                        'menunggu' => 'Menunggu',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$report->status] ?? 'secondary' }}">
                                    {{ $statusTexts[$report->status] ?? $report->status }}
                                </span>
                            </td>
                            <td>{{ $report->location ?? '-' }}</td>
                            <td>
                                @if($report->completed_at)
                                    {{ $report->completed_at->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($report->completed_at)
                                    {{ $report->created_at->diffForHumans($report->completed_at, true) }}
                                @else
                                    <span class="text-muted">Dalam proses</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Ringkasan Statistik</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-muted">Menunggu</h6>
                                    <h4>{{ $reports->where('status', 'menunggu')->count() }}</h4>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-muted">Diproses</h6>
                                    <h4>{{ $reports->where('status', 'diproses')->count() }}</h4>
                                </div>
                                <div class="col-6 mt-3">
                                    <h6 class="text-muted">Selesai</h6>
                                    <h4>{{ $reports->where('status', 'selesai')->count() }}</h4>
                                </div>
                                <div class="col-6 mt-3">
                                    <h6 class="text-muted">Ditolak</h6>
                                    <h4>{{ $reports->where('status', 'ditolak')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Kategori Terbanyak</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $categoryCounts = [];
                                foreach($reports as $report) {
                                    $categoryId = $report->category_id;
                                    if(!isset($categoryCounts[$categoryId])) {
                                        $categoryCounts[$categoryId] = [
                                            'name' => $report->category->name,
                                            'color' => $report->category->color,
                                            'count' => 0
                                        ];
                                    }
                                    $categoryCounts[$categoryId]['count']++;
                                }
                                arsort($categoryCounts);
                            @endphp
                            
                            @foreach(array_slice($categoryCounts, 0, 3) as $category)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <span class="badge me-2" style="background-color: {{ $category['color'] }}">&nbsp;</span>
                                        {{ $category['name'] }}
                                    </span>
                                    <span>{{ $category['count'] }} pengaduan</span>
                                </div>
                                <div class="progress mt-1" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ ($category['count'] / $totalComplaints) * 100 }}%; 
                                                background-color: {{ $category['color'] }}"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text display-1 text-muted"></i>
                <h4 class="mt-3">Tidak ada data laporan</h4>
                <p class="text-muted">Coba ubah filter pencarian Anda</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .navbar, .card-header-custom, .btn, .filter-card {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    table {
        font-size: 12px !important;
    }
}
</style>
@endsection