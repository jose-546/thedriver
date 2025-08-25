<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Administration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Admin CSS -->
    <style>
        /* Fix pour dropdown notifications - pas de décalage du header */
        .nav-item.dropdown {
            position: static;
        }

        .notification-dropdown {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            z-index: 1050 !important;
            margin-top: 0 !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #d1ecf1;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }

        .card-stat {
            border-left: 4px solid #0d6efd;
        }

        .card-stat.success {
            border-left-color: #198754;
        }

        .card-stat.warning {
            border-left-color: #ffc107;
        }

        .card-stat.danger {
            border-left-color: #dc3545;
        }

        /* Styles pour les notifications */
        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e3e6f0;
            transition: background-color 0.15s ease-in-out;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8f9fc;
        }

        .notification-item.unread {
            background-color: #e3f2fd;
            border-left: 3px solid #2196f3;
        }

        .notification-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.25rem;
        }

        .notification-message {
            font-size: 0.8rem;
            color: #858796;
            margin-bottom: 0.25rem;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </a>
        
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav ms-auto d-flex flex-row position-relative">
            <!-- Notifications -->
            <div class="nav-item dropdown me-2">
                <a class="nav-link dropdown-toggle position-relative px-3" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"><span id="notification-badge" class="position-absolute top-3 mb-5 start-95 translate-middle badge rounded-pill bg-danger" style="display: none;">
                        0
                    </span></i>
                    
                </a>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                        <span>Notifications</span>
                        <button type="button" class="btn btn-sm btn-link text-primary p-0" id="mark-all-read" style="display: none;">
                            Tout marquer comme lu
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li id="no-notifications" class="text-center py-3 text-muted">
                        <i class="bi bi-bell-slash fs-4"></i>
                        <p class="mb-0 mt-2">Aucune notification</p>
                    </li>
                    <div id="notifications-list"></div>
                </ul>
            </div>
            
            <div class="nav-item text-nowrap">
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link px-3 btn btn-link text-light">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}">
                                <i class="bi bi-car-front"></i> Gestion des voitures
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                                <i class="bi bi-calendar-check"></i> Réservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reservations.current') ? 'active' : '' }}" href="{{ route('admin.reservations.current') }}">
                                <i class="bi bi-clock"></i> Réservations en cours
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reservations.expired') ? 'active' : '' }}" href="{{ route('admin.reservations.expired') }}">
                                <i class="bi bi-clock-history"></i> Réservations expirées
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reservations.stats') ? 'active' : '' }}" href="{{ route('admin.reservations.stats') }}">
                                <i class="bi bi-graph-up"></i> Statistiques
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Messages de session -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour les notifications -->
    <script>
        let notificationCheckInterval;
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Système de notifications initialisé');
            
            // Charger les notifications au chargement de la page
            loadNotifications();
            
            // Vérifier les nouvelles notifications toutes les 30 secondes
            notificationCheckInterval = setInterval(loadNotifications, 30000);
            
            // Gérer le clic sur "Tout marquer comme lu"
            const markAllBtn = document.getElementById('mark-all-read');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', function() {
                    markAllAsRead();
                });
            }
            
            // Charger la liste détaillée quand on ouvre le dropdown
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.addEventListener('click', function() {
                    console.log('📋 Chargement de la liste des notifications...');
                    loadNotificationsList();
                });
            }
        });

        function loadNotifications() {
            console.log('🔄 Vérification des notifications...');
            
            fetch('{{ route("admin.notifications.count") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('📊 Nombre de notifications:', data.count);
                    updateNotificationBadge(data.count);
                })
                .catch(error => {
                    console.error('❌ Erreur lors du chargement du compteur:', error);
                });
        }

        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            const markAllBtn = document.getElementById('mark-all-read');
            
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'block';
                    console.log('🔔 Badge affiché avec:', count);
                } else {
                    badge.style.display = 'none';
                    console.log('✅ Aucune notification non lue');
                }
            }
            
            if (markAllBtn) {
                markAllBtn.style.display = count > 0 ? 'block' : 'none';
            }
        }

        function loadNotificationsList() {
            fetch('{{ route("admin.notifications.recent") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('📋 Notifications reçues:', data.notifications.length);
                    
                    const notificationsList = document.getElementById('notifications-list');
                    const noNotifications = document.getElementById('no-notifications');
                    
                    if (data.notifications.length > 0) {
                        if (noNotifications) noNotifications.style.display = 'none';
                        if (notificationsList) {
                            notificationsList.innerHTML = '';
                            
                            data.notifications.forEach(notification => {
                                const notificationHtml = createNotificationHTML(notification);
                                notificationsList.insertAdjacentHTML('beforeend', notificationHtml);
                            });
                        }
                    } else {
                        if (noNotifications) noNotifications.style.display = 'block';
                        if (notificationsList) notificationsList.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('❌ Erreur lors du chargement des notifications:', error);
                });
        }

        function createNotificationHTML(notification) {
            return `
                <li class="notification-item unread" onclick="handleNotificationClick(${notification.id})">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">${notification.created_at}</div>
                </li>
            `;
        }

        function handleNotificationClick(notificationId) {
            console.log('🖱️ Clic sur notification:', notificationId);
            // Marquer comme lue et rediriger
            window.location.href = `{{ route('admin.notifications.click', ['notification' => 'NOTIF_ID']) }}`.replace('NOTIF_ID', notificationId);

        }

        function markAllAsRead() {
            console.log('✅ Marquage de toutes les notifications comme lues...');
            
            fetch('{{ route("admin.notifications.mark-all") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('✅ Toutes les notifications marquées comme lues');
                    updateNotificationBadge(0);
                    const notificationsList = document.getElementById('notifications-list');
                    const noNotifications = document.getElementById('no-notifications');
                    
                    if (notificationsList) notificationsList.innerHTML = '';
                    if (noNotifications) noNotifications.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('❌ Erreur lors du marquage:', error);
            });
        }

        // Test au chargement pour vérifier que les routes fonctionnent
        setTimeout(function() {
            console.log('🧪 Test de connectivité des routes...');
            loadNotifications();
        }, 1000);
    </script>
    
    @stack('scripts')
</body>
</html>