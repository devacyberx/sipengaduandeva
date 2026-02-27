@extends('layouts.app')

@section('title', 'Pengaduan Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-list-check me-2"></i>Pengaduan Saya
        </h2>
        <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan Baru
        </a>
    </div>

    <!-- Status Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col">
                    <a href="{{ route('siswa.complaints.index') }}" 
                       class="btn btn-outline-primary w-100 {{ !request('status') ? 'active' : '' }}">
                        <i class="bi bi-list-ul me-1"></i>Semua
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('siswa.complaints.index') }}?status=menunggu" 
                       class="btn btn-outline-warning w-100 {{ request('status') == 'menunggu' ? 'active' : '' }}">
                        <i class="bi bi-clock me-1"></i>Menunggu
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('siswa.complaints.index') }}?status=diproses" 
                       class="btn btn-outline-info w-100 {{ request('status') == 'diproses' ? 'active' : '' }}">
                        <i class="bi bi-gear me-1"></i>Diproses
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('siswa.complaints.index') }}?status=selesai" 
                       class="btn btn-outline-success w-100 {{ request('status') == 'selesai' ? 'active' : '' }}">
                        <i class="bi bi-check-circle me-1"></i>Selesai
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('siswa.complaints.index') }}?status=ditolak" 
                       class="btn btn-outline-danger w-100 {{ request('status') == 'ditolak' ? 'active' : '' }}">
                        <i class="bi bi-x-circle me-1"></i>Ditolak
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="row">
        @forelse($complaints as $complaint)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-{{ $complaint->status_color }} shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center 
                           bg-{{ $complaint->status_color }} text-white">
                    <div>
                        <span class="badge bg-white text-{{ $complaint->status_color }}">
                            {{ $complaint->status_text }}
                        </span>
                    </div>
                    <small>{{ $complaint->created_at->format('d/m') }}</small>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ Str::limit($complaint->title, 50) }}</h5>
                    
                    <div class="mb-3">
                        <span class="badge" style="background-color: {{ $complaint->category->color }}">
                            {{ $complaint->category->name }}
                        </span>
                        @if($complaint->location)
                        <span class="badge bg-secondary">
                            <i class="bi bi-geo-alt me-1"></i>{{ $complaint->location }}
                        </span>
                        @endif
                    </div>
                    
                    <p class="card-text text-muted small">
                        {{ Str::limit($complaint->description, 100) }}
                    </p>
                    
                    @if($complaint->photo)
                    <div class="mb-3">
                        <div class="position-relative" style="height: 100px; overflow: hidden; border-radius: 4px;">
                            <img src="{{ Storage::url($complaint->photo) }}" 
                                 alt="Foto Bukti" 
                                 class="img-fluid w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 end-0 m-1">
                                <i class="bi bi-image text-white bg-dark bg-opacity-50 rounded p-1"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($complaint->latestFeedback)
                    <div class="alert alert-info p-2 small mb-0">
                        <strong><i class="bi bi-chat-left-text me-1"></i>Tanggapan Terakhir:</strong><br>
                        {{ Str::limit($complaint->latestFeedback->message, 60) }}
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('siswa.complaints.show', $complaint) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                        <small class="text-muted d-flex align-items-center">
                            <i class="bi bi-clock-history me-1"></i>
                            {{ $complaint->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3">Belum ada pengaduan</h4>
                    <p class="text-muted">
                        @if(request('status'))
                            Tidak ada pengaduan dengan status ini
                        @else
                            Mulai buat pengaduan pertama Anda
                        @endif
                    </p>
                    <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($complaints->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav>
            {{ $complaints->links() }}
        </nav>
    </div>
    @endif
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-outline-warning.active {
    background-color: #ffc107;
    color: #000;
    border-color: #ffc107;
}

.btn-outline-info.active {
    background-color: #0dcaf0;
    color: #fff;
    border-color: #0dcaf0;
}

.btn-outline-success.active {
    background-color: #198754;
    color: #fff;
    border-color: #198754;
}

.btn-outline-danger.active {
    background-color: #dc3545;
    color: #fff;
    border-color: #dc3545;
}

.btn-outline-primary.active {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}
</style>
@endsection