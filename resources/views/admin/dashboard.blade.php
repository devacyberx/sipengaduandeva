@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
        </h2>
        <div class="btn-group">
            <button class="btn btn-primary">
                <i class="bi bi-calendar me-1"></i>{{ now()->translatedFormat('d F Y') }}
            </button>
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
                        <span class="text-success">
                            <i class="bi bi-arrow-up me-1"></i>Bulan ini
                        </span>
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
                        <a href="{{ route('admin.complaints.index', ['status' => 'menunggu']) }}" 
                           class="text-warning text-decoration-none">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
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
                        <a href="{{ route('admin.complaints.index', ['status' => 'diproses']) }}" 
                           class="text-info text-decoration-none">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
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
    
    <div class="row">
        <!-- Recent Complaints -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>Pengaduan Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Siswa</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentComplaints as $complaint)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                           class="text-decoration-none">
                                            {{ Str::limit($complaint->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ $complaint->user->name }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $complaint->category->color }}">
                                            {{ $complaint->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->status_color }}">
                                            {{ $complaint->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary">
                            <i class="bi bi-list-check me-1"></i>Lihat Semua Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Statistik Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Status Pengaduan</h6>
                        <div class="progress" style="height: 30px;">
                            @php
                                $statuses = [
                                    'menunggu' => ['count' => $pendingComplaints, 'color' => 'warning'],
                                    'diproses' => ['count' => $processingComplaints, 'color' => 'info'],
                                    'selesai' => ['count' => $completedComplaints, 'color' => 'success'],
                                ];
                                $total = array_sum(array_column($statuses, 'count'));
                            @endphp
                            
                            @foreach($statuses as $status => $data)
                                @if($data['count'] > 0)
                                <div class="progress-bar bg-{{ $data['color'] }}" 
                                     style="width: {{ ($data['count'] / $total) * 100 }}%"
                                     title="{{ ucfirst($status) }}: {{ $data['count'] }}">
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="mt-2">
                            @foreach($statuses as $status => $data)
                            <div class="d-flex justify-content-between mb-1">
                                <span>
                                    <i class="bi bi-square-fill text-{{ $data['color'] }} me-1"></i>
                                    {{ ucfirst($status) }}
                                </span>
                                <span>{{ $data['count'] }} ({{ $total > 0 ? round(($data['count'] / $total) * 100, 1) : 0 }}%)</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <h6>Total Siswa</h6>
                        <div class="text-center py-4">
                            <div class="display-4 text-primary">{{ $totalStudents }}</div>
                            <p class="text-muted">Siswa terdaftar</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-people me-1"></i>Kelola Siswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection