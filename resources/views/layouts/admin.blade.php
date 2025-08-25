<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Administration - {{ config('app.name', 'Car Rental') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --admin-primary: #1e293b;
            --admin-secondary: #334155;
            --admin-accent: #3b82f6;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-light: #f8fafc;
            --admin-dark: #0f172a;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--admin-light);
        }

        .admin-sidebar {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }

        .admin-sidebar.collapsed {
            width: 70px;
        }

        .admin-sidebar .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar .sidebar-header h5 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .admin-sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0.5rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(2px);
        }

        .admin-main {
            margin-left: 250px;
            transition: all 0.3s;
        }

        .admin-main.expanded {
            margin-left: 70px;
        }

        .admin-topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--admin-primary);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .admin-content {
            padding: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--admin-accent);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-card.success {
            border-left-color: var(--admin-success);
        }

        .stats-card.warning {
            border-left-color: var(--admin-warning);
        }

        .stats-card.danger {
            border-left-color: var(--admin-danger);
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--admin-primary);
        }

        .stats-card .stats-label {
            color: #64748b;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .btn-primary {
            background-color: var(--admin-accent);
            border-color: var(--admin-accent);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            color: var(--admin-primary);
            font-weight: 600;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .badge.bg-success {
            background-color: var(--admin-success) !important;
        }

        .badge.bg-warning {
            background-color: var(--admin-warning) !important;
        }

        .badge.bg-danger {
            background-color: var(--admin-danger) !important;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 70px;
            }
            
            .admin-main {
                margin-left: 70px;
            }
            
            .admin-sidebar .nav-link span {
                display: none;
            }
            
            .admin-sidebar .sidebar-header h5 {
                display: none;
            }
        }

        .collapsed .nav-link span,
        .collapsed .sidebar-header h5 {
            display: none;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5><i class="fas fa-car me-2"></i> <span>Car Rental Admin</span></h5>
        </div>
        <nav class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}">
                        <i class="fas fa-car"></i>
                        <span>Gestion des voitures</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Réservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reservations.current') ? 'active' : '' }}" href="{{ route('admin.reservations.current') }}">
                        <i class="fas fa-clock"></i>
                        <span>En cours</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reservations.expired') ? 'active' : '' }}" href="{{ route('admin.reservations.expired') }}">
                        <i class="fas fa-history"></i>
                        <span>Expirées</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}" href="{{ route('admin.stats') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
            </ul>

            <!-- Separator -->
            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.2);">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Voir le site</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent text-start w-100" style="color: #cbd5e1;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="admin-main" id="main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0 text-dark">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-decoration-none text-dark" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-shield me-2"></i>{{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Mobile responsive
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                main.classList.add('expanded');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>