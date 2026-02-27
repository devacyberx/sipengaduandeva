<!DOCTYPE html>
<html lang="id" data-bs-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SIPENGADUAN</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #0d6efd;
            --primary-hover: #0b5ed7;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 0px;
            --header-height: 60px;
            --transition-speed: 0.3s;
            --border-radius: 1rem;
            --card-border-radius: 1rem;
            --btn-border-radius: 0.75rem;
        }
        
        [data-bs-theme="dark"] {
            --primary-color: #0d6efd;
            --primary-hover: #0b5ed7;
            --sidebar-bg: #1a1e24;
            --sidebar-color: #e9ecef;
            --sidebar-hover: #2c3137;
            --card-bg: #1e2329;
            --border-color: #2c3137;
            --text-muted: #9ca3af;
            --input-bg: #2c3137;
            --input-border: #3a4048;
        }
        
        [data-bs-theme="light"] {
            --sidebar-bg: #f8f9fa;
            --sidebar-color: #212529;
            --sidebar-hover: #e9ecef;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --text-muted: #6c757d;
            --input-bg: #ffffff;
            --input-border: #dee2e6;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            background-color: var(--bs-body-bg);
            min-height: 100vh;
            color: var(--sidebar-color);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Wrapper untuk layout dengan sidebar */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* ==================== SIDEBAR STYLES ==================== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            transition: transform var(--transition-speed) ease;
            z-index: 1050;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }

        /* Sidebar header */
        .sidebar-header {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--sidebar-bg);
            position: sticky;
            top: 0;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header h4 {
            font-size: clamp(1.1rem, 4vw, 1.25rem);
            font-weight: 600;
            margin: 0;
            color: var(--sidebar-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
        }

        .sidebar-header i {
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .sidebar-header .btn-close-sidebar {
            display: none;
            background: transparent;
            border: none;
            color: var(--sidebar-color);
            font-size: 1.2rem;
            padding: 0.5rem;
            cursor: pointer;
        }

        /* User info in sidebar */
        .sidebar-user {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--sidebar-bg);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .user-info {
            min-width: 0;
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--sidebar-color);
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Sidebar navigation */
        .sidebar-content {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .nav-item {
            width: 100%;
        }

        .nav-link {
            color: var(--sidebar-color);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            font-size: clamp(0.9rem, 3vw, 1rem);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-link i {
            font-size: 1.25rem;
            width: 1.5rem;
            text-align: center;
            flex-shrink: 0;
            color: var(--primary-color);
        }

        .nav-link span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-link .badge {
            flex-shrink: 0;
            margin-left: auto;
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.5rem;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
            color: var(--primary-color);
            font-weight: 500;
            border-left: 3px solid var(--primary-color);
        }

        .nav-link.active i {
            color: var(--primary-color);
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            background: var(--sidebar-bg);
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            flex: 1;
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
            background-color: var(--bs-body-bg);
        }

        /* ==================== NAVBAR STYLES ==================== */
        .navbar-custom {
            background-color: var(--sidebar-bg) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 0.5rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1040;
            backdrop-filter: blur(10px);
            height: var(--header-height);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-custom .container-fluid {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            height: 100%;
        }

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
            padding: 0;
            margin: 0;
        }

        .navbar-custom .navbar-brand i {
            color: var(--primary-color);
            font-size: clamp(1.2rem, 5vw, 1.4rem);
            flex-shrink: 0;
        }

        .navbar-custom .navbar-brand .brand-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-left: 0.5rem;
        }

        /* Navbar buttons */
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

        .navbar-custom .btn i {
            font-size: 1.1rem;
        }

        /* Right side menu */
        .navbar-custom .right-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        /* User dropdown */
        .navbar-custom .dropdown-toggle {
            max-width: 200px;
            padding: 0.5rem 1rem;
        }

        .navbar-custom .dropdown-toggle .user-name {
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            margin-left: 0.5rem;
        }

        .navbar-custom .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        /* ==================== CONTENT WRAPPER ==================== */
        .content-wrapper {
            flex: 1;
            padding: clamp(1rem, 3vw, 1.75rem);
            background-color: var(--bs-body-bg);
            min-width: 0;
            width: 100%;
        }

        /* ==================== ALERTS ==================== */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert i {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            border-left-color: #198754;
            color: var(--sidebar-color);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: var(--sidebar-color);
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: var(--sidebar-color);
        }

        .alert-info {
            background-color: rgba(13, 202, 240, 0.1);
            border-left-color: #0dcaf0;
            color: var(--sidebar-color);
        }

        .alert ul {
            margin-top: 0.5rem;
            margin-bottom: 0;
            padding-left: 1.25rem;
        }

        /* ==================== CARDS ==================== */
        .card {
            border-radius: var(--card-border-radius);
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .card-header-custom {
            background: var(--primary-color) !important;
            color: white;
            border-radius: var(--card-border-radius) var(--card-border-radius) 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        /* ==================== STATISTICS CARDS ==================== */
        .stat-card {
            border-radius: var(--card-border-radius);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            height: 100%;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-value {
            font-size: clamp(1.5rem, 5vw, 2rem);
            font-weight: 700;
            margin-bottom: 0.25rem;
            line-height: 1.2;
            color: var(--sidebar-color);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ==================== TABLES ==================== */
        .table-responsive {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            margin-bottom: 0;
            color: var(--sidebar-color);
            min-width: 100%;
        }

        .table th {
            background-color: var(--sidebar-hover);
            font-weight: 600;
            white-space: nowrap;
            padding: 1rem 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* ==================== FORMS ==================== */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--sidebar-color);
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            background: var(--input-bg);
            color: var(--sidebar-color);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            height: auto;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }

        .input-group {
            flex-wrap: nowrap;
        }

        .input-group-text {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            background: var(--sidebar-hover);
            color: var(--sidebar-color);
            padding: 0.75rem 1rem;
        }

        /* ==================== BUTTONS ==================== */
        .btn {
            border-radius: var(--btn-border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.5rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 1rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(13, 110, 253, 0.3);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #bb2d3b;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #198754;
            color: white;
        }

        .btn-success:hover {
            background: #157347;
            transform: translateY(-2px);
        }

        /* ==================== BADGES ==================== */
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge.bg-primary { background: var(--primary-color) !important; }
        .badge.bg-success { background: #198754 !important; }
        .badge.bg-danger { background: #dc3545 !important; }
        .badge.bg-warning { background: #ffc107 !important; color: #212529; }
        .badge.bg-info { background: #0dcaf0 !important; color: #212529; }

        /* ==================== DROPDOWN MENU ==================== */
        .dropdown-menu {
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            padding: 0.5rem;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            margin-top: 0.5rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--sidebar-color);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item:hover {
            background: var(--sidebar-hover);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
        }

        .dropdown-divider {
            border-top-color: var(--border-color);
            margin: 0.5rem 0;
        }

        .dropdown-header {
            color: var(--text-muted);
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ==================== PAGINATION ==================== */
        .pagination {
            gap: 0.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-item .page-link {
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--sidebar-color);
            padding: 0.5rem 0.75rem;
            min-width: 40px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .page-item .page-link:hover {
            background: var(--sidebar-hover);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }

        /* ==================== MODAL ==================== */
        .modal-content {
            border-radius: var(--card-border-radius);
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .btn-close {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            color: var(--sidebar-color);
            cursor: pointer;
            padding: 0.5rem;
        }

        /* ==================== LOADING SPINNER ==================== */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-color);
        }

        /* ==================== THEME TOGGLE ==================== */
        .theme-toggle {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover {
            transform: rotate(15deg);
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* ==================== RESPONSIVE STYLES ==================== */

        /* Tablet (max-width: 991px) */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
                z-index: 1060;
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 2px 0 30px rgba(0,0,0,0.3);
            }

            .sidebar-header .btn-close-sidebar {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .navbar-custom .navbar-brand {
                max-width: 200px;
            }

            .navbar-custom .btn {
                min-width: 44px;
                min-height: 44px;
            }
        }

        /* Mobile landscape */
        @media (max-width: 767px) and (orientation: landscape) {
            .sidebar {
                padding-bottom: 1rem;
            }

            .nav-link {
                padding: 0.5rem 0.75rem;
            }

            .sidebar-header {
                padding: 0.75rem 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .stat-card {
                padding: 1rem;
            }
        }

        /* Mobile portrait (max-width: 768px) */
        @media (max-width: 768px) {
            :root {
                --header-height: 56px;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .navbar-custom {
                padding: 0.25rem 1rem;
            }

            .navbar-custom .navbar-brand {
                max-width: 150px;
            }

            .navbar-custom .navbar-brand .brand-text {
                font-size: 1rem;
            }

            .navbar-custom .dropdown-toggle .user-name {
                display: none;
            }

            .navbar-custom .btn {
                min-width: 40px;
                min-height: 40px;
            }

            .card-header {
                padding: 1rem 1.25rem;
                font-size: 1rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .table th, .table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .alert {
                padding: 0.875rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Small mobile (max-width: 576px) */
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.75rem;
            }

            .navbar-custom {
                padding: 0.25rem 0.75rem;
            }

            .navbar-custom .navbar-brand {
                max-width: 130px;
            }

            .navbar-custom .navbar-brand .brand-text {
                font-size: 0.95rem;
            }

            .navbar-custom .btn {
                min-width: 38px;
                min-height: 38px;
                padding: 0.4rem 0.6rem;
            }

            .navbar-custom .btn i {
                font-size: 1rem;
            }

            .card-header {
                padding: 0.875rem 1rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .card-body {
                padding: 1rem;
            }

            .stat-card {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                margin-bottom: 0.5rem;
            }

            .stat-content {
                text-align: center;
            }

            .table th, .table td {
                padding: 0.6rem;
                font-size: 0.85rem;
            }

            .btn-block-mobile {
                width: 100%;
                display: block;
            }

            .btn-group-mobile {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
            }

            .btn-group-mobile .btn {
                width: 100%;
            }

            .dropdown-menu {
                min-width: 180px;
            }

            .badge {
                padding: 0.4rem 0.6rem;
                font-size: 0.7rem;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 1rem;
            }
        }

        /* Extra small mobile (max-width: 375px) */
        @media (max-width: 375px) {
            .navbar-custom .navbar-brand {
                max-width: 110px;
            }

            .navbar-custom .navbar-brand .brand-text {
                font-size: 0.9rem;
            }

            .navbar-custom .navbar-brand i {
                font-size: 1.1rem;
            }

            .navbar-custom .btn {
                min-width: 36px;
                min-height: 36px;
                padding: 0.35rem 0.5rem;
            }

            .navbar-custom .right-menu {
                gap: 0.25rem;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .table th, .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .dropdown-menu {
                min-width: 160px;
            }

            .dropdown-item {
                padding: 0.6rem 0.75rem;
                font-size: 0.85rem;
            }
        }

        /* Extra small mobile (max-width: 320px) */
        @media (max-width: 320px) {
            .navbar-custom .navbar-brand {
                max-width: 90px;
            }

            .navbar-custom .navbar-brand .brand-text {
                font-size: 0.85rem;
            }

            .navbar-custom .btn {
                min-width: 34px;
                min-height: 34px;
                padding: 0.3rem 0.4rem;
            }

            .navbar-custom .btn i {
                font-size: 0.9rem;
            }

            .content-wrapper {
                padding: 0.5rem;
            }

            .card-header {
                padding: 0.75rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .stat-card {
                padding: 0.75rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .table th, .table td {
                padding: 0.4rem;
                font-size: 0.75rem;
            }

            .badge {
                padding: 0.3rem 0.5rem;
                font-size: 0.65rem;
            }
        }

        /* Print styles */
        @media print {
            .sidebar, 
            .navbar-custom, 
            .no-print,
            .btn,
            .theme-toggle,
            .dropdown {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .card {
                border: 1px solid #ddd;
                box-shadow: none;
                page-break-inside: avoid;
            }

            .table {
                border-collapse: collapse;
            }

            .table th {
                background: #f8f9fa !important;
                color: black !important;
            }

            a[href]:after {
                content: " (" attr(href) ")";
            }
        }

        /* Dark mode specific overrides */
        [data-bs-theme="dark"] .table {
            --bs-table-bg: var(--card-bg);
            --bs-table-striped-bg: rgba(255,255,255,0.02);
            --bs-table-hover-bg: rgba(255,255,255,0.05);
        }

        [data-bs-theme="dark"] .btn-light {
            background: #2c3137;
            border-color: #3a4048;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .btn-light:hover {
            background: #3a4048;
            border-color: #4a5159;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #2c3137 !important;
        }

        [data-bs-theme="dark"] .text-dark {
            color: #e9ecef !important;
        }

        [data-bs-theme="dark"] .border {
            border-color: var(--border-color) !important;
        }

        /* Accessibility - focus styles */
        :focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--sidebar-hover);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Safe area insets for modern phones */
        @supports (padding: max(0px)) {
            .sidebar {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }

            .navbar-custom {
                padding-left: max(1rem, env(safe-area-inset-left));
                padding-right: max(1rem, env(safe-area-inset-right));
            }

            .content-wrapper {
                padding-left: max(1rem, env(safe-area-inset-left));
                padding-right: max(1rem, env(safe-area-inset-right));
            }
        }

        /* Prevent zoom on input focus for iOS */
        @supports (-webkit-touch-callout: none) {
            input, select, textarea {
                font-size: 16px !important;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @if(auth()->check())
            @include('layouts.sidebar')
        @endif
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            @if(auth()->check())
                @include('layouts.navbar')
            @endif
            
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <div class="alert-content">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="alert-content">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div class="alert-content">{{ session('warning') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle-fill"></i>
                        <div class="alert-content">{{ session('info') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="alert-content">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Main Content -->
                <main class="fade-in">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <!-- Loading Spinner (Hidden by default) -->
    <div class="spinner-overlay" id="loadingSpinner" style="display: none;">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Theme management
        class ThemeManager {
            constructor() {
                this.html = document.documentElement;
                this.init();
            }

            init() {
                // Load saved theme
                const savedTheme = localStorage.getItem('theme') || '{{ session('theme', 'light') }}';
                this.setTheme(savedTheme, false);
            }

            setTheme(theme, saveToServer = true) {
                this.html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);

                // Update theme toggle icons
                document.querySelectorAll('.theme-toggle i').forEach(icon => {
                    if (theme === 'dark') {
                        icon.className = 'bi bi-sun';
                    } else {
                        icon.className = 'bi bi-moon-stars';
                    }
                });

                // Send to server if needed
                if (saveToServer) {
                    this.saveToServer(theme);
                }
            }

            toggle() {
                const currentTheme = this.html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme, true);
            }

            saveToServer(theme) {
                fetch('/theme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ theme: theme })
                }).catch(error => console.error('Error saving theme:', error));
            }
        }

        // Sidebar management
        class SidebarManager {
            constructor() {
                this.sidebar = document.querySelector('.sidebar');
                this.init();
            }

            init() {
                // Close sidebar on outside click for mobile
                document.addEventListener('click', (e) => {
                    if (window.innerWidth <= 991) {
                        const isClickInside = this.sidebar?.contains(e.target);
                        const isToggleButton = e.target.closest('[onclick="toggleSidebar()"]');
                        
                        if (!isClickInside && !isToggleButton && this.sidebar?.classList.contains('active')) {
                            this.toggle();
                        }
                    }
                });

                // Handle escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.sidebar?.classList.contains('active')) {
                        this.toggle();
                    }
                });

                // Handle resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth > 991 && this.sidebar?.classList.contains('active')) {
                        this.sidebar.classList.remove('active');
                    }
                });
            }

            toggle() {
                if (!this.sidebar) return;
                this.sidebar.classList.toggle('active');
                
                // Prevent body scroll when sidebar is open on mobile
                if (window.innerWidth <= 991) {
                    document.body.style.overflow = this.sidebar.classList.contains('active') ? 'hidden' : '';
                }
            }
        }

        // Loading spinner
        class LoadingSpinner {
            constructor() {
                this.spinner = document.getElementById('loadingSpinner');
            }

            show() {
                if (this.spinner) {
                    this.spinner.style.display = 'flex';
                }
            }

            hide() {
                if (this.spinner) {
                    this.spinner.style.display = 'none';
                }
            }
        }

        // Alert auto-dismiss
        class AlertManager {
            constructor() {
                this.init();
            }

            init() {
                // Auto-hide alerts after 5 seconds
                document.querySelectorAll('.alert').forEach(alert => {
                    setTimeout(() => {
                        const bsAlert = bootstrap.Alert.getInstance(alert);
                        if (bsAlert) {
                            bsAlert.close();
                        }
                    }, 5000);
                });
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            window.themeManager = new ThemeManager();
            window.sidebarManager = new SidebarManager();
            window.loadingSpinner = new LoadingSpinner();
            window.alertManager = new AlertManager();

            // Add active class to current nav item
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Prevent zoom on input focus for iOS
            document.addEventListener('touchstart', (e) => {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                    document.body.style.fontSize = '16px';
                }
            }, { passive: true });

            // Handle orientation change
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    document.body.style.height = window.innerHeight + 'px';
                }, 100);
            });
        });

        // Global functions
        function toggleSidebar() {
            if (window.sidebarManager) {
                window.sidebarManager.toggle();
            }
        }

        function toggleTheme() {
            if (window.themeManager) {
                window.themeManager.toggle();
            }
        }

        function showLoading() {
            if (window.loadingSpinner) {
                window.loadingSpinner.show();
            }
        }

        function hideLoading() {
            if (window.loadingSpinner) {
                window.loadingSpinner.hide();
            }
        }

        // Handle form submissions with loading
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM' && !e.target.classList.contains('no-loading')) {
                showLoading();
            }
        });

        // Handle anchor clicks with loading
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.getAttribute('href') && !link.getAttribute('href').startsWith('#') && !link.classList.contains('no-loading')) {
                if (link.target !== '_blank') {
                    showLoading();
                }
            }
        });

        // Handle popstate (back/forward navigation)
        window.addEventListener('popstate', function() {
            hideLoading();
        });

        // Debounced resize handler
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Trigger any resize-dependent updates
                if (window.innerWidth > 991) {
                    document.body.style.overflow = '';
                }
            }, 250);
        });
    </script>
    
    @yield('scripts')
</body>
</html>