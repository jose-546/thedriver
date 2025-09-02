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
<style>
    /* Variables CSS pour cohérence */
    :root {

        --secondary-color: #64748b;
        --success-color: #10b981;
        --warning-color: #ffb400;
        --danger-color: #ef4444;
        --purple-color: #860000;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --white: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --border-radius: 0.75rem;
        --border-radius-sm: 0.5rem;
        --border-radius-lg: 1rem;
    }

    /* Layout principal */
    .dashboard-layout {
        display: flex;
        min-height: 100vh;
        background-color: var(--gray-50);
    }


    /* Main content */
    .dashboard-main {
        flex: 1;
        margin-left: 280px;
        padding: 2rem;
        max-width: calc(100vw - 280px);
    }

    /* Header du contenu principal */
    .main-header {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
    }

    .main-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 0.5rem;
    }

    .main-subtitle {
        color: var(--gray-600);
        margin: 0;
        font-size: 1.1rem;
    }

    /* Grid pour les stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--purple-color));
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stats-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stats-info h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 0.5rem;
        line-height: 1;
    }

    .stats-info p {
        color: var(--gray-600);
        margin: 0;
        font-weight: 500;
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0.8;
    }

    .stats-blue { color: var(--primary-color); }
    .stats-yellow { color: var(--warning-color); }
    .stats-green { color: var(--success-color); }
    .stats-purple { color: var(--purple-color); }

    .stats-blue .stats-icon { background: rgba(59, 130, 246, 0.1); }
    .stats-yellow .stats-icon { background: rgba(245, 158, 11, 0.1); }
    .stats-green .stats-icon { background: rgba(16, 185, 129, 0.1); }
    .stats-purple .stats-icon { background: rgba(139, 92, 246, 0.1); }

    /* Section cards */
    .section-card {
        background: var(--white);
        border-radius: var(--border-radius);
        border : 1px solid #860000;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        background: #860000;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-content {
        padding: 2rem;
    }

    /* Actions rapides */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-card {
        background: var(--white);
        border: 2px solid var(--gray-200);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .action-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    .action-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--white);
    }

    .action-card-text {
        font-weight: 600;
        color: var(--gray-900);
        margin: 0;
    }

    .action-blue .action-card-icon { background: var(--primary-color); }
    .action-green .action-card-icon { background: var(--success-color); }
    .action-gray .action-card-icon { background: var(--gray-500); }

    .action-blue:hover .action-card-text { color: var(--primary-color); }
    .action-green:hover .action-card-text { color: var(--success-color); }
    .action-gray:hover .action-card-text { color: var(--gray-500); }

    /* Réservations actives */
    .active-reservation {
        background: #cfcfcf26;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

   

    .reservation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .reservation-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .reservation-subtitle {
        color: var(--gray-600);
        margin: 0.5rem 0 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-active {
        background-color: #198754;
        color: white;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-expired {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .status-scheduled {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-urgent {
        background-color: #fee2e2;
        color: #991b1b;
        animation: pulse 2s infinite;
    }

    .status-warning {
        background-color: #fed7aa;
        color: #9a3412;
    }

    /* Timing info */
    .timing-info {
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-sm);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .timing-info h5 {
        margin: 0 0 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .timing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
    }

    .timing-item {
        text-align: center;
        padding: 1rem;
        background: var(--white);
        border-radius: var(--border-radius-sm);
        border: 1px solid var(--gray-200);
    }

    .timing-label {
        display: block;
        font-size: 0.75rem;
        color: var(--gray-500);
        font-weight: 500;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .timing-value {
        font-size: 1.125rem;
        color: var(--gray-900);
        font-weight: 700;
    }

    /* Progress bar */
    .progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .progress-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .progress-date {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .progress-bar {
        width: 100%;
        height: 12px;
        background-color: var(--gray-200);
        border-radius: 9999px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--purple-color));
        transition: width 1s ease-in-out;
        border-radius: 9999px;
    }

    .progress-fill.urgent {
        background: linear-gradient(90deg, var(--danger-color), #dc2626);
        animation: pulse 2s infinite;
    }

    .progress-fill.warning {
        background: linear-gradient(90deg, var(--warning-color), #ffb400);
    }

    .countdown-timer {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: var(--border-radius-sm);
        border: 1px solid var(--gray-200);
        font-family: 'Outfit', monospace;
        letter-spacing: 0.1em;
    }

    .countdown-timer.text-red {
        color: var(--danger-color);
        animation: pulse 2s infinite;
    }

    .countdown-timer.text-blue {
        color: var(--primary-color);
    }

    .countdown-timer.text-orange {
        color: var(--warning-color);
    }

    .countdown-timer.text-green {
        color: #198754;
    }

    /* Actions des réservations */
    .reservation-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .reservation-price {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn-sm {
        padding: 0.50rem 1.5rem;
        font-size: 0.875rem;
        border-radius: var(--border-radius-sm);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-blue {
        background-color: var(--primary-color);
        color: var(--white);
    }

    .btn-blue:hover {
        color: #fff;
        -webkit-box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326); /* #860000 en rgba */
        -moz-box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326);
        box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326);
    }

    .bg-orange-500 {
        background-color: black;
        color: var(--white);
    }

    .btn-orange:hover {
            color: #fff;
            -webkit-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
        }

    .bg-gray-200 {
        background-color: var(--gray-200);
        color: var(--gray-500);
        cursor: not-allowed;
    }


    /* État vide */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--gray-400);
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--gray-600);
        margin-bottom: 2rem;
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .dashboard-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .dashboard-sidebar.open {
            transform: translateX(0);
        }

        .dashboard-main {
            margin-left: 0;
            max-width: 100vw;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .timing-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-main {
            padding: 1rem;
        }

        .main-header {
            padding: 1.5rem;
        }

        .section-content {
            padding: 1.5rem;
        }

        .active-reservation {
            padding: 1.5rem;
        }

        .reservation-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .reservation-actions {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
        }

        .timing-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
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
            
          

            <section id="section-cars" class="bg-gray-100">
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
                            <!-- Statistiques rapides -->
                            <div class="row">
                                <div class="col-lg-3 col-6 mb25 order-sm-1">
                                    <div class="card p-4 rounded-5">
                                        <div class="symbol mb40">
                                            <i class="fa id-color fa-2x fa-calendar-check-o"></i>
                                        </div>
                                        <span class="hee1 mb0">
                                        @php
                                            $activeCount = auth()->user()->reservations()
                                                ->where('status', 'active')
                                                ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()])
                                                ->whereRaw("CONCAT(reservation_start_date, ' ', reservation_start_time) <= ?", [now()])
                                                ->count();
                                        @endphp
                                                {{ $activeCount }}
                                        </span>
                                        <span class="text-gray">Actives</span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6 mb25 order-sm-1">
                                    <div class="card p-4 rounded-5">
                                        <div class="symbol mb40">
                                            <i class="fa id-color fa-2x fa-tags"></i>
                                        </div>
                                        <span class="hee1 mb0">0</span>
                                        <span class="text-gray">Annulées</span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6 mb25 order-sm-1">
                                    <div class="card p-4 rounded-5">
                                        <div class="symbol mb40">
                                            <i class="fa id-color fa-2x fa-calendar"></i>
                                        </div>
                                        <span class="hee1 mb0">
                                            {{ auth()->user()->reservations()->count() }}
                                        </span>
                                        <span class="text-gray">Total réservations</span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6 mb25 order-sm-1">
                                    <div class="card p-4 rounded-5">
                                        <div class="symbol mb40">
                                            <i class="fa id-color fa-2x fa-calendar-times-o"></i>
                                        </div>
                                        <span class="hee1 mb0">
                                            {{ number_format(auth()->user()->reservations()->where('payment_status', 'paid')->sum('final_total'), 0, ',', ' ') }}
                                        </span>
                                        <span class="text-gray">FCFA dépensés</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Réservations actives avec compte à rebours -->
                            @php
                                $activeReservations = auth()->user()->reservations()
                                    ->with('car')
                                    ->where('status', 'active')
                                    ->whereRaw("CONCAT(reservation_end_date, ' ', reservation_end_time) > ?", [now()])
                                    ->orderBy('reservation_end_date', 'asc')
                                    ->orderBy('reservation_end_time', 'asc')
                                    ->get();
                            @endphp

                            @if($activeReservations->count() > 0)
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">
                                            Réservations en cours
                                        </h3>
                                    </div>
                                    <div class="section-content">
                                        @foreach($activeReservations as $reservation)
                                            @php
                                                $startDateTime = $reservation->getStartDateTime();
                                                $endDateTime = $reservation->getEndDateTime();
                                                $now = \Carbon\Carbon::now();
                                                
                                                // Calculer les informations de timing
                                                $totalDurationHours = $startDateTime->diffInHours($endDateTime);
                                                $remainingHours = $endDateTime->diffInHours($now);
                                                $progressPercentage = $totalDurationHours > 0 ? min(100, ($startDateTime->diffInHours($now) / $totalDurationHours) * 100) : 0;
                                                
                                                // Déterminer le statut détaillé
                                                $remainingMinutes = $endDateTime->diffInMinutes($now);
                                                if ($remainingMinutes < 60) {
                                                    $detailedStatus = ['status' => 'urgent', 'label' => 'Urgent'];
                                                } elseif ($remainingMinutes < 180) { // moins de 3h
                                                    $detailedStatus = ['status' => 'warning', 'label' => 'Attention'];
                                                } else {
                                                    $detailedStatus = ['status' => 'active', 'label' => 'Active'];
                                                }
                                            @endphp
                                            
                                            <div class="active-reservation" 
                                                data-reservation-id="{{ $reservation->id }}"
                                                data-end-date="{{ $endDateTime->toISOString() }}"
                                                data-start-date="{{ $startDateTime->toISOString() }}"
                                                data-is-scheduled="0">
                                                
                                                <div class="reservation-header">
                                                    <div>
                                                        <h4 class="reservation-title">
                                                            {{ $reservation->car->brand }} {{ $reservation->car->model }}
                                                        </h4>
                                                        <p class="reservation-subtitle">
                                                            {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <span class="status-badge status-{{ $detailedStatus['status'] }}">
                                                            {{ $detailedStatus['label'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Informations de timing détaillées -->
                                                <div class="timing-info">
                                                    <h5>Informations de timing</h5>
                                                    <div class="timing-grid">
                                                        <div class="timing-item">
                                                            <span class="timing-label">Durée totale</span>
                                                            <span class="timing-value">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                                        </div>
                                                        <div class="timing-item">
                                                            <span class="timing-label">Progression</span>
                                                            <span class="timing-value">{{ number_format($progressPercentage, 1) }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Compte à rebours -->
                                                <div class="progress-section">
                                                    <div class="progress-header">
                                                        <span class="progress-label">Temps restant</span>
                                                        <span class="progress-date">
                                                            Fin: {{ $endDateTime->format('d/m/Y H:i') }}
                                                        </span>
                                                    </div>
                                                    
                                                    <!-- Barre de progression -->
                                                    <div class="progress-bar">
                                                        <div class="progress-fill 
                                                            @if($detailedStatus['status'] === 'urgent') urgent
                                                            @elseif($detailedStatus['status'] === 'warning') warning
                                                            @endif"
                                                            style="width: {{ $progressPercentage }}%">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Affichage du temps restant -->
                                                    <div class="countdown-timer 
                                                        @if($detailedStatus['status'] === 'urgent') text-red
                                                        @elseif($detailedStatus['status'] === 'warning') text-orange
                                                        @else text-green
                                                        @endif">
                                                        00h-00m-00s
                                                    </div>
                                                </div>

                                                <!-- Actions -->
                                                <div class="reservation-actions">
                                                    <div class="reservation-price">
                                                        {{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA
                                                    </div>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('reservations.show', $reservation) }}" class="btn-sm btn-blue">
                                                            <i class="fas fa-eye"></i>
                                                            Détails
                                                        </a>
                                                        
                                                        {{-- Bouton PROLONGER - Toujours visible pour les réservations actives 
                                                        @if($reservation->status === 'active')
                                                            @php
                                                                $remainingSeconds = $endDateTime->diffInSeconds($now);
                                                                $canExtend = $remainingSeconds >= 3600; // >= 1 heure
                                                                $remainingHoursForButton = floor($remainingSeconds / 3600);
                                                                $remainingMinutesForButton = floor(($remainingSeconds % 3600) / 60);
                                                                $remainingSecondsDisplay = $remainingSeconds % 60;
                                                            @endphp
                                                            
                                                            @if($canExtend)
                                                                {{-- Bouton ACTIF si >= 1h 
                                                                <a href="{{ route('reservations.form', $reservation) }}" 
                                                                class="btn-sm bg-orange-500"
                                                                title="Temps restant: {{ $remainingHoursForButton }}h {{ $remainingMinutesForButton }}m {{ $remainingSecondsDisplay }}s">
                                                                    <i class="fas fa-clock"></i> Prolonger
                                                                </a>
                                                            @else
                                                                {{-- Bouton INACTIF (grisé) si < 1h 
                                                                <span class="btn-sm bg-gray-200"
                                                                    title="Prolongation bloquée : il reste {{ $remainingMinutesForButton }}m {{ $remainingSecondsDisplay }}s (minimum requis : 1h)">
                                                                    <i class="fas fa-clock"></i> Prolonger
                                                                </span>
                                                            @endif
                                                        @endif
                                                        --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                             <!-- Réservations récentes -->
                            @php
                                $recentReservations = auth()->user()->reservations()
                                    ->with('car')
                                    ->whereIn('status', ['active', 'expired', 'completed'])
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp

                                            @if($recentReservations->count() > 0)
                                            <h4>Mes réservations récentes</h4>
                                            <table class="table de-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Véhicule</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">N° Plaque</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Jours</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Montant</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Début</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Fin</span></th>
                                                        <th scope="col"><span class="text-uppercase fs-12 text-gray">Status</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentReservations as $reservation)
                                                        @php
                                                            $now = now();
                                                            $startDateTime = $reservation->getStartDateTime();
                                                            $endDateTime = $reservation->getEndDateTime();
                                                            
                                                            if ($endDateTime <= $now) {
                                                                $detailedStatus = [
                                                                    'status' => 'expired',
                                                                    'label' => 'Expiré',
                                                                    'color' => 'danger' // Bootstrap utilise bg-danger
                                                                ];
                                                            }
                                                            elseif ($startDateTime > $now) {
                                                                $detailedStatus = [
                                                                    'status' => 'scheduled',
                                                                    'label' => 'Programmé',
                                                                    'color' => 'primary' // bg-primary
                                                                ];
                                                            }
                                                            else {
                                                                $detailedStatus = [
                                                                    'status' => 'active',
                                                                    'label' => 'En cours',
                                                                    'color' => 'success' // bg-success
                                                                ];
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <span class="d-lg-none d-sm-block">Véhicule</span>
                                                                <div class="hb1 bg-gray-100 text-dark">
                                                                    {{ $reservation->car->name }} {{ $reservation->car->model }}
                                                                </div>
                                                            </td>
                                                            <td><span class="d-lg-none d-sm-block">N° Plaque</span>{{ $reservation->car->license_plate }}</td>
                                                            <td><span class="d-lg-none d-sm-block">Jours</span>{{ $reservation->total_days }} Jours</td>
                                                            <td><span class="d-lg-none d-sm-block">Montant</span>{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</td>
                                                            <td><span class="d-lg-none d-sm-block">Début</span>{{ $startDateTime->format('d/m/Y H:i') }}</td>
                                                            <td><span class="d-lg-none d-sm-block">Fin</span>{{ $endDateTime->format('d/m/Y H:i') }}</td>
                                                            <td>
                                                                <div class="badge rounded-pill bg-{{ $detailedStatus['color'] }}">
                                                                    {{ $detailedStatus['label'] }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif


                            @if($recentReservations->count() == 0)
                                <div class="section-card">
                                    <div class="section-content">
                                        <div class="empty-state">
                                            <i class="fas fa-car"></i>
                                            <h4>Aucune réservation</h4>
                                            <p>Vous n'avez pas encore effectué de réservation.</p>
                                            <a href="{{ route('home') }}" class="action-card action-blue" style="display: inline-flex; width: auto;">
                                                <div class="action-card-icon">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <p class="action-card-text">Faire une réservation</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

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


    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

    <script>
        // Script pour le dashboard avec mise à jour en temps réel
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard script chargé');
            // Collecter toutes les réservations avec leurs informations
            const reservations = [];
            document.querySelectorAll('.active-reservation').forEach(element => {
                const reservationId = element.dataset.reservationId;
                const endDate = element.dataset.endDate;
                const startDate = element.dataset.startDate;
                
                if (endDate && reservationId) {
                    reservations.push({
                        id: reservationId,
                        element: element,
                        endDate: new Date(endDate),
                        startDate: startDate ? new Date(startDate) : null,
                        isScheduled: element.dataset.isScheduled === '1'
                    });
                }
            });
            
            console.log(`${reservations.length} réservations trouvées pour le suivi`);
            
            // Fonction pour calculer et formater le temps restant
            function calculateTimeRemaining(targetDate, isScheduled = false) {
                const now = new Date();
                const diff = targetDate - now;
                
                if (diff <= 0) {
                    return {
                        formatted: '00h-00m-00s',
                        status: 'expired',
                        className: 'text-red'
                    };
                }
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                let formatted;
                let status;
                let className;
                
                if (isScheduled) {
                    // Pour les réservations programmées
                    className = 'text-blue';
                    status = 'scheduled';
                    
                    if (days > 0) {
                        formatted = `${days}j ${hours.toString().padStart(2, '0')}h ${minutes.toString().padStart(2, '0')}m`;
                    } else {
                        formatted = `${hours.toString().padStart(2, '0')}h-${minutes.toString().padStart(2, '0')}m-${seconds.toString().padStart(2, '0')}s`;
                    }
                } else {
                    // Pour les réservations actives
                    const totalMinutes = Math.floor(diff / (1000 * 60));
                    
                    if (totalMinutes < 60) {
                        status = 'urgent';
                        className = 'text-red';
                    } else if (totalMinutes < 180) {
                        status = 'warning';
                        className = 'text-orange';
                    } else {
                        status = 'active';
                        className = 'text-green';
                    }
                    
                    if (days > 0) {
                        formatted = `${days}j-${hours.toString().padStart(2, '0')}h-${minutes.toString().padStart(2, '0')}m-${seconds.toString().padStart(2, '0')}s`;
                    } else {
                        formatted = `${hours.toString().padStart(2, '0')}h-${minutes.toString().padStart(2, '0')}m-${seconds.toString().padStart(2, '0')}s`;
                    }
                }
                
                return { formatted, status, className };
            }
            
            // Fonction pour mettre à jour les comptes à rebours
            function updateCountdowns() {
                reservations.forEach(reservation => {
                    const countdownElement = reservation.element.querySelector('.countdown-timer');
                    const statusBadge = reservation.element.querySelector('.status-badge');
                    const progressFill = reservation.element.querySelector('.progress-fill');
                    
                    if (!countdownElement) return;
                    
                    const targetDate = reservation.isScheduled ? reservation.startDate : reservation.endDate;
                    const timeInfo = calculateTimeRemaining(targetDate, reservation.isScheduled);
                    
                    // Mettre à jour le texte du countdown
                    countdownElement.textContent = timeInfo.formatted;
                    
                    // Mettre à jour les classes CSS
                    countdownElement.className = `countdown-timer ${timeInfo.className}`;
                    
                    // Mettre à jour le badge de statut pour les réservations actives
                    if (statusBadge && !reservation.isScheduled) {
                        statusBadge.className = `status-badge status-${timeInfo.status}`;
                        
                        const statusLabels = {
                            'urgent': 'Urgent',
                            'warning': 'Attention', 
                            'active': 'Active',
                            'expired': 'Expiré'
                        };
                        
                        statusBadge.textContent = statusLabels[timeInfo.status] || 'Active';
                    }
                    
                    // Mettre à jour la barre de progression pour les réservations actives
                    if (progressFill && !reservation.isScheduled && reservation.startDate) {
                        const now = new Date();
                        const totalDuration = reservation.endDate - reservation.startDate;
                        const elapsed = now - reservation.startDate;
                        const progress = Math.min(100, Math.max(0, (elapsed / totalDuration) * 100));
                        
                        progressFill.style.width = `${progress}%`;
                        progressFill.className = `progress-fill ${timeInfo.status === 'urgent' ? 'urgent' : timeInfo.status === 'warning' ? 'warning' : ''}`;
                    }
                });
                
                // Mettre à jour les boutons prolonger
                updateExtendButtons();
            }
            
            // Fonction pour mettre à jour l'état du bouton prolonger
            function updateExtendButtons() {
                reservations.forEach(reservation => {
                    if (!reservation.isScheduled) { // Seulement pour les réservations actives
                        const extendButton = reservation.element.querySelector('a[href*="extend"], span[title*="Prolongation"]');
                        
                        if (extendButton) {
                            const now = new Date();
                            const remainingSeconds = Math.max(0, Math.floor((reservation.endDate - now) / 1000));
                            const canExtend = remainingSeconds >= 3600; // >= 1 heure
                            
                            const remainingHours = Math.floor(remainingSeconds / 3600);
                            const remainingMinutes = Math.floor((remainingSeconds % 3600) / 60);
                            const remainingSecondsDisplay = remainingSeconds % 60;
                            
                            if (canExtend) {
                                // Bouton actif
                                if (extendButton.tagName === 'SPAN') {
                                    // Convertir span en lien
                                    const newButton = document.createElement('a');
                                    newButton.href = extendButton.getAttribute('data-extend-url') || `/reservations/${reservation.id}/extend/form`;
                                    newButton.className = 'btn-sm bg-orange-500';
                                    newButton.title = `Temps restant: ${remainingHours}h ${remainingMinutes}m ${remainingSecondsDisplay}s`;
                                    newButton.innerHTML = '<i class="fas fa-clock"></i> Prolonger';
                                    extendButton.replaceWith(newButton);
                                } else {
                                    // Mettre à jour le titre
                                    extendButton.title = `Temps restant: ${remainingHours}h ${remainingMinutes}m ${remainingSecondsDisplay}s`;
                                    extendButton.className = 'btn-sm bg-orange-500';
                                }
                            } else {
                                // Bouton inactif
                                if (extendButton.tagName === 'A') {
                                    // Convertir lien en span
                                    const newButton = document.createElement('span');
                                    newButton.className = 'btn-sm bg-gray-200';
                                    newButton.title = `Prolongation bloquée : il reste ${remainingMinutes}m ${remainingSecondsDisplay}s (minimum requis : 1h)`;
                                    newButton.innerHTML = '<i class="fas fa-clock"></i> Prolonger';
                                    newButton.setAttribute('data-extend-url', extendButton.href);
                                    extendButton.replaceWith(newButton);
                                } else {
                                    // Mettre à jour le titre
                                    extendButton.title = `Prolongation bloquée : il reste ${remainingMinutes}m ${remainingSecondsDisplay}s (minimum requis : 1h)`;
                                    extendButton.className = 'btn-sm bg-gray-200';
                                }
                            }
                        }
                    }
                });
            }
            
            // Démarrer les mises à jour si il y a des réservations
            if (reservations.length > 0) {
                console.log('⏰ Démarrage du suivi temps réel...');
                
                // Première mise à jour immédiate
                updateCountdowns();
                
                // Mise à jour toutes les secondes
                const intervalId = setInterval(updateCountdowns, 1000);
                
                // Nettoyer l'intervalle si la page est fermée
                window.addEventListener('beforeunload', function() {
                    clearInterval(intervalId);
                });
                
                console.log('Suivi temps réel activé');
            } else {
                console.log('Aucune réservation active à suivre');
            }
        });
    </script>

</body>

</html>