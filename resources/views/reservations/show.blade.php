
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
        /* Styles pour remplacer les classes Tailwind */
        .tw-container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
        }
        
        .tw-mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .tw-px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .tw-px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .tw-py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .tw-py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .tw-p-6 {
            padding: 1.5rem;
        }
        
        .tw-p-4 {
            padding: 1rem;
        }
        
        .tw-p-3 {
            padding: 0.75rem;
        }
        
        .tw-pt-0\.5 {
            padding-top: 0.125rem;
        }
        
        .tw-mb-4 {
            margin-bottom: 1rem;
        }
        
        .tw-mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .tw-mb-1 {
            margin-bottom: 0.25rem;
        }
        
        .tw-mt-3 {
            margin-top: 0.75rem;
        }
        
        .tw-mr-2 {
            margin-right: 0.5rem;
        }
        
        .tw-mr-1 {
            margin-right: 0.25rem;
        }
        
        .tw-space-y-6 > * + * {
            margin-top: 1.5rem;
        }
        
        .tw-space-y-3 > * + * {
            margin-top: 0rem;
        }
        
        .tw-space-y-4 > * + * {
            margin-top: 1rem;
        }
        
        .tw-space-x-6 > * + * {
            margin-left: 1.5rem;
        }
        
        .tw-space-x-3 > * + * {
            margin-left: 0.75rem;
        }
        
        .tw-space-x-2 > * + * {
            margin-left: 0.5rem;
        }
        
        .tw-grid {
            display: grid;
        }
        
        .tw-grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .tw-grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .tw-grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        @media (min-width: 1024px) {
            .tw-lg-grid-cols-3 {
                grid-template-columns: 1fr 350px;
            }
        }
        
        .tw-gap-8 {
            gap: 2rem;
        }
        
        .tw-gap-6 {
            gap: 1.5rem;
        }
        
        .tw-gap-4 {
            gap: 1rem;
        }
        
        .tw-gap-2 {
            gap: 0.5rem;
        }
        
        .tw-flex {
            display: flex;
        }
        
        .tw-inline-flex {
            display: inline-flex;
        }
        
        .tw-items-start {
            align-items: flex-start;
        }
        
        .tw-items-center {
            align-items: center;
        }
        
        .tw-items-stretch {
            align-items: stretch;
        }
        
        .tw-justify-center {
            justify-content: center;
        }
        
        .tw-justify-between {
            justify-content: space-between;
        }
        
        .tw-flex-1 {
            flex: 1 1 0%;
        }
        
        .tw-flex-col {
            flex-direction: column;
        }
        
        .tw-w-full {
            width: 100%;
        }
        
        .tw-w-32 {
            width: 8rem;
        }
        
        .tw-w-24 {
            width: 6rem;
        }
        
        .tw-w-8 {
            width: 2rem;
        }
        
        .tw-w-5 {
            width: 1.25rem;
        }
        
        .tw-w-4 {
            width: 1rem;
        }
        
        .tw-w-3 {
            width: 0.75rem;
        }
        
        .tw-w-2 {
            width: 0.5rem;
        }
        
        .tw-h-32 {
            height: 8rem;
        }
        
        .tw-h-24 {
            height: 6rem;
        }
        
        .tw-h-8 {
            height: 2rem;
        }
        
        .tw-h-5 {
            height: 1.25rem;
        }
        
        .tw-h-4 {
            height: 1rem;
        }
        
        .tw-h-3 {
            height: 0.75rem;
        }
        
        .tw-h-2 {
            height: 0.5rem;
        }
        
        .tw-object-cover {
            object-fit: cover;
        }
        
        .tw-rounded-xl {
            border-radius: 0.75rem;
        }
        
        .tw-rounded-lg {
            border-radius: 0.5rem;
        }
        
        .tw-rounded-full {
            border-radius: 9999px;
        }
        
        .tw-border {
            border-width: 1px;
            border-style: solid;
        }
        
        .tw-shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .tw-bg-white {
            background-color: #fff;
        }
        
        .tw-bg-blue-50 {
            background-color: #eff6ff;
        }
        
        .tw-bg-blue-600 {
            background-color: #860000;
        }
        
        .tw-bg-red-600 {
            background-color: #dc2626;
        }
        
        .tw-bg-green-600 {
            background-color: #16a34a;
        }
        
        .tw-bg-gray-600 {
            background-color: #121212;
        }
        
        .tw-bg-gray-50 {
            background-color: #f9fafb;
        }
        
        .tw-bg-gray-200 {
            background-color: #e5e7eb;
        }
        
        .tw-bg-green-100 {
            background-color: #dcfce7;
        }
        
        .tw-bg-yellow-100 {
            background-color: #fef3c7;
        }
        
        .tw-border-blue-200 {
            border-color: #bfdbfe;
        }
        
        .tw-text-center {
            text-align: center;
        }
        
        .tw-text-right {
            text-align: right;
        }
        
        .tw-text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
        .tw-text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        
        .tw-text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .tw-text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .tw-text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        
        .tw-font-semibold {
            font-weight: 600;
        }
        
        .tw-font-medium {
            font-weight: 500;
        }
        
        .tw-font-bold {
            font-weight: 700;
        }
        
        .tw-text-gray-900 {
            color: #111827;
        }
        
        .tw-text-gray-600 {
            color: #121212;
        }
        
        .tw-text-gray-500 {
            color: #6b7280;
        }
        
        .tw-text-white {
            color: #fff;
        }
        
        .tw-text-blue-600 {
            color: #860000;
        }
        
        .tw-text-blue-500 {
            color: #860000;
        }
        
        .tw-text-blue-900 {
            color: #000000ff;
        }
        
        .tw-text-blue-700 {
            color: #000000ff;
        }
        
        .tw-text-red-600 {
            color: #dc2626;
        }
        
        .tw-text-green-600 {
            color: #16a34a;
        }
        
        .tw-text-green-800 {
            color: #166534;
        }
        
        .tw-text-yellow-800 {
            color: #92400e;
        }
        
        .tw-text-gray-400 {
            color: #9ca3af;
        }
        
        .tw-inline {
            display: inline;
        }
        
        .tw-block {
            display: block;
        }
        
        .tw-hover-bg-blue-700:hover {
            background-color: #1d4ed8;
        }
        
        .tw-hover-bg-red-700:hover {
            background-color: #b91c1c;
        }
        
        .tw-hover-bg-green-700:hover {
            background-color: #15803d;
        }
        
        .tw-hover-bg-gray-700:hover {
            background-color: #374151;
        }
        
        .tw-transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Styles personnalisés pour les statuts */
        .status-scheduled {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        
        .status-urgent {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .status-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-expired {
            background-color: #f3f4f6;
            color: #374151;
        }

        /* Styles personnalisés pour le layout */
        .main-content-wrapper {
            padding: 0 !important;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            margin: 0;
        }

        .main-content-section {
            min-width: 0;
        }

        .sidebar-section {
            width: 320px;
        }

        .card-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .car-info-header {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .car-image-container {
            flex-shrink: 0;
        }

        .car-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.35rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .period-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
        }

        .period-details {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .period-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .duration-highlight {
            background: #ffb30018;
            border-radius: 0.5rem;
            border: 1px solid #ffb400;
            padding: 1rem;
            text-align: center;
            min-width: 80px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .total-row {
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
            margin-top: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 2rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .extension-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .extension-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .extension-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .action-button {
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.50rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.15s ease;
            border: none;
            cursor: pointer;
            margin-bottom: 0.75rem;
        }

        .btn-blue {
            background: #860000;
            color: white;
        }

        .btn-blue:hover {
            color: #fff;
            -webkit-box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326); /* #860000 en rgba */
            -moz-box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326);
            box-shadow: 2px 2px 20px 0px rgba(134, 0, 0, 0.326);
        }

        .btn-red {
            background: #121212;
            color: white;
        }

        .btn-red:hover {
            color: #fff;
            -webkit-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
        }

        .btn-green {
            background: #16a34a;
            color: white;
        }

        .btn-green:hover {
            background: #15803d;
            color: white;
        }

        .btn-gray {
            background: #000000ff;
            color: white;
        }

        .btn-z:hover {
            color: #fff;
            -webkit-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
            box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.2);
        }

        .contract-info-box {
            background: #ffb30026;
            border: 1px solid #ffb400;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .contract-info-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .sidebar-section {
                width: 100%;
            }
            
            .car-info-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .period-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .car-details-grid {
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

            <section id="section-cars" style="background-color: #f3f4f6;">
                <div class="container">
                    <div class="row">
                        <!-- Sidebar du template -->
                        <div class="col-lg-3 mb30">
                            <div class="card p-4 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="{{ asset('images/profile/1.jpg') }}" alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            Monica Lucas                                                
                                            <span class="profile_username text-gray">monica@rentaly.com</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li><a href="" class="active"><i class="fa fa-home"></i>Dashboard</a></li>
                                    <li><a href="{{ asset('account-profile.html') }}"><i class="fa fa-user"></i>My Profile</a></li>
                                    <li><a href="{{ asset('account-booking.html') }}"><i class="fa fa-calendar"></i>My Orders</a></li>
                                    <li><a href="{{ asset('account-favorite.html') }}"><i class="fa fa-car"></i>My Favorite Cars</a></li>
                                    <li><a href="{{ asset('login.html') }}"><i class="fa fa-sign-out"></i>Sign Out</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contenu principal -->
                        <div class="col-lg-9">
                            <div class="main-content-wrapper">
                                <div class="content-grid">
                                    <!-- Section principale -->
                                    <div class="main-content-section">
                                        
                                        <!-- Informations de la voiture -->
                                        <div class="card-wrapper tw-p-6">
                                            <div class="car-info-header">
                                                @if($reservation->car->image)
                                                    <div class="car-image-container">
                                                        <img src="{{ Storage::url($reservation->car->image) }}" 
                                                            alt="{{ $reservation->car->brand }} {{ $reservation->car->model }}" 
                                                            class="tw-w-32 tw-h-24 tw-object-cover tw-rounded-lg">
                                                    </div>
                                                @else
                                                    <div class="car-image-container">
                                                        <div class="tw-w-32 tw-h-24 tw-bg-gray-200 tw-rounded-lg tw-flex tw-items-center tw-justify-center">
                                                            <i data-lucide="car" class="tw-w-8 tw-h-8 tw-text-gray-400"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="tw-flex-1">
                                                    <h3 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-2">
                                                        {{ $reservation->car->brand }} {{ $reservation->car->model }} 
                                                        @if($reservation->car->year)
                                                            ({{ $reservation->car->year }})
                                                        @endif
                                                    </h3>
                                                    <div class="car-details-grid">
                                                        @if($reservation->car->seats)
                                                        <div class="detail-item">
                                                            <i data-lucide="users" class="tw-w-4 tw-h-4" style="color:#860000;"></i>
                                                            	
                                                            <span>{{ $reservation->car->seats }} places</span>
                                                        </div>
                                                        @endif
                                                        @if($reservation->car->fuel_type)
                                                        <div class="detail-item">
                                                            <div class="d-atr-group tw-flex tw-flex-wrap tw-gap-2 tw-mb-3">
                                                                <span class="dooo tw-flex tw-items-center tw-gap-1">
                                                                    <img src="{{ asset('images/icons/2-green.png') }}" alt="">
                                                                </span>
                                                            </div>
                                                            <span>{{ $reservation->car->fuel_type }}</span>
                                                        </div>
                                                        @endif
                                                        @if($reservation->car->transmission)
                                                        <div class="detail-item">
                                                            
                                                            <div class="d-atr-group tw-flex tw-flex-wrap tw-gap-2 tw-mb-3">
                                                       
                                                        <span class="dooo tw-flex tw-items-center tw-gap-1">
                                                            <img src="{{ asset('images/icons/4-green.png') }}" alt="">
                                                        </span>
                                                    </div>
                                                            <span>{{ $reservation->car->transmission }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="detail-item">
                                                            <i data-lucide="user-check" class="tw-w-4 tw-h-4" style="color:#860000;"></i>
                                                            <span>{{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Période de réservation -->
                                        <div class="card-wrapper tw-p-6">
                                            <h3 class="section-title">Période de réservation</h3>
                                            <div class="period-grid">
                                                <div class="period-details">
                                                    <div class="period-item">
                                                        <i data-lucide="calendar" class="tw-w-5 tw-h-5" style="color: #860000;"></i>
                                                        <div>
                                                            <div class="tw-font-medium tw-text-gray-900">Début</div>
                                                            <div class="tw-text-gray-600">
                                                                {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }} 
                                                                à {{ $reservation->reservation_start_time }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="period-item">
                                                        <i data-lucide="calendar" class="tw-w-5 tw-h-5" style="color: #860000;"></i>
                                                        <div>
                                                            <div class="tw-font-medium tw-text-gray-900">Fin</div>
                                                            <div class="tw-text-gray-600">
                                                                {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }} 
                                                                à {{ $reservation->reservation_end_time }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="duration-highlight">
                                                    <div class="tw-text-2xl tw-font-bold" style="color: #860000;">{{ $reservation->total_days }}</div>
                                                    <div class="tw-text-sm" style="color: #860000;">{{ $reservation->total_days > 1 ? 'jours' : 'jour' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Résumé financier -->
                                        <div class="card-wrapper tw-p-6">
                                            <h3 class="section-title">Résumé financier</h3>
                                            <div class="tw-space-y-3">
                                                <div class="summary-item">
                                                    <span class="tw-text-gray-600">ID Réservation</span>
                                                    <span class="tw-font-medium">#{{ $reservation->id }}</span>
                                                </div>
                                                <div class="summary-item">
                                                    <span class="tw-text-gray-600">Durée</span>
                                                    <span class="tw-font-medium">{{ $reservation->total_days }} {{ $reservation->total_days > 1 ? 'jours' : 'jour' }}</span>
                                                </div>
                                                <div class="summary-item">
                                                    <span class="tw-text-gray-600">Tarif journalier</span>
                                                    <span class="tw-font-medium">{{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                <div class="summary-item">
                                                    <span class="tw-text-gray-600">Sous-total</span>
                                                    <span class="tw-font-medium">{{ number_format($reservation->subtotal, 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                @if($reservation->discount_percentage > 0)
                                                <div class="summary-item" style="color: #16a34a;">
                                                    <span>Remise ({{ $reservation->discount_percentage }}%)</span>
                                                    <span>-{{ number_format($reservation->discount_amount, 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                @endif
                                                <div class="summary-item total-row tw-font-semibold tw-text-lg">
                                                    <span>Total final</span>
                                                    <span style="color: #860000;">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                <div class="tw-text-center tw-mt-3">
                                                    <span class="status-badge {{ $reservation->payment_status === 'paid' ? 'tw-bg-green-100 tw-text-green-800' : 'tw-bg-yellow-100 tw-text-yellow-800' }}">
                                                        {{ $reservation->payment_status === 'paid' ? 'Payé' : 'En attente de paiement' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Extensions -->
                                        @if(isset($reservation->extensions) && $reservation->extensions->count() > 0)
                                        <div class="card-wrapper tw-p-6">
                                            <h3 class="section-title">Extensions</h3>
                                            <div class="tw-space-y-3">
                                                @foreach($reservation->extensions as $extension)
                                                <div class="extension-item">
                                                    <div class="extension-left">
                                                        <div class="extension-dot"></div>
                                                        <div>
                                                            <div class="tw-font-medium tw-text-gray-900">Extension #{{ $extension->id }}</div>
                                                            <div class="tw-text-sm tw-text-gray-600">
                                                                Du {{ \Carbon\Carbon::parse($extension->start_date)->format('d/m/Y H:i') }} 
                                                                au {{ \Carbon\Carbon::parse($extension->end_date)->format('d/m/Y H:i') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tw-text-right">
                                                        <div class="tw-font-semibold tw-text-gray-900">{{ number_format($extension->price, 0, ',', ' ') }} FCFA</div>
                                                        <div class="tw-text-xs {{ $extension->status === 'paid' ? 'tw-text-green-600' : 'tw-text-yellow-600' }}">
                                                            {{ $extension->status === 'paid' ? 'Payé' : 'En attente' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Sidebar -->
                                    <div class="sidebar-section">
                                        <!-- Section Contrat de Réservation -->
                                        <div class="card-wrapper tw-p-6">
                                            <h3 class="section-title">
                                                <i data-lucide="file-text" class="tw-w-5 tw-h-5"></i>
                                                Contrat de Réservation
                                            </h3>
                                            
                                            <div class="contract-info-box">
                                                <div class="contract-info-header">
                                                    <i data-lucide="info" class="tw-w-5 tw-h-5 tw-text-blue-500 tw-pt-0.5"></i>
                                                    <div class="tw-flex-1">
                                                        <h4 class="tw-font-medium tw-text-blue-900 tw-mb-1">Votre contrat de location</h4>
                                                        <p class="tw-text-sm tw-text-blue-700">
                                                            Consultez ou téléchargez votre contrat officiel de location avec tous les détails de votre réservation.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tw-space-y-2">
                                                <!-- Bouton Voir le contrat -->
                                                <a href="{{ route('reservations.contract.preview', $reservation) }}" 
                                                target="_blank"
                                                class="action-button btn-blue">
                                                    <i data-lucide="eye" class="tw-w-4 tw-h-4 tw-mr-2 tw-inline"></i>
                                                    Voir le contrat
                                                </a>
                                                
                                                <!-- Bouton Télécharger PDF -->
                                                <a href="{{ route('reservations.contract.download', $reservation) }}" 
                                                class="action-button btn-red">
                                                    <i data-lucide="download" class="tw-w-4 tw-h-4 tw-mr-2 tw-inline"></i>
                                                    Télécharger PDF
                                                </a>
                                            </div>

                                            <div class="tw-text-xs tw-text-gray-500 tw-text-center tw-mt-3">
                                                <i data-lucide="shield-check" class="tw-w-3 tw-h-3 tw-inline tw-mr-1"></i>
                                                Document officiel sécurisé
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="card-wrapper tw-p-6">
                                            <h3 class="section-title">Actions</h3>
                                            <div class="tw-space-y-3">
                                                @if($reservation->status === 'pending')
                                                <button onclick="confirmReservation()" class="action-button btn-green">
                                                    Confirmer la réservation
                                                </button>
                                                @endif
                                                <button onclick="downloadInvoice()" class="action-button btn-blue">
                                                    Télécharger la facture
                                                </button>
                                                <a href="{{ route('reservations.index') }}" class="action-button btn-gray">
                                                    Retour aux réservations
                                                </a>
                                            </div>
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
        // Initialiser Lucide
        lucide.createIcons();

        // Démarrer le compte à rebours
        function startCountdown() {
            // Construire les dates correctement avec les nouveaux champs
            const startDateTime = '{{ $reservation->reservation_start_date }}T{{ $reservation->reservation_start_time }}';
            const endDateTime = '{{ $reservation->reservation_end_date }}T{{ $reservation->reservation_end_time }}';
            
            const startDate = new Date(startDateTime);
            const endDate = new Date(endDateTime);
            const circle = document.getElementById('progressRing');
            const circumference = 2 * Math.PI * 15.9155;

            // Initialiser le cercle de progression
            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = circumference;

            function updateCountdown() {
                const now = new Date();
                let diff, totalDiff, elapsed, progress;
                let days, hours, minutes, seconds;
                let message = '';

                if (now >= endDate) {
                    // Réservation expirée
                    document.getElementById('daysLeft').textContent = '00';
                    document.getElementById('hoursLeft').textContent = '00';
                    document.getElementById('minutesLeft').textContent = '00';
                    document.getElementById('secondsLeft').textContent = '00';
                    document.getElementById('progressPercent').textContent = '100%';
                    document.getElementById('countdownMessage').textContent = 'Réservation expirée';
                    updateStatus('expired');
                    return;
                }

                if (now < startDate) {
                    // Réservation pas encore commencée - compte à rebours jusqu'au début
                    diff = startDate - now;
                    totalDiff = endDate - startDate;
                    progress = 0;
                    message = 'Temps avant le début de la réservation';
                    updateStatus('scheduled');
                } else {
                    // Réservation en cours - compte à rebours jusqu'à la fin
                    diff = endDate - now;
                    totalDiff = endDate - startDate;
                    elapsed = now - startDate;
                    progress = Math.min(100, Math.max(0, (elapsed / totalDiff) * 100));
                    message = 'Temps restant avant la fin';
                    
                    // Déterminer le statut selon le temps restant
                    const totalHours = Math.floor(diff / (1000 * 60 * 60));
                    if (totalHours < 1) {
                        updateStatus('urgent');
                    } else if (totalHours < 24) {
                        updateStatus('warning');
                    } else {
                        updateStatus('active');
                    }
                }

                // Calculer jours, heures, minutes, secondes
                days = Math.floor(diff / (1000 * 60 * 60 * 24));
                hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((diff % (1000 * 60)) / 1000);

                // Mettre à jour l'affichage avec zéros de remplissage
                document.getElementById('daysLeft').textContent = String(days).padStart(2, '0');
                document.getElementById('hoursLeft').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutesLeft').textContent = String(minutes).padStart(2, '0');
                document.getElementById('secondsLeft').textContent = String(seconds).padStart(2, '0');
                document.getElementById('progressPercent').textContent = Math.round(progress) + '%';
                document.getElementById('countdownMessage').textContent = message;

                // Mettre à jour le cercle de progression
                const offset = circumference - (progress / 100) * circumference;
                circle.style.strokeDashoffset = offset;
            }

            function updateStatus(status) {
                const statusElement = document.getElementById('reservationStatus');
                let className, text;
                
                switch(status) {
                    case 'scheduled':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-scheduled';
                        text = 'Programmé';
                        break;
                    case 'urgent':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-urgent';
                        text = 'Urgent';
                        break;
                    case 'warning':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-warning';
                        text = 'Attention';
                        break;
                    case 'active':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-active';
                        text = 'En cours';
                        break;
                    case 'expired':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-expired';
                        text = 'Expiré';
                        break;
                    default:
                        return;
                }
                
                statusElement.textContent = text;
                statusElement.className = className;
            }

            // Mettre à jour immédiatement puis toutes les secondes
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Actions
        function confirmReservation() {
            if (confirm('Confirmer cette réservation ?')) {
                fetch('/reservations/{{ $reservation->id }}/confirm', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la confirmation');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                });
            }
        }

        function cancelReservation() {
            if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                fetch('/reservations/{{ $reservation->id }}/cancel', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'annulation');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                });
            }
        }

        function downloadInvoice() {
            window.open('/reservations/{{ $reservation->id }}/invoice', '_blank');
        }

        // Démarrer le compte à rebours au chargement
        document.addEventListener('DOMContentLoaded', startCountdown);
    </script>

</body>

</html>