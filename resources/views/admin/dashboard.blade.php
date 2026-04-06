@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Header dengan tanggal lengkap -->
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
    
    <!-- Statistik Cards - 4 Kotak seperti awal -->
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalComplaints ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-envelope-paper fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-success small">
                            <i class="bi bi-arrow-up"></i> {{ $monthlyIncrease ?? 0 }} Bulan ini
                        </span>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingComplaints ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.complaints.index', ['status' => 'menunggu']) }}" 
                           class="text-warning small">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $processingComplaints ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-repeat fs-2 text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.complaints.index', ['status' => 'diproses']) }}" 
                           class="text-info small">
                            Lihat semua <i class="bi bi-arrow-right"></i>
                        </a>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedComplaints ?? 0 }}</div>
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
                            {{ $percentage }}% selesai
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Row untuk konten bawah -->
    <div class="row">
        <!-- Recent Complaints -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-list-ul me-2"></i>Pengaduan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Siswa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentComplaints ?? [] as $complaint)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                           class="text-decoration-none">
                                            {{ Str::limit($complaint->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ $complaint->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'menunggu' => 'warning',
                                                'diproses' => 'info',
                                                'selesai' => 'success',
                                                'ditolak' => 'danger'
                                            ];
                                            $color = $statusColors[$complaint->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pengaduan</td>
                                </tr>
                                @endforelse
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
        
        <!-- Sidebar Statistics -->
        <div class="col-lg-4 mb-4">
            <!-- Status Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-pie-chart me-2"></i>Status Pengaduan
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $statuses = [
                            'menunggu' => ['count' => $pendingComplaints ?? 0, 'color' => 'warning', 'label' => 'Menunggu'],
                            'diproses' => ['count' => $processingComplaints ?? 0, 'color' => 'info', 'label' => 'Diproses'],
                            'selesai' => ['count' => $completedComplaints ?? 0, 'color' => 'success', 'label' => 'Selesai'],
                        ];
                        $total = array_sum(array_column($statuses, 'count'));
                    @endphp

                    @foreach($statuses as $status => $data)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ $data['label'] }}</span>
                            <span>{{ $data['count'] }} ({{ $total > 0 ? round(($data['count'] / $total) * 100) : 0 }}%)</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-{{ $data['color'] }}" 
                                 style="width: {{ $total > 0 ? ($data['count'] / $total) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Student Statistics -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-people me-2"></i>Data Siswa
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-gray-800">{{ $totalStudents ?? 0 }}</div>
                    <p class="text-muted mb-3">Total siswa terdaftar</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-people me-1"></i>Kelola Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan CSS untuk border-left yang hilang -->
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
</style>
@endsection