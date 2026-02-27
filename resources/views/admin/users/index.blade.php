@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-people me-2"></i>Data Siswa
        </h2>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Tambah Siswa
            </a>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama, email, atau kelas..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header card-header-custom">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Daftar Siswa
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>No. Telepon</th>
                            <th>Total Pengaduan</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <strong>{{ $student->name }}</strong>
                                        @if($student->complaints->count() > 0)
                                        <div class="small text-muted">
                                            {{ $student->complaints->where('status', 'selesai')->count() }} selesai
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $student->class }}</span>
                            </td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $student->complaints->count() }}</span>
                            </td>
                            <td>{{ $student->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="#" class="btn btn-info" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#detailModal{{ $student->id }}"
                                       title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $student) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $student->id }}"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $student->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <div class="mb-3">
                                                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                         style="width: 100px; height: 100px;">
                                                        <i class="bi bi-person text-white fs-1"></i>
                                                    </div>
                                                </div>
                                                <h5>{{ $student->name }}</h5>
                                                <p class="text-muted">{{ $student->class }}</p>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">Email</h6>
                                                        <p>{{ $student->email }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">No. Telepon</h6>
                                                        <p>{{ $student->phone ?? '-' }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">Tanggal Daftar</h6>
                                                        <p>{{ $student->created_at->format('d F Y') }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="text-muted mb-1">Total Pengaduan</h6>
                                                        <p>{{ $student->complaints->count() }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-muted mb-2">Statistik Pengaduan</h6>
                                                        <div class="progress" style="height: 25px;">
                                                            @php
                                                                $total = $student->complaints->count();
                                                                $completed = $student->complaints->where('status', 'selesai')->count();
                                                                $pending = $student->complaints->where('status', 'menunggu')->count();
                                                                $processing = $student->complaints->where('status', 'diproses')->count();
                                                            @endphp
                                                            @if($total > 0)
                                                            <div class="progress-bar bg-success" 
                                                                 style="width: {{ ($completed/$total)*100 }}%"
                                                                 title="Selesai: {{ $completed }}">
                                                            </div>
                                                            <div class="progress-bar bg-primary" 
                                                                 style="width: {{ ($processing/$total)*100 }}%"
                                                                 title="Diproses: {{ $processing }}">
                                                            </div>
                                                            <div class="progress-bar bg-warning" 
                                                                 style="width: {{ ($pending/$total)*100 }}%"
                                                                 title="Menunggu: {{ $pending }}">
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="mt-2 small text-muted">
                                                            Selesai: {{ $completed }} | Diproses: {{ $processing }} | Menunggu: {{ $pending }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <a href="{{ route('admin.users.edit', $student) }}" class="btn btn-primary">
                                            <i class="bi bi-pencil me-1"></i>Edit Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data siswa <strong>{{ $student->name }}</strong>?</p>
                                        @if($student->complaints->count() > 0)
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            Siswa ini memiliki {{ $student->complaints->count() }} pengaduan. 
                                            Semua data pengaduan akan ikut terhapus!
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('admin.users.destroy', $student) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-people display-1 text-muted"></i>
                                <h4 class="mt-3">Belum ada data siswa</h4>
                                <p class="text-muted">Tambahkan siswa pertama Anda</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-person-plus me-1"></i>Tambah Siswa
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($students->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} dari {{ $students->total() }} siswa
                </div>
                <nav>
                    {{ $students->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection