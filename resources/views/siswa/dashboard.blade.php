@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard Siswa
        </h2>
        <div>
            <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan Baru
            </a>
        </div>
    </div>
    
    <!-- Welcome Card -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="card-title">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="card-text mb-0">
                        Gunakan sistem ini untuk melaporkan kerusakan atau masalah sarana sekolah.
                        Pastikan memberikan informasi yang jelas dan lampirkan foto bukti.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-megaphone display-4 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistik Cards - Menggunakan style seperti admin -->
    <div class="row mb-4">
        <!-- Card Total Pengaduan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TOTAL PENGADUAN
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalComplaints }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-envelope-paper fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('siswa.complaints.index') }}" 
                           class="text-primary small">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Menunggu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                MENUNGGU
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingComplaints }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-warning small">
                            <i class="bi bi-info-circle"></i> Menunggu verifikasi admin
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Diproses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                DIPROSES
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $processingComplaints }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-repeat fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-info small">
                            <i class="bi bi-tools"></i> Sedang dalam perbaikan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                SELESAI
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedComplaints }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check2-circle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        @php
                            $total = $totalComplaints ?? 0;
                            $percentage = $total > 0 ? round(($completedComplaints / $total) * 100) : 0;
                        @endphp
                        <span class="text-success small">
                            <i class="bi bi-pie-chart"></i> {{ $percentage }}% selesai
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Complaints -->
    <div class="card">
        <div class="card-header card-header-custom">
            <h5 class="mb-0">
                <i class="bi bi-clock-history me-2"></i>Pengaduan Terakhir
            </h5>
        </div>
        <div class="card-body">
            @if($recentComplaints->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentComplaints as $complaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::limit($complaint->title, 40) }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $complaint->category->color ?? '#6c757d' }}">
                                    {{ $complaint->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'menunggu' => 'warning',
                                        'diproses' => 'info',
                                        'selesai' => 'success',
                                        'ditolak' => 'danger'
                                    ];
                                    $color = $statusColors[$complaint->status] ?? 'secondary';
                                    $statusText = ucfirst($complaint->status);
                                @endphp
                                <span class="badge bg-{{ $color }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="mt-3">Belum ada pengaduan</h4>
                <p class="text-muted">Mulai buat pengaduan pertama Anda</p>
                <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Tambahkan CSS untuk border-left dan style lainnya -->
<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.text-xs {
    font-size: .7rem;
}
.no-gutters {
    margin-right: 0;
    margin-left: 0;
}
.no-gutters > .col,
.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}
.shadow {
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important;
}
.h-100 {
    height: 100% !important;
}
.py-2 {
    padding-top: .5rem !important;
    padding-bottom: .5rem !important;
}
/* Custom untuk card */
.card {
    border: none;
    border-radius: .35rem;
}
/* Style untuk tombol yang lebih kecil */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
}
.btn-sm i {
    font-size: 0.875rem;
}
</style>
@endsection