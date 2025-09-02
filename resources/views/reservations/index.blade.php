<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Rentaly - Multipurpose Vehicle Car Rental Website Template</title>
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Rentaly - Multipurpose Vehicle Car Rental Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <style>
        :root {
            --primary-color: #860000;
            --primary-light: rgba(134, 0, 0, 0.1);
            --primary-gradient: linear-gradient(135deg, #860000, #a40000);
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --background-light: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.12);
            --border-radius: 16px;
            --border-radius-large: 24px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        body {
            background: var(--background-light);
            color: var(--text-dark);
        }

        /* Page Header */
        .page-header {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 2rem;
            border-radius: var(--border-radius-large);
            margin-bottom: 2.5rem;
            text-align: center;
            box-shadow: var(--shadow-medium);
        }

        .page-header h1 {
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .page-header p {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
            margin: 0;
        }

        .page-header .fa-car {
            margin-right: 0.75rem;
            opacity: 0.9;
        }

        /* Main Content Container */
        .main-content-wrapper {
            padding: 2rem;
        }

        /* Tabs Container */
        .tabs-container {
            background: white;
            border-radius: var(--border-radius-large);
           
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        /* Tabs Navigation */
        .tabs-nav {
            display: flex;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 2px solid var(--border-light);
        }

        .tab-btn {
            flex: 1;
            padding: 1.5rem 1.25rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tab-btn:hover {
            background: rgba(134, 0, 0, 0.05);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .tab-btn.active {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
        }

        .tab-count {
            background: var(--text-muted);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            min-width: 24px;
            text-align: center;
        }

        .tab-btn.active .tab-count {
            background: var(--primary-color);
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 2rem;
        }

        .tab-content.active {
            display: block;
        }

        /* Table Styles */
        .responsive-table {
            overflow-x: auto;
            
        }

        .reservations-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }

        .reservations-table th {
            
            padding: 0.5rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-light);
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }

        .reservations-table td {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .reservations-table tbody tr {
            transition: all 0.2s ease;
        }

        .reservations-table tbody tr:hover {
            background: rgba(134, 0, 0, 0.02);
            transform: translateX(2px);
        }

        /* Car Info */
        .car-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .car-image {
            width: 70px;
            height: 52px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--border-light);
            transition: all 0.2s ease;
        }

        .car-image:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-soft);
        }

        .car-details h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.05rem;
            color: var(--text-dark);
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
        }

        .car-details p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Duration */
        .duration {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .duration-days {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .duration-dates {
            font-size: 0.85rem;
            color: var(--text-muted);
            opacity: 0.8;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            letter-spacing: 0.025em;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-scheduled {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-expired {
            background: linear-gradient(135deg, #f8d7da, #f1b0b7);
            color: #721c24;
            border: 1px solid #f1b0b7;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #f1f3f4, #e2e6ea);
            color: #6c757d;
            border: 1px solid #e2e6ea;
        }

        .status-pending {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Price */
        .price {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-color);
            font-family: 'Outfit', sans-serif;
        }

        /* Countdown */
        .countdown {
            background: var(--primary-gradient);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-family: 'Outfit', monospace;
            font-weight: 600;
            text-align: center;
            min-width: 120px;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            box-shadow: var(--shadow-soft);
        }

        .countdown-ended {
            background: linear-gradient(135deg, #6c757d, #495057);
        }

        .countdown-scheduled {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            box-shadow: var(--shadow-soft);
            letter-spacing: 0.025em;
        }

        .btn:hover {
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #a40000, #860000);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1e7e34, #1aa085);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333, #c0392b);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.4;
            color: var(--primary-color);
        }

        .empty-state h3 {
            margin-bottom: 0.75rem;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-content-wrapper {
                padding: 1.5rem;
            }
            
            .page-header {
                padding: 2.5rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .tabs-nav {
                flex-wrap: wrap;
            }
            
            .tab-btn {
                flex: 1 1 50%;
                min-width: 150px;
                padding: 1.25rem 1rem;
                font-size: 0.9rem;
            }
            
            .tab-content {
                padding: 1.5rem;
            }
            
            .reservations-table {
                font-size: 0.9rem;
            }
            
            .reservations-table th,
            .reservations-table td {
                padding: 1rem 0.75rem;
            }
            
            .actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                padding: 0.65rem 1rem;
                font-size: 0.85rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .main-content-wrapper {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .car-info {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .car-image {
                width: 100%;
                height: auto;
                max-width: 120px;
            }

            .countdown {
                min-width: 100px;
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>

            <section id="section-cars" style="background-color: #f8fafc;">
                <div class="container">
                    <div class="row">
                          <div class="col-lg-3 mb30">
                            <div class="card p-4 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="{{ asset('images/profile/1.jpg') }}" alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            {{ auth()->user()->username }}                                                  
                                            <span class="profile_username text-gray">{{ auth()->user()->email }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li>
                                        <a href="{{ route('dashboard') }}" 
                                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <i class="fa fa-home"></i> Tableau de bord
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('profile.edit') }}" 
                                        class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i> Mon Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reservations.index') }}" 
                                        class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                                        <i class="fa fa-calendar"></i> Mes Réservations
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('cars.search') }}" 
                                        class="{{ request()->routeIs('cars.search') ? 'active' : '' }}">
                                        <i class="fa fa-car"></i> Voitures Disponibles
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}" 
                                        onclick="event.preventDefault(); this.nextElementSibling.submit();">
                                            <i class="fa fa-sign-out"></i> Déconnexion
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>

                                </ul>

                            </div>

                            
                        </div>

                        <div class="col-lg-9">
                            <div class="main-content-wrapper">
                                <div class="page-header">
                                    <h1> Mes Réservations</h1>
                                    <p>Gérez et suivez toutes vos réservations de véhicules</p>
                                </div>

                                <div class="tabs-container">
                                    <div class="tabs-nav">
                                        <button class="tab-btn active" data-tab="active">
                                            
                                            <span>En Cours</span>
                                            <span class="tab-count">{{ $activeReservations->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="scheduled">
                                            
                                            <span>Programmées</span>
                                            <span class="tab-count">{{ $activeReservations->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="pending">
                                            
                                            <span>Expirées</span>
                                            <span class="tab-count">{{ $expiredReservations->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="expired">
                                            
                                            <span>Annulées</span>
                                            <span class="tab-count">{{ $cancelledReservations->count() }}</span>
                                        </button>
                                    </div>

                                    {{-- Onglet Réservations En Cours --}}
                                    <div class="tab-content active" id="active">
                                        @if($activeReservations->count() > 0)
                                            <div class="responsive-table">
                                                <table class="reservations-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Véhicule</th>
                                                            <th>Durée</th>
                                                            <th>Statut</th>
                                                            <th>Prix Total</th>
                                                            <th>Temps Restant</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($activeReservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    
                                                                    <div class="car-details">
                                                                        <h4>{{ $reservation->car->getFullName() }}</h4>
                                                                        <p>
                                                                            <i class="fas fa-{{ $reservation->with_driver ? 'user' : 'car' }}"></i>
                                                                            {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="duration">
                                                                    <span class="duration-days">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                                                    <span class="duration-dates">
                                                                        {{ $reservation->reservation_start_date->format('d/m/Y') }} - {{ $reservation->reservation_end_date->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @php $status = $reservation->getDetailedStatus(); @endphp
                                                                <span class="status-badge status-{{ $status['status'] }}">{{ $status['label'] }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</div>
                                                                @if($reservation->discount_percentage > 0)
                                                                    <small style="color: #6c757d;">{{ $reservation->discount_percentage }}% de réduction</small>
                                                                @else
                                                                    <small style="color: #6c757d;">Aucune réduction</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="countdown" 
                                                                    data-end="{{ $reservation->getRealEndDateTime()->format('Y-m-d H:i:s') }}">
                                                                    {{ $reservation->getTimeRemaining() }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="actions">
                                                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i> Détails
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-car-side"></i>
                                                <h3>Aucune réservation en cours</h3>
                                                <p>Vous n'avez aucune réservation active pour le moment.</p>
                                                <a href="{{ route('home') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Nouvelle réservation
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Onglet Réservations Programmées --}}
                                    <div class="tab-content" id="scheduled">
                                        @if($scheduledReservations->count() > 0)
                                            <div class="responsive-table">
                                                <table class="reservations-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Véhicule</th>
                                                            <th>Durée</th>
                                                            <th>Statut</th>
                                                            <th>Prix Total</th>
                                                            <th>Commence dans</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($scheduledReservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    @if($reservation->car->image)
                                                                        <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->getFullName() }}" class="car-image">
                                                                    @else
                                                                        <img src="https://via.placeholder.com/70x52/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
                                                                    @endif
                                                                    <div class="car-details">
                                                                        <h4>{{ $reservation->car->getFullName() }}</h4>
                                                                        <p>
                                                                            <i class="fas fa-{{ $reservation->with_driver ? 'user' : 'car' }}"></i>
                                                                            {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="duration">
                                                                    <span class="duration-days">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                                                    <span class="duration-dates">
                                                                        {{ $reservation->reservation_start_date->format('d/m/Y') }} - {{ $reservation->reservation_end_date->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="status-badge status-scheduled">Programmée</span>
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</div>
                                                                @if($reservation->discount_percentage > 0)
                                                                    <small style="color: #6c757d;">{{ $reservation->discount_percentage }}% de réduction</small>
                                                                @else
                                                                    <small style="color: #6c757d;">Aucune réduction</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="countdown countdown-scheduled" 
                                                                    data-start="{{ $reservation->getStartDateTime()->format('Y-m-d H:i:s') }}">
                                                                    Calcul...
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="actions">
                                                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i> Détails
                                                                    </a>
                                                                    @if($reservation->canBeCancelled())
                                                                        <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" 
                                                                            style="display: inline;" 
                                                                            onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger">
                                                                                <i class="fas fa-times"></i> Annuler
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-alt"></i>
                                                <h3>Aucune réservation programmée</h3>
                                                <p>Vous n'avez aucune réservation programmée pour le moment.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Onglet Réservations Expirées --}}
                                    <div class="tab-content" id="expired">
                                        @if($expiredReservations->count() > 0)
                                            <div class="responsive-table">
                                                <table class="reservations-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Véhicule</th>
                                                            <th>Durée</th>
                                                            <th>Statut</th>
                                                            <th>Prix Total</th>
                                                            <th>Date de fin</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($expiredReservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    @if($reservation->car->image)
                                                                        <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->getFullName() }}" class="car-image">
                                                                    @else
                                                                        <img src="https://via.placeholder.com/70x52/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
                                                                    @endif
                                                                    <div class="car-details">
                                                                        <h4>{{ $reservation->car->getFullName() }}</h4>
                                                                        <p>
                                                                            <i class="fas fa-{{ $reservation->with_driver ? 'user' : 'car' }}"></i>
                                                                            {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="duration">
                                                                    <span class="duration-days">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                                                    <span class="duration-dates">
                                                                        {{ $reservation->reservation_start_date->format('d/m/Y') }} - {{ $reservation->reservation_end_date->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="status-badge status-expired">Expirée</span>
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</div>
                                                                @if($reservation->discount_percentage > 0)
                                                                    <small style="color: #6c757d;">{{ $reservation->discount_percentage }}% de réduction</small>
                                                                @else
                                                                    <small style="color: #6c757d;">Aucune réduction</small>
                                                                @endif
                                                            </td>
                                                            <td>{{ $reservation->reservation_end_date->format('d/m/Y') }} à {{ $reservation->reservation_end_time }}</td>
                                                            <td>
                                                                <div class="actions">
                                                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i> Détails
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle"></i>
                                                <h3>Aucune réservation expirée</h3>
                                                <p>Vous n'avez aucune réservation expirée.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Onglet Réservations Annulées --}}
                                    <div class="tab-content" id="cancelled">
                                        @if($cancelledReservations->count() > 0)
                                            <div class="responsive-table">
                                                <table class="reservations-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Véhicule</th>
                                                            <th>Durée</th>
                                                            <th>Statut</th>
                                                            <th>Prix Total</th>
                                                            <th>Date d'annulation</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($cancelledReservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    <img src="{{ $reservation->car->image_url ?? 'https://via.placeholder.com/60x45' }}" 
                                                                        alt="{{ $reservation->car->getFullName() }}" class="car-image">
                                                                    <div class="car-details">
                                                                        <h4>{{ $reservation->car->getFullName() }}</h4>
                                                                        <p>
                                                                            <i class="fas fa-{{ $reservation->with_driver ? 'user' : 'car' }}"></i> 
                                                                            {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="duration">
                                                                    <span class="duration-days">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                                                    <span class="duration-dates">
                                                                        {{ $reservation->reservation_start_date->format('d/m') }} - 
                                                                        {{ $reservation->reservation_end_date->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="status-badge status-cancelled">Annulée</span>
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</div>@if($reservation->discount_percentage > 0)
                                                                    <small style="color: #6c757d;">{{ $reservation->discount_percentage }}% de réduction</small>
                                                                @else
                                                                    <small style="color: #6c757d;">Aucune réduction</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $reservation->cancelled_at ? $reservation->cancelled_at->format('d/m/Y à H:i') : 'Non spécifiée' }}
                                                                @if($reservation->cancellation_reason)
                                                                    <br><small style="color: #6c757d;">{{ $reservation->cancellation_reason }}</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="actions">
                                                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i> Détails
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            {{-- Pagination pour les réservations annulées --}}
                                            @if($cancelledReservations->hasPages())
                                                <div class="d-flex justify-content-center mt-4">
                                                    {{ $cancelledReservations->links() }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-ban"></i>
                                                <h3>Aucune réservation annulée</h3>
                                                <p>Vous n'avez annulé aucune réservation.</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- content close -->

        <a href="{{ asset('#') }}" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('partials.footer')
        <!-- footer close -->
        
    </div>

    <!-- Javascript Files -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des onglets
            document.querySelectorAll('.tab-btn').forEach(button => {
                button.addEventListener('click', () => {
                    // Retirer la classe active de tous les boutons et contenus
                    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                    
                    // Ajouter la classe active au bouton cliqué et au contenu correspondant
                    button.classList.add('active');
                    document.getElementById(button.dataset.tab).classList.add('active');
                });
            });

            // Mise à jour des comptes à rebours
            function updateCountdowns() {
                document.querySelectorAll('.countdown').forEach(countdown => {
                    const endDate = countdown.dataset.end;
                    const startDate = countdown.dataset.start;
                    
                    if (endDate) {
                        // Pour les réservations en cours
                        const end = new Date(endDate).getTime();
                        const now = new Date().getTime();
                        const distance = end - now;

                        if (distance < 0) {
                            countdown.innerHTML = 'Expiré';
                            countdown.classList.add('countdown-ended');
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        
                        if (days > 0) {
                            countdown.innerHTML = `${days}j ${hours}h ${minutes}m`;
                        } else {
                            countdown.innerHTML = `${hours}h ${minutes}m`;
                        }
                    } else if (startDate) {
                        // Pour les réservations programmées
                        const start = new Date(startDate).getTime();
                        const now = new Date().getTime();
                        const distance = start - now;

                        if (distance < 0) {
                            countdown.innerHTML = 'Commencée';
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        
                        if (days > 0) {
                            countdown.innerHTML = `${days}j ${hours}h ${minutes}m`;
                        } else {
                            countdown.innerHTML = `${hours}h ${minutes}m`;
                        }
                    }
                });
            }

            // Mettre à jour les comptes à rebours toutes les minutes
            updateCountdowns();
            setInterval(updateCountdowns, 60000);
        });

        // Mise à jour des comptes à rebours pour les réservations programmées
        function updateStartCountdowns() {
            document.querySelectorAll('.countdown-start').forEach(countdown => {
                const startDate = countdown.dataset.start;
                if (!startDate) return;

                const start = new Date(startDate).getTime();
                const now = new Date().getTime();
                const distance = start - now;

                if (distance < 0) {
                    countdown.innerHTML = 'Commencée';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                
                if (days > 0) {
                    countdown.innerHTML = ${days}j ${hours}h ${minutes}m;
                } else if (hours > 0) {
                    countdown.innerHTML = ${hours}h ${minutes}m;
                } else {
                    countdown.innerHTML = ${minutes}m;
                }
            });
        }

        // Ajoutez cet appel dans votre script existant
        updateStartCountdowns();
        setInterval(updateStartCountdowns, 60000);
    </script>
</body>

</html>