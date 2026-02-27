@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard Siswa
        </h2>
        <div>
            <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary">
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
    
    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Total Pengaduan</h6>
                            <h2 class="mb-0">{{ $totalComplaints }}</h2>
                        </div>
                        <div class="bg-primary rounded-circle p-3">
                            <i class="bi bi-list-check text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('siswa.complaints.index') }}" 
                           class="text-primary text-decoration-none">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Menunggu</h6>
                            <h2 class="mb-0">{{ $pendingComplaints }}</h2>
                        </div>
                        <div class="bg-warning rounded-circle p-3">
                            <i class="bi bi-clock text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-warning">
                            Menunggu verifikasi admin
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Diproses</h6>
                            <h2 class="mb-0">{{ $processingComplaints }}</h2>
                        </div>
                        <div class="bg-info rounded-circle p-3">
                            <i class="bi bi-gear text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-info">
                            Sedang dalam perbaikan
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Selesai</h6>
                            <h2 class="mb-0">{{ $completedComplaints }}</h2>
                        </div>
                        <div class="bg-success rounded-circle p-3">
                            <i class="bi bi-check-circle text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success">
                            {{ $totalComplaints > 0 ? round(($completedComplaints / $totalComplaints) * 100, 1) : 0 }}% selesai
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
@endsection