@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-list-check me-2"></i>Detail Pengaduan
        </h2>
        <div>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Complaint Details -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">Informasi Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Judul Pengaduan</h6>
                            <h5>{{ $complaint->title }}</h5>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Status</h6>
                            <span class="badge bg-{{ $complaint->status_color }} px-3 py-2 fs-6">
                                {{ $complaint->status_text }}
                            </span>
                        </div>
                    </div>

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

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Tanggal Dilaporkan</h6>
                            <p>{{ $complaint->created_at->translatedFormat('l, d F Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Terakhir Diperbarui</h6>
                            <p>{{ $complaint->updated_at->translatedFormat('l, d F Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Photo Evidence -->
                    @if($complaint->photo)
                    <div class="mt-4">
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
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="card mt-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text me-2"></i>Tanggapan & Umpan Balik
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Add Feedback Form -->
                    <form action="{{ route('admin.complaints.feedback', $complaint) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Tambahkan Tanggapan</label>
                            <textarea name="message" id="feedback" rows="3" 
                                      class="form-control" 
                                      placeholder="Tulis tanggapan atau perkembangan perbaikan..." 
                                      required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Kirim Tanggapan
                            </button>
                        </div>
                    </form>

                    <!-- Feedback List -->
                    <h6 class="border-bottom pb-2 mb-3">Riwayat Tanggapan</h6>
                    @forelse($complaint->feedbacks as $feedback)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $feedback->admin->name }}</strong>
                                    <small class="text-muted ms-2">
                                        {{ $feedback->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    {{ $feedback->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <p class="mb-0">{{ $feedback->message }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-chat-square-text display-4 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada tanggapan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Complainant Info -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Informasi Pelapor
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person text-white fs-2"></i>
                        </div>
                        <h5 class="mt-3 mb-1">{{ $complaint->user->name }}</h5>
                        <p class="text-muted mb-0">{{ $complaint->user->class }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Email</span>
                            <span>{{ $complaint->user->email }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>No. Telepon</span>
                            <span>{{ $complaint->user->phone ?? '-' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Total Pengaduan</span>
                            <span>{{ $complaint->user->complaints->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>Aksi Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Status Update -->
                    <form action="{{ route('admin.complaints.status', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Ubah Status</label>
                            <select name="status" class="form-select" required>
                                <option value="menunggu" {{ $complaint->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $complaint->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $complaint->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i>Update Status
                        </button>
                    </form>

                    <!-- Fix Photo Upload -->
                    @if($complaint->status == 'diproses' || $complaint->status == 'selesai')
                    <hr>
                    <form action="{{ route('admin.complaints.fix-photo', $complaint) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Upload Foto Perbaikan</label>
                            <input type="file" name="fix_photo" class="form-control" accept="image/*">
                            <small class="text-muted">Foto bukti perbaikan yang telah dilakukan</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-upload me-1"></i>Upload Foto Perbaikan
                        </button>
                    </form>
                    @endif

                    <!-- Fix Photo Display -->
                    @if($complaint->fix_photo)
                    <hr>
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Foto Perbaikan</h6>
                        <img src="{{ Storage::url($complaint->fix_photo) }}" 
                             alt="Foto Perbaikan" 
                             class="img-fluid rounded border">
                        <div class="mt-2">
                            <a href="{{ Storage::url($complaint->fix_photo) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-zoom-in me-1"></i>Lihat Foto
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $complaint->status == 'selesai' ? 'completed' : 'active' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pengaduan Dibuat</h6>
                                <small class="text-muted">{{ $complaint->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        
                        @if($complaint->processed_at)
                        <div class="timeline-item {{ $complaint->status == 'selesai' ? 'completed' : 'active' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Mulai Diproses</h6>
                                <small class="text-muted">{{ $complaint->processed_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                        
                        @if($complaint->completed_at)
                        <div class="timeline-item completed">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Selesai</h6>
                                <small class="text-muted">{{ $complaint->completed_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
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
</style>
@endsection