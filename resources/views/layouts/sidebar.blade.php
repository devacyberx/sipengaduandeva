<div class="sidebar shadow-lg">
    <!-- Sidebar Header -->
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <h4 class="mb-0 d-flex align-items-center">
            @if(auth()->user()->isAdmin())
                <i class="bi bi-person-badge me-2"></i>
                <span>ADMIN</span>
            @else
                <i class="bi bi-person me-2"></i>
                <span>SISWA</span>
            @endif
        </h4>
        
        <!-- Close button for mobile -->
        <button class="btn btn-link d-lg-none p-0 text-light" onclick="toggleSidebar()" aria-label="Close sidebar">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>
    
    <!-- User Info -->
    <div class="px-3 py-2 border-bottom border-top" style="border-color: var(--border-color) !important;">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                 style="width: 40px; height: 40px; font-size: 1.2rem; font-weight: 600;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="ms-3">
                <div class="fw-semibold" style="font-size: 0.95rem;">{{ auth()->user()->name }}</div>
                <div class="small text-muted">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Navigation -->
    <div class="sidebar-content">
        <ul class="nav flex-column">
            @if(auth()->user()->isAdmin())
                <!-- Admin Menu -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}" 
                       href="{{ route('admin.complaints.index') }}">
                        <i class="bi bi-list-check"></i>
                        <span>Data Pengaduan</span>
                        @php
                            $pendingCount = \App\Models\Complaint::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-file-text"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                       href="{{ route('admin.settings.profile') }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                
            @else
                <!-- Siswa Menu -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" 
                       href="{{ route('siswa.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.complaints.index') ? 'active' : '' }}" 
                       href="{{ route('siswa.complaints.index') }}">
                        <i class="bi bi-list-check"></i>
                        <span>Pengaduan Saya</span>
                        @php
                            $myPendingCount = auth()->user()->complaints()->where('status', 'pending')->count();
                        @endphp
                        @if($myPendingCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $myPendingCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.complaints.create') ? 'active' : '' }}" 
                       href="{{ route('siswa.complaints.create') }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Buat Pengaduan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.history.index') ? 'active' : '' }}" 
                       href="{{ route('siswa.history.index') }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.profile.*') ? 'active' : '' }}" 
                       href="{{ route('siswa.profile.index') }}">
                        <i class="bi bi-person"></i>
                        <span>Profil</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    
    <!-- Sidebar Footer -->
    <div class="sidebar-footer p-3 border-top" style="border-color: var(--border-color) !important;">
        <div class="small text-muted text-center">
            <i class="bi bi-shield-check me-1"></i>
            SIPENGADUAN v1.0
        </div>
        <div class="small text-muted text-center mt-1">
            {{ date('Y') }} &copy; All rights reserved
        </div>
    </div>
</div>