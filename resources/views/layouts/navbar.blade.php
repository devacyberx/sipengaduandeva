<nav class="navbar navbar-custom shadow-sm">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (Mobile only) -->
        <button class="btn btn-light d-lg-none me-2" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        
        <!-- Brand - Always visible -->
        <a class="navbar-brand d-flex align-items-center" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('siswa.dashboard') }}">
            <i class="bi bi-shield-check me-1"></i> <!-- Changed from me-2 to me-1 -->
            <span class="brand-text">SIPENGADUAN</span>
        </a>
        
        <!-- Right Side Menu -->
        <div class="d-flex align-items-center gap-2">
            <!-- Theme Toggle -->
            <button class="btn btn-light theme-toggle" onclick="toggleTheme()" type="button" aria-label="Toggle theme">
                <i class="bi {{ session('theme', 'light') === 'dark' ? 'bi-sun' : 'bi-moon-stars' }}"></i>
            </button>
            
            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                    <i class="bi bi-person-circle me-2 d-none d-sm-inline"></i>
                    <span class="user-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <i class="bi bi-person-circle d-sm-none"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!-- User Info (Mobile only) -->
                    <li class="d-md-none">
                        <div class="dropdown-item-text text-muted small">
                            {{ auth()->user()->name }}
                            <br>
                            <span class="text-primary">{{ auth()->user()->email }}</span>
                        </div>
                    </li>
                    <li class="d-md-none"><hr class="dropdown-divider"></li>

                    @if(auth()->user()->isAdmin())
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings.profile') }}">
                                <i class="bi bi-person me-2"></i>Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings.profile') }}?tab=password">
                                <i class="bi bi-key me-2"></i>Ubah Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="{{ route('siswa.profile.index') }}">
                                <i class="bi bi-person me-2"></i>Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('siswa.profile.index') }}?tab=password">
                                <i class="bi bi-key me-2"></i>Ubah Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Hidden Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
/* Navbar Custom Styles - Fixed spacing */
.navbar-custom {
    background-color: var(--sidebar-bg) !important;
    border-bottom: 1px solid var(--border-color);
    padding: 0.9rem 1.25rem !important; /* Slightly reduced from 1rem to 0.9rem */
    position: sticky;
    top: 0;
    z-index: 1040;
    backdrop-filter: blur(10px);
    height: auto !important;
    min-height: 68px; /* Slightly reduced from 70px */
}

.navbar-custom .container-fluid {
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}

/* Brand styling - with closer icon and text */
.navbar-custom .navbar-brand {
    font-size: clamp(1rem, 4vw, 1.25rem);
    font-weight: 600;
    color: var(--sidebar-color) !important;
    display: flex;
    align-items: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 250px;
    padding: 0.2rem 0; /* Reduced padding */
    line-height: 1.2; /* Tighter line height */
}

.navbar-custom .navbar-brand i {
    color: var(--primary-color);
    font-size: clamp(1.2rem, 5vw, 1.4rem);
    flex-shrink: 0;
    margin-right: 0.25rem !important; /* Force smaller margin */
}

.navbar-custom .navbar-brand .brand-text {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-left: 0.15rem; /* Minimal margin */
}

/* Buttons in navbar */
.navbar-custom .btn {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    min-width: 40px;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--sidebar-color);
}

.navbar-custom .btn:hover {
    background-color: var(--sidebar-hover);
    border-color: var(--primary-color);
}

/* Right side menu */
.navbar-custom .d-flex.align-items-center {
    gap: 0.5rem;
    flex-shrink: 0;
}

/* User dropdown button */
.navbar-custom .dropdown-toggle {
    max-width: 200px;
}

.navbar-custom .dropdown-toggle .user-name {
    max-width: 120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    margin-left: 0.5rem;
}

/* Responsive adjustments - optimized for each screen size */
@media (max-width: 991px) {
    .navbar-custom {
        padding: 0.85rem 1rem !important;
        min-height: 64px;
    }
}

@media (max-width: 768px) {
    .navbar-custom {
        padding: 0.8rem 1rem !important;
        min-height: 60px;
    }
    
    .navbar-custom .navbar-brand {
        max-width: 180px;
    }
    
    .navbar-custom .navbar-brand i {
        font-size: 1.3rem;
    }
    
    .navbar-custom .navbar-brand .brand-text {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .navbar-custom {
        padding: 0.75rem 0.9rem !important;
        min-height: 58px;
    }
    
    .navbar-custom .navbar-brand {
        max-width: 150px;
    }
    
    .navbar-custom .navbar-brand i {
        font-size: 1.25rem;
        margin-right: 0.2rem !important;
    }
    
    .navbar-custom .navbar-brand .brand-text {
        font-size: 0.95rem;
    }
}

@media (max-width: 375px) {
    .navbar-custom {
        padding: 0.7rem 0.8rem !important;
        min-height: 56px;
    }
    
    .navbar-custom .navbar-brand {
        max-width: 130px;
    }
    
    .navbar-custom .navbar-brand i {
        font-size: 1.2rem;
        margin-right: 0.15rem !important;
    }
    
    .navbar-custom .navbar-brand .brand-text {
        font-size: 0.9rem;
        margin-left: 0.1rem;
    }
}

@media (max-width: 320px) {
    .navbar-custom {
        padding: 0.65rem 0.7rem !important;
        min-height: 54px;
    }
    
    .navbar-custom .navbar-brand {
        max-width: 110px;
    }
    
    .navbar-custom .navbar-brand i {
        font-size: 1.1rem;
        margin-right: 0.1rem !important;
    }
    
    .navbar-custom .navbar-brand .brand-text {
        font-size: 0.85rem;
    }
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .navbar-custom .btn-light {
    background: #2c3137;
    border-color: #3a4048;
    color: #e9ecef;
}

/* Safe area insets */
@supports (padding: max(0px)) {
    .navbar-custom {
        padding-left: max(1.25rem, env(safe-area-inset-left)) !important;
        padding-right: max(1.25rem, env(safe-area-inset-right)) !important;
    }
}
</style>