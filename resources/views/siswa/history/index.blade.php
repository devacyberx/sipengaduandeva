@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-clock-history me-2"></i>Riwayat Pengaduan
        </h2>
        <div>
            <a href="{{ route('siswa.complaints.index') }}" class="btn btn-primary">
                <i class="bi bi-list-check me-1"></i>Pengaduan Aktif
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Total Pengaduan</h6>
                    <h2 class="display-6 text-primary">{{ $complaints->count() }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Selesai</h6>
                    <h2 class="display-6 text-success">{{ $complaints->where('status', 'selesai')->count() }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Dalam Proses</h6>
                    <h2 class="display-6 text-warning">{{ $complaints->where('status', 'diproses')->count() + $complaints->where('status', 'menunggu')->count() }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-muted">Ditolak</h6>
                    <h2 class="display-6 text-danger">{{ $complaints->where('status', 'ditolak')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline View -->
    <div class="card mb-4">
        <div class="card-header card-header-custom">
            <h5 class="mb-0">
                <i class="bi bi-calendar-timeline me-2"></i>Timeline Pengaduan
            </h5>
        </div>
        <div class="card-body">
            <div class="timeline-container">
                @php
                    $complaintsByMonth = $complaints->groupBy(function($item) {
                        return $item->created_at->format('Y-m');
                    });
                @endphp
                
                @foreach($complaintsByMonth as $month => $monthComplaints)
                <div class="timeline-month">
                    <h5 class="timeline-month-title">
                        {{ DateTime::createFromFormat('!Y-m', $month)->format('F Y') }}
                    </h5>
                    
                    <div class="timeline-items">
                        @foreach($monthComplaints as $complaint)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                <div class="timeline-day">{{ $complaint->created_at->format('d') }}</div>
                                <div class="timeline-month">{{ $complaint->created_at->format('M') }}</div>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <h6 class="timeline-title">
                                        <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                                           class="text-decoration-none">
                                            {{ $complaint->title }}
                                        </a>
                                    </h6>
                                    <span class="timeline-status badge bg-{{ $complaint->status_color }}">
                                        {{ $complaint->status_text }}
                                    </span>
                                </div>
                                <div class="timeline-body">
                                    <p class="mb-2 text-muted small">
                                        {{ Str::limit($complaint->description, 100) }}
                                    </p>
                                    <div class="timeline-meta">
                                        <span class="timeline-category badge" 
                                              style="background-color: {{ $complaint->category->color }}">
                                            {{ $complaint->category->name }}
                                        </span>
                                        @if($complaint->location)
                                        <span class="timeline-location text-muted">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $complaint->location }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="timeline-footer">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $complaint->created_at->diffForHumans() }}
                                    </small>
                                    <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                @if($complaints->count() == 0)
                <div class="text-center py-5">
                    <i class="bi bi-clock-history display-1 text-muted"></i>
                    <h4 class="mt-3">Belum ada riwayat pengaduan</h4>
                    <p class="text-muted">Anda belum membuat pengaduan apapun</p>
                    <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Table View (Alternative) -->
    <div class="card">
        <div class="card-header card-header-custom">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Tabel Riwayat
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Pengaduan</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>Tanggapan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                                   class="text-decoration-none">
                                    {{ Str::limit($complaint->title, 40) }}
                                </a>
                                @if($complaint->photo)
                                    <i class="bi bi-image text-primary ms-1"></i>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $complaint->category->color }}">
                                    {{ $complaint->category->name }}
                                </span>
                            </td>
                            <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $complaint->status_color }}">
                                    {{ $complaint->status_text }}
                                </span>
                            </td>
                            <td>{{ $complaint->location ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $complaint->feedbacks->count() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-table display-1 text-muted"></i>
                                <h4 class="mt-3">Tidak ada data</h4>
                                <p class="text-muted">Belum ada riwayat pengaduan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-container {
    max-width: 800px;
    margin: 0 auto;
}

.timeline-month {
    margin-bottom: 40px;
}

.timeline-month-title {
    color: var(--primary-color);
    padding-bottom: 10px;
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 20px;
}

.timeline-items {
    position: relative;
    padding-left: 100px;
}

.timeline-items::before {
    content: '';
    position: absolute;
    left: 50px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-date {
    position: absolute;
    left: -100px;
    width: 70px;
    text-align: center;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 8px;
}

.timeline-day {
    font-size: 24px;
    font-weight: bold;
    color: var(--primary-color);
    line-height: 1;
}

.timeline-month {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
}

.timeline-content {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.timeline-content:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.timeline-title {
    margin: 0;
    font-size: 16px;
    flex: 1;
}

.timeline-body {
    margin-bottom: 10px;
}

.timeline-meta {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.timeline-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}
</style>
@endsection