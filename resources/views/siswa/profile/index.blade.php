@extends('layouts.app')

@section('title', 'Profil Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-person-circle me-2"></i>Profil Siswa
        </h2>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profile.index') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="avatar-preview mb-3">
                                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                         style="width: 100px; height: 100px;">
                                        <i class="bi bi-person text-white fs-1"></i>
                                    </div>
                                </div>
                                <small class="text-muted">Siswa</small>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="class" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('class') is-invalid @enderror" 
                                               id="class" name="class" value="{{ old('class', auth()->user()->class) }}" 
                                               required>
                                        @error('class')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Update Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-key me-2"></i>Ganti Password
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showPasswordCheck">
                                <label class="form-check-label" for="showPasswordCheck">
                                    Tampilkan password
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Password harus minimal 8 karakter dan mengandung kombinasi huruf dan angka.
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Account Summary -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Statistik Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Total Pengaduan</span>
                            <span class="badge bg-primary">{{ auth()->user()->complaints->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Pengaduan Selesai</span>
                            <span class="badge bg-success">{{ auth()->user()->complaints->where('status', 'selesai')->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Dalam Proses</span>
                            <span class="badge bg-warning">{{ auth()->user()->complaints->where('status', 'diproses')->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Menunggu</span>
                            <span class="badge bg-info">{{ auth()->user()->complaints->where('status', 'menunggu')->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Ditolak</span>
                            <span class="badge bg-danger">{{ auth()->user()->complaints->where('status', 'ditolak')->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="progress" style="height: 25px;">
                            @php
                                $total = auth()->user()->complaints->count();
                                $completed = auth()->user()->complaints->where('status', 'selesai')->count();
                                $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%">
                                {{ $percentage }}%
                            </div>
                        </div>
                        <small class="text-muted">Tingkat penyelesaian pengaduan</small>
                    </div>
                </div>
            </div>

            <!-- Theme Settings -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-palette me-2"></i>Tema Tampilan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="setTheme('light')">
                            <i class="bi bi-sun me-2"></i>Light Mode
                        </button>
                        <button type="button" class="btn btn-outline-dark" onclick="setTheme('dark')">
                            <i class="bi bi-moon me-2"></i>Dark Mode
                        </button>
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Pengaturan ini akan disimpan di browser Anda.
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Status Akun</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Role</span>
                            <span class="badge bg-primary">Siswa</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Tanggal Daftar</span>
                            <span>{{ auth()->user()->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Terakhir Login</span>
                            <span>{{ now()->format('d F Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Akun Anda terlindungi
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setTheme(theme) {
    const html = document.documentElement;
    html.setAttribute('data-bs-theme', theme);
    localStorage.setItem('theme', theme);
    
    // Send to server
    fetch('/theme', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ theme: theme })
    });
    
    alert('Theme berhasil diubah ke ' + theme + ' mode');
}

// Show password toggle
document.getElementById('showPasswordCheck').addEventListener('change', function() {
    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    const type = this.checked ? 'text' : 'password';
    currentPassword.type = type;
    newPassword.type = type;
    confirmPassword.type = type;
});

// Form validation
document.querySelector('form[action*="profile"]').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;
    if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
        e.preventDefault();
        alert('Nomor telepon hanya boleh berisi angka, +, -, atau spasi.');
        return false;
    }
});
</script>
@endsection