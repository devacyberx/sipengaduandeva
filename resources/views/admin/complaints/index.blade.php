@extends('layouts.app')

@section('title', 'Data Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-list-check me-2"></i>Data Pengaduan
        </h2>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.complaints.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                        <label class="form-label">Pencarian</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari judul/deskripsi..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-1 d-flex align-items-end">
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="card">
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Daftar Pengaduan
            </h5>
            <div class="text-muted">
                @if($complaints->total() > 0)
                    Menampilkan {{ $complaints->firstItem() }} - {{ $complaints->lastItem() }} dari {{ $complaints->total() }} data
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Judul Pengaduan</th>
                            <th>Pelapor</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#{{ str_pad($complaint->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-decoration-none">
                                    {{ Str::limit($complaint->title, 40) }}
                                </a>
                                @if($complaint->photo)
                                    <i class="bi bi-image text-primary ms-1"></i>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ $complaint->user->name }}</div>
                                <small class="text-muted">{{ $complaint->user->class }}</small>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $complaint->category->color }}">
                                    {{ $complaint->category->name }}
                                </span>
                            </td>
                            <td>
                                <div>{{ $complaint->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $complaint->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $complaint->status_color }} px-3 py-2">
                                    {{ $complaint->status_text }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                       class="btn btn-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#statusModal{{ $complaint->id }}"
                                            title="Ubah Status">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Status Modal -->
                        <div class="modal fade" id="statusModal{{ $complaint->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.complaints.status', $complaint) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Status Pengaduan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="menunggu" {{ $complaint->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="diproses" {{ $complaint->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="ditolak" {{ $complaint->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <h4 class="mt-3">Tidak ada data pengaduan</h4>
                                <p class="text-muted">Belum ada pengaduan yang dibuat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination dengan design yang diperbaiki -->
            @if($complaints->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <div class="text-muted">
                    @if($complaints->total() > 0)
                        Menampilkan {{ $complaints->firstItem() }} - {{ $complaints->lastItem() }} dari {{ $complaints->total() }} data
                    @else
                        Tidak ada data yang ditampilkan
                    @endif
                </div>
                
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if($complaints->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i> Sebelumnya
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $complaints->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i> Sebelumnya
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach($complaints->getUrlRange(1, $complaints->lastPage()) as $page => $url)
                            @if($page == $complaints->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($complaints->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $complaints->nextPageUrl() }}" rel="next">
                                    Selanjutnya <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    Selanjutnya <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
                
                <div class="text-muted">
                    Halaman {{ $complaints->currentPage() }} dari {{ $complaints->lastPage() }}
                </div>
            </div>
            @else
                @if($complaints->total() > 0)
                <div class="text-center mt-3 pt-3 border-top">
                    <span class="text-muted">
                        Menampilkan semua {{ $complaints->total() }} data
                    </span>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: var(--primary-color);
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
}

.page-link:hover {
    background-color: #e9ecef;
    color: var(--primary-hover);
}

.page-item:not(:first-child) .page-link {
    margin-left: -1px;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.card-header-custom {
    background-color: var(--primary-color);
    color: white;
    padding: 1rem 1.25rem;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}
</style>
@endsection