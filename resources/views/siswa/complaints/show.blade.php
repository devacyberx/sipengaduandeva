@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-list-check me-2"></i>Detail Pengaduan
        </h2>
        <div>
            <a href="{{ route('siswa.complaints.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Complaint Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center 
                           bg-{{ $complaint->status_color }} text-white">
                    <h5 class="mb-0">{{ $complaint->title }}</h5>
                    <span class="badge bg-white text-{{ $complaint->status_color }} px-3 py-2">
                        {{ $complaint->status_text }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Kategori</h6>
                            <span class="badge px-3 py-2" style="background-color: {{ $complaint->category->color }}">
                                {{ $complaint->category->name }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Lokasi</h6>
                            <p class="mb-0">{{ $complaint->location ?? 'Tidak ditentukan' }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Deskripsi Lengkap</h6>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($complaint->description)) !!}
                        </div>
                    </div>

                    <!-- Photo Evidence -->
                    @if($complaint->photo)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Foto Bukti</h6>
                        <div class="border rounded p-3">
                            <img src="{{ Storage::url($complaint->photo) }}" 
                                 alt="Foto Bukti" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px;">
                            <div class="mt-2">
                                <a href="{{ Storage::url($complaint->photo) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-zoom-in me-1"></i>Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Fix Photo Evidence -->
                    @if($complaint->fix_photo)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Foto Perbaikan</h6>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Perbaikan telah dilakukan dan telah di dokumentasikan
                        </div>
                        <div class="border rounded p-3">
                            <img src="{{ Storage::url($complaint->fix_photo) }}" 
                                 alt="Foto Perbaikan" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px;">
                            <div class="mt-2">
                                <a href="{{ Storage::url($complaint->fix_photo) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-success">
                                    <i class="bi bi-zoom-in me-1"></i>Lihat Foto Perbaikan
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Timeline -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Timeline Pengaduan</h6>
                        <div class="timeline">
                            <div class="timeline-item {{ $complaint->status == 'selesai' ? 'completed' : 'active' }}">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Pengaduan Dibuat</h6>
                                    <small class="text-muted">{{ $complaint->created_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 mt-1 small">Anda membuat pengaduan ini</p>
                                </div>
                            </div>
                            
                            @if($complaint->processed_at)
                            <div class="timeline-item {{ $complaint->status == 'selesai' ? 'completed' : 'active' }}">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Mulai Diproses</h6>
                                    <small class="text-muted">{{ $complaint->processed_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 mt-1 small">Admin mulai menangani pengaduan</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($complaint->completed_at)
                            <div class="timeline-item completed">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Selesai</h6>
                                    <small class="text-muted">{{ $complaint->completed_at->format('d/m/Y H:i') }}</small>
                                    <p class="mb-0 mt-1 small">Pengaduan telah selesai ditangani</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Dibuat pada:</small>
                            <div>{{ $complaint->created_at->format('d F Y H:i') }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Terakhir diperbarui:</small>
                            <div>{{ $complaint->updated_at->format('d F Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text me-2"></i>Tanggapan Admin
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($complaint->feedbacks as $feedback)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 30px; height: 30px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $feedback->admin->name }}</strong>
                                            <div class="small text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $feedback->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $feedback->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="border-start border-3 border-primary ps-3 mt-2">
                                <p class="mb-0">{{ $feedback->message }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-chat-square-text display-4 text-muted"></i>
                        <h4 class="mt-3">Belum ada tanggapan</h4>
                        <p class="text-muted">Admin belum memberikan tanggapan untuk pengaduan ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Status Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="status-icon mb-3">
                            @if($complaint->status == 'menunggu')
                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-clock text-white fs-2"></i>
                            </div>
                            <h5 class="mt-3 mb-1">Menunggu</h5>
                            <p class="text-muted">Pengaduan sedang menunggu verifikasi admin</p>
                            @elseif($complaint->status == 'diproses')
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-gear text-white fs-2"></i>
                            </div>
                            <h5 class="mt-3 mb-1">Diproses</h5>
                            <p class="text-muted">Pengaduan sedang ditangani oleh tim</p>
                            @elseif($complaint->status == 'selesai')
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-check-circle text-white fs-2"></i>
                            </div>
                            <h5 class="mt-3 mb-1">Selesai</h5>
                            <p class="text-muted">Pengaduan telah selesai ditangani</p>
                            @elseif($complaint->status == 'ditolak')
                            <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-x-circle text-white fs-2"></i>
                            </div>
                            <h5 class="mt-3 mb-1">Ditolak</h5>
                            <p class="text-muted">Pengaduan ditolak oleh admin</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Duration -->
                    @if($complaint->status == 'selesai' && $complaint->completed_at)
                    <div class="alert alert-success">
                        <div class="d-flex justify-content-between">
                            <span>Waktu Penyelesaian:</span>
                            <strong>{{ $complaint->created_at->diffForHumans($complaint->completed_at, true) }}</strong>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status Timeline -->
                    <div class="status-timeline">
                        <div class="status-step {{ $complaint->created_at ? 'completed' : '' }}">
                            <div class="status-step-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="status-step-content">
                                <div class="status-step-title">Dibuat</div>
                                <div class="status-step-time">{{ $complaint->created_at->format('d/m H:i') }}</div>
                            </div>
                        </div>
                        
                        <div class="status-step {{ $complaint->processed_at ? 'completed' : '' }}">
                            <div class="status-step-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div class="status-step-content">
                                <div class="status-step-title">Diproses</div>
                                <div class="status-step-time">
                                    @if($complaint->processed_at)
                                        {{ $complaint->processed_at->format('d/m H:i') }}
                                    @else
                                        Menunggu
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="status-step {{ $complaint->completed_at ? 'completed' : '' }}">
                            <div class="status-step-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="status-step-content">
                                <div class="status-step-title">Selesai</div>
                                <div class="status-step-time">
                                    @if($complaint->completed_at)
                                        {{ $complaint->completed_at->format('d/m H:i') }}
                                    @else
                                        Dalam proses
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Info -->
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-card-checklist me-2"></i>Informasi Terkait
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>ID Pengaduan</span>
                            <span class="text-muted">#{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Pelapor</span>
                            <span>{{ $complaint->user->name }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Kelas</span>
                            <span>{{ $complaint->user->class }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Admin Penanggung Jawab</span>
                            <span>
                                @if($complaint->feedbacks->count() > 0)
                                    {{ $complaint->feedbacks->first()->admin->name }}
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Jumlah Tanggapan</span>
                            <span class="badge bg-primary">{{ $complaint->feedbacks->count() }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    @if($complaint->status == 'menunggu')
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Pengaduan Anda sedang dalam antrian. Admin akan segera meninjau.
                    </div>
                    @elseif($complaint->status == 'diproses')
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Pengaduan sedang ditangani. Pantau perkembangan melalui tanggapan admin.
                    </div>
                    @elseif($complaint->status == 'selesai')
                    <div class="alert alert-success mt-3">
                        <i class="bi bi-check-circle me-2"></i>
                        Pengaduan telah selesai. Terima kasih atas laporan Anda.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: 2px solid white;
}

.timeline-item.active .timeline-marker {
    background-color: var(--primary-color);
}

.timeline-item.completed .timeline-marker {
    background-color: #198754;
}

.status-timeline {
    position: relative;
    padding-left: 40px;
}

.status-timeline::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.status-step {
    position: relative;
    margin-bottom: 20px;
    min-height: 40px;
}

.status-step.completed .status-step-icon {
    background-color: #198754;
    color: white;
}

.status-step-icon {
    position: absolute;
    left: -40px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #dee2e6;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
}

.status-step-content {
    padding-top: 8px;
}

.status-step-title {
    font-weight: 600;
    color: #495057;
}

.status-step-time {
    font-size: 12px;
    color: #6c757d;
}
</style>
@endsection