
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
    <!-- CSS Files
    ================================================== -->
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
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        color: white;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .tabs-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .tabs-nav {
        display: flex;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .tab-btn {
        flex: 1;
        padding: 20px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
        position: relative;
    }

    .tab-btn:hover {
        background: #e9ecef;
        color: #495057;
    }

    .tab-btn.active {
        background: white;
        color: #007bff;
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #007bff;
    }

    .tab-count {
        display: inline-block;
        background: #6c757d;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-left: 8px;
    }

    .tab-btn.active .tab-count {
        background: #007bff;
    }

    .tab-content {
        display: none;
        padding: 30px;
    }

    .tab-content.active {
        display: block;
    }

    .reservations-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .reservations-table th {
        background: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .reservations-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .reservations-table tr:hover {
        background: #f8f9fa;
    }

    .car-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .car-image {
        width: 60px;
        height: 45px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }

    .car-details h4 {
        margin: 0;
        font-size: 1rem;
        color: #212529;
    }

    .car-details p {
        margin: 0;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-scheduled {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-expired {
        background: #f8d7da;
        color: #721c24;
    }

    .status-cancelled {
        background: #f1f3f4;
        color: #6c757d;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #28a745;
    }

    .duration {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .duration-days {
        font-weight: 600;
        color: #495057;
    }

    .duration-dates {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .countdown {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        text-align: center;
        min-width: 120px;
    }

    .countdown-ended {
        background: #6c757d;
    }

    .countdown-scheduled {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        text-decoration: none;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #1e7e34;
        text-decoration: none;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        color: #495057;
    }

    .responsive-table {
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .tabs-nav {
            flex-wrap: wrap;
        }
        
        .tab-btn {
            flex: 1 1 50%;
            min-width: 150px;
        }
        
        .reservations-table {
            font-size: 0.9rem;
        }
        
        .reservations-table th,
        .reservations-table td {
            padding: 10px 8px;
        }
        
        .actions {
            flex-direction: column;
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

            <section id="section-cars" style="background-color: #f3f4f6;">
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
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-sign-out"></i> Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="col-lg-9">
                                <div class="main-content-wrapper">
                            <div class="container-fluid ">
                                <div class="page-header">
                                    <h1><i class="fas fa-car"></i> Mes Réservations</h1>
                                    <p>Gérez et suivez toutes vos réservations de véhicules</p>
                                </div>

                                <div class="tabs-container">
                                    <div class="tabs-nav">
                                        <button class="tab-btn active" data-tab="active">
                                            <i class="fas fa-play-circle"></i> En Cours
                                            <span class="tab-count">{{ $activeReservations->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="scheduled">
                                            <i class="fas fa-clock"></i> Programmées  
                                            <span class="tab-count">{{ $activeReservations->where('isScheduled', true)->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="pending">
                                            <i class="fas fa-hourglass-half"></i> En attente
                                            <span class="tab-count">{{ $pendingReservations->count() }}</span>
                                        </button>
                                        <button class="tab-btn" data-tab="expired">
                                            <i class="fas fa-times-circle"></i> Expirées
                                            <span class="tab-count">{{ $pastReservations->where('status', 'expired')->count() }}</span>
                                        </button>
                                    </div>

                                    {{-- Onglet Réservations En Cours --}}
                                    <div class="tab-content active" id="active">
                                        @if($activeReservations->where('isActive', true)->count() > 0)
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
                                                        @foreach($activeReservations->where('isActive', true) as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    @if($reservation->car->image)
                                                                        <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->getFullName() }}" class="car-image">
                                                                    @else
                                                                        <img src="https://via.placeholder.com/60x45/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
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
                                                            {{--       @if($reservation->canBeExtended())
                                                                        <a href="{{ route('reservations.extend.form', $reservation) }}" class="btn btn-success">
                                                                            <i class="fas fa-plus-circle"></i> Prolonger
                                                                        </a>
                                                                    @endif --}}
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
                                                <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus"></i> Nouvelle réservation
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Onglet Réservations Programmées --}}
                                    <div class="tab-content" id="scheduled">
                                        @php $scheduledReservations = $activeReservations->where('isScheduled', true); @endphp
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
                                                                        <img src="https://via.placeholder.com/60x45/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
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

                                    {{-- Onglet Réservations En Attente --}}
                                    <div class="tab-content" id="pending">
                                        @if($pendingReservations->count() > 0)
                                            <div class="responsive-table">
                                                <table class="reservations-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Véhicule</th>
                                                            <th>Durée</th>
                                                            <th>Statut</th>
                                                            <th>Prix Total</th>
                                                            <th>Créée le</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pendingReservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="car-info">
                                                                    @if($reservation->car->image)
                                                                        <img src="{{ asset('storage/' . $reservation->car->image) }}" alt="{{ $reservation->car->getFullName() }}" class="car-image">
                                                                    @else
                                                                        <img src="https://via.placeholder.com/60x45/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
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
                                                                <span class="status-badge status-pending">En attente</span>
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</div>
                                                                @if($reservation->discount_percentage > 0)
                                                                    <small style="color: #6c757d;">{{ $reservation->discount_percentage }}% de réduction</small>
                                                                @else
                                                                    <small style="color: #6c757d;">Aucune réduction</small>
                                                                @endif
                                                            </td>
                                                            <td>{{ $reservation->created_at->format('d/m/Y à H:i') }}</td>
                                                            <td>
                                                                <div class="actions">
                                                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-primary">
                                                                        <i class="fas fa-eye"></i> Détails
                                                                    </a>
                                                                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" 
                                                                        style="display: inline;" 
                                                                        onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="fas fa-times"></i> Annuler
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-hourglass-half"></i>
                                                <h3>Aucune réservation en attente</h3>
                                                <p>Vous n'avez aucune réservation en attente de paiement.</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Onglet Réservations Expirées --}}
                                    <div class="tab-content" id="expired">
                                        @php $expiredReservations = $pastReservations->where('status', 'expired'); @endphp
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
                                                                        <img src="https://via.placeholder.com/60x45/e9ecef/495057?text=Car" alt="Voiture" class="car-image">
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
                                </div>
                            </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>

            </div>
    </div>
        <!-- content close -->

        <a href="{{ asset('#') }}" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('partials.footer')
        <!-- footer close -->
        
    </div>


    <!-- Javascript Files
    ================================================== -->
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
    </script>
</body>

</html>

