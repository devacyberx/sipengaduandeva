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
                    <form action="{{ route('siswa.profile.update') }}" method="POST">
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
                                        <label for="class" class="form-label">Kelas</label>
                                        <input type="text" class="form-control @error('class') is-invalid @enderror" 
                                               id="class" name="class" value="{{ old('class', auth()->user()->class) }}">
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
                    @php
                        $totalComplaints = auth()->user()->complaints->count();
                        $completedComplaints = auth()->user()->complaints->where('status', 'selesai')->count();
                        $processingComplaints = auth()->user()->complaints->where('status', 'diproses')->count();
                        $pendingComplaints = auth()->user()->complaints->where('status', 'menunggu')->count();
                        $rejectedComplaints = auth()->user()->complaints->where('status', 'ditolak')->count();
                    @endphp
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Total Pengaduan</span>
                            <span class="badge bg-primary rounded-pill">{{ $totalComplaints }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Pengaduan Selesai</span>
                            <span class="badge bg-success rounded-pill">{{ $completedComplaints }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Dalam Proses</span>
                            <span class="badge bg-warning rounded-pill">{{ $processingComplaints }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Menunggu</span>
                            <span class="badge bg-info rounded-pill">{{ $pendingComplaints }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Ditolak</span>
                            <span class="badge bg-danger rounded-pill">{{ $rejectedComplaints }}</span>
                        </div>
                    </div>
                    
                    @if($totalComplaints > 0)
                    <div class="mt-3">
                        <div class="progress" style="height: 25px;">
                            @php
                                $percentage = round(($completedComplaints / $totalComplaints) * 100);
                            @endphp
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%;" 
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $percentage }}%
                            </div>
                        </div>
                        <small class="text-muted">Tingkat penyelesaian pengaduan</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Display Settings -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-display me-2"></i>Pengaturan Tampilan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Theme Mode</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="themeMode" id="lightMode" value="light" {{ session('theme', 'light') == 'light' ? 'checked' : '' }}>
                                <label class="form-check-label" for="lightMode">
                                    <i class="bi bi-sun me-1 text-warning"></i>Light Mode
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="themeMode" id="darkMode" value="dark" {{ session('theme', 'light') == 'dark' ? 'checked' : '' }}>
                                <label class="form-check-label" for="darkMode">
                                    <i class="bi bi-moon me-1 text-primary"></i>Dark Mode
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
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

<!-- Container untuk notifikasi di pojok kanan bawah -->
<div id="notification-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

<script>
// Function to show notification di pojok kanan bawah
function showNotification(theme) {
    const container = document.getElementById('notification-container');
    const modeText = theme === 'light' ? 'Light' : 'Dark';
    const iconClass = theme === 'light' ? 'bi-sun' : 'bi-moon';
    const bgColorClass = theme === 'light' ? 'bg-warning' : 'bg-primary';
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show';
    notification.style.minWidth = '300px';
    notification.style.marginBottom = '10px';
    notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    notification.style.border = 'none';
    notification.style.borderRadius = '10px';
    notification.style.animation = 'slideIn 0.3s ease-out';
    notification.style.backgroundColor = theme === 'dark' ? '#2d3748' : '#ffffff';
    notification.style.color = theme === 'dark' ? '#ffffff' : '#2d3748';
    notification.style.border = theme === 'dark' ? '1px solid #4a5568' : '1px solid #e2e8f0';
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="${bgColorClass} bg-opacity-25 rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi ${iconClass} ${theme === 'light' ? 'text-warning' : 'text-primary'} fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block" style="color: ${theme === 'dark' ? '#ffffff' : '#2d3748'};">Mode ${modeText} Diaktifkan!</strong>
                <small style="color: ${theme === 'dark' ? '#a0aec0' : '#718096'};">Tampilan telah berubah ke ${modeText} Mode</small>
            </div>
            <button type="button" class="btn-close ms-3" style="filter: ${theme === 'dark' ? 'invert(1) brightness(2)' : 'none'};" onclick="this.closest('.alert').remove()"></button>
        </div>
    `;
    
    // Add to container
    container.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out forwards';
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

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

// Theme toggle functionality
document.querySelectorAll('input[name="themeMode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            const theme = this.value;
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            
            // Send to server
            fetch('/theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ theme: theme })
            })
            .then(response => response.json())
            .then(data => {
                // Show notification
                showNotification(theme);
            })
            .catch(error => {
                console.error('Error:', error);
                // Tetap tampilkan notifikasi meskipun request gagal
                showNotification(theme);
            });
        }
    });
});

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', savedTheme);
    
    const radioToCheck = document.querySelector(`input[name="themeMode"][value="${savedTheme}"]`);
    if (radioToCheck) {
        radioToCheck.checked = true;
    }
});

// Form validation
document.querySelector('form[action*="profile/update"]').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;
    if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
        e.preventDefault();
        
        // Show error notification
        const container = document.getElementById('notification-container');
        const notification = document.createElement('div');
        notification.className = 'alert alert-danger alert-dismissible fade show';
        notification.style.minWidth = '300px';
        notification.style.marginBottom = '10px';
        notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        notification.style.border = 'none';
        notification.style.borderRadius = '10px';
        notification.style.animation = 'slideIn 0.3s ease-out';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="bg-danger bg-opacity-25 rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <strong class="d-block">Validasi Gagal!</strong>
                    <small class="text-muted">Nomor telepon tidak valid</small>
                </div>
                <button type="button" class="btn-close ms-3" onclick="this.closest('.alert').remove()"></button>
            </div>
        `;
        
        container.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out forwards';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
        
        return false;
    }
});
</script>
@endsection