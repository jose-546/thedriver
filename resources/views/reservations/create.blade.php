<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Réserver {{ $car->getFullName() ?? 'Véhicule' }} - Rentaly</title>
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Réservation de véhicule - Rentaly" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Thème stylisé -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    
    <!-- Custom Styles -->
    <style>

                .custom-select-wrapper {
            position: relative;
            width: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .custom-select {
            width: 100%;
            padding: 12px 45px 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            font-size: 16px;
            color: #333;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .custom-select:focus {
            border-color: #860000;
            box-shadow: 0 0 0 3px rgba(134, 0, 0, 0.1);
        }

        .custom-select.has-value {
            color: #333;
        }

        .custom-select.placeholder {
            color: #888;
        }

        .select-arrow {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid #666;
            pointer-events: none;
            transition: transform 0.3s ease, border-top-color 0.3s ease;
            z-index: 2;
        }

        .custom-select-wrapper.open .select-arrow {
            transform: translateY(-50%) rotate(180deg);
            border-top-color: #860000;
        }

        .custom-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #860000;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .custom-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .custom-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .custom-option:last-child {
            border-bottom: none;
        }

        .custom-option:hover {
            background-color: #860000;
            color: white;
        }

        .custom-option.selected {
            background-color: #f8f9fa;
            color: #860000;
            font-weight: 500;
        }

        .custom-option.selected:hover {
            background-color: #860000;
            color: white;
        }

        /* Animation pour l'ouverture */
        .custom-select-wrapper.open .custom-select {
            border-color: #860000;
            border-radius: 8px 8px 0 0;
        }

        /* Scrollbar personnalisée */
        .custom-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .custom-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .custom-dropdown::-webkit-scrollbar-thumb {
            background: #860000;
            border-radius: 4px;
        }

        .custom-dropdown::-webkit-scrollbar-thumb:hover {
            background: #660000;
        }

        /* Style pour les états d'erreur */
        .custom-select.error {
            border-color: #dc3545;
        }

        .custom-select.error:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-select {
                padding: 14px 45px 14px 16px;
                font-size: 16px;
            }
        }
        
        .field-set {
            position: relative;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-text {
            margin-top: 5px;
            font-size: 0.875rem;
        }

        select.form-control {
            height: 48px;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        select.form-control:focus {
            border-color: #860000;
            box-shadow: 0 0 0 0.2rem rgba(134, 0, 0, 0.25);
            outline: none;
        }

        input.form-control {
            height: 48px;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input.form-control:focus {
            border-color: #860000;
            box-shadow: 0 0 0 0.2rem rgba(134, 0, 0, 0.25);
            outline: none;
        }

        

/* code pour personnaliser calandrier */
:root {
            --primary-color: #860000;
            --text-color: #000000;
            --bg-color: #ffffff;
            --border-color: #e0e0e0;
            --hover-color: #f5f5f5;
            --disabled-color: #cccccc;
        }

        /* === CONTENEUR PRINCIPAL === */
        .flatpickr-calendar {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            width: 320px;
            z-index: 9999 !important;
        }

        /* === EN-TÊTE DU CALENDRIER === */
        .flatpickr-months {
            background: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: 8px 8px 0 0;
        }

        .flatpickr-month {
            color: white;
            fill: white;
            height: 34px;
        }

        .flatpickr-current-month {
            font-size: 14px;
            font-weight: 600;
            padding-top: 4px;
        }

        .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            background: transparent;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 4px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .flatpickr-monthDropdown-months:hover,
        .flatpickr-current-month input.cur-year:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Options du sélecteur de mois */
        .flatpickr-monthDropdown-months option {
            background: white;
            color: var(--text-color);
        }

        /* === BOUTONS DE NAVIGATION === */
        .flatpickr-prev-month,
        .flatpickr-next-month {
            color: white !important;
            fill: white !important;
            padding: 6px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .flatpickr-prev-month:hover,
        .flatpickr-next-month:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* === CORPS DU CALENDRIER === */
        .flatpickr-innerContainer {
            padding: 12px;
            background: var(--bg-color);
        }

        /* === JOURS DE LA SEMAINE === */
        .flatpickr-weekdays {
            background: var(--bg-color);
            margin-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
        }

        .flatpickr-weekday {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }

        /* Assurer que la colonne du dimanche a la même taille */
        .flatpickr-weekday:nth-child(1) {
            min-width: 40px;
        }

        /* === GRILLE DES JOURS === */
        .flatpickr-days {
            border: none;
        }

        .dayContainer {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            padding: 0;
        }

        /* === STYLES DES JOURS === */
        .flatpickr-day {
            color: var(--text-color);
            border: 1px solid transparent;
            border-radius: 4px;
            height: 40px;
            line-height: 40px;
            max-width: 40px;
            margin: 2px;
            font-weight: 400;
        }

        /* Taille égale pour tous les jours, y compris le dimanche */
        .flatpickr-day, .flatpickr-day.flatpickr-sunday {
            width: 40px;
            flex-basis: 40px;
        }

        /* Jour au survol */
        .flatpickr-day:hover {
            background: var(--hover-color);
            border-color: var(--primary-color);
            color: var(--text-color);
        }

        /* Jour aujourd'hui */
        .flatpickr-day.today {
            border-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Jour sélectionné */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        /* Plage de dates */
        .flatpickr-day.inRange {
            background: rgba(134, 0, 0, 0.1);
            border-color: rgba(134, 0, 0, 0.2);
            color: var(--text-color);
        }

        /* Jours désactivés */
        .flatpickr-day.disabled,
        .flatpickr-day.disabled:hover {
            color: var(--disabled-color);
            cursor: not-allowed;
        }

        /* Jours des mois précédent/suivant */
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: var(--disabled-color);
        }

        /* === CHAMP D'ENTRÉE === */
        .flatpickr-input {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .flatpickr-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .flatpickr-calendar {
                width: 280px;
                font-size: 13px;
            }
            
            .flatpickr-day {
                height: 36px;
                line-height: 36px;
                max-width: 36px;
            }
            
            .flatpickr-day, .flatpickr-day.flatpickr-sunday {
                width: 36px;
                flex-basis: 36px;
            }
        }

/* code pour personnaliser calandrier */



/* === Nouveau style pour le sélecteur d'heure === */
.custom-time-selector {
    position: relative;
    width: 100%;
}

.custom-time-selector .time-input {
    cursor: pointer;
    background-color: white;
}

.time-selector-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    margin-top: 5px;
    display: none;
    max-height: 200px;
    overflow-y: auto;
}

.time-selector-dropdown.active {
    display: block;
}

.time-option {
    padding: 10px 15px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
}

.time-option:last-child {
    border-bottom: none;
}

.time-option:hover {
    background-color: #860000;
    color: white;
}

.time-option.selected {
    background-color: #860000;
    color: white;
    font-weight: bold;
}

.time-selector-header {
    padding: 10px 15px;
    background-color: #860000;
    color: white;
    font-weight: bold;
    border-radius: 8px 8px 0 0;
    text-align: center;
}

.time-selector-actions {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #f0f0f0;
}

.time-selector-btn {
    padding: 5px 10px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.time-selector-btn.confirm {
    background-color: #860000;
    color: white;
}

.time-selector-btn.cancel {
    background-color: #f8f9fa;
    color: #333;
}

        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
        
        .success-message {
            color: #198754;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .dura-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: white;
        }
        
        .dura-card.selected {
            border-color: #860000;
            background: #860000;
            color: white;
        }

        .dura-card .icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .dura-card.selected .icon {
            color: white;
        }

        .dura-card.selected h6 {
            color: white;
        }

        .car-info-display {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .d-atr {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            font-size: 14px;
            color: #666;
        }

        .d-atr img {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .price-breakdown {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .price-row.total {
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
            margin-top: 10px;
            font-weight: bold;
        }

        .popover-recap-box {
    font-family: 'Outfit', serif; /* Correction ici : 'Outfit serif' → 'Outfit', serif */
    background-color: #ffb400;
    color: #ffffff;
    text-align: center;
    padding: 10px;
    border-radius: 10px;
    
    margin-top: 10px;
}

.popover-recap-box .d-row{
    border-bottom: solid 1px #ffffff;
    padding: 2px 0;
}


.popover-recap-box .amount {
    font-size: 1.3rem;
    font-weight: bold;
    color: #860000 ;
}

.popover-recap-box .label {
    font-size: 0.9em;
}

.popover-recap-box .tva {
    font-size: 0.8em;
}

.discount-badge {
            background: #860000;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-left: 10px;
        }

        /* Styles pour les politiques */
        .policy-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .policy-checkbox {
            margin-top: 15px;
        }

        .policy-checkbox .form-check-input {
            border: 2px solid #860000;
            width: 1.2em;
            height: 1.2em;
        }

        .policy-checkbox .form-check-input:checked {
            background-color: #860000;
            border-color: #860000;
        }

        .policy-links {
            margin-top: 10px;
        }

        .policy-link {
            color: #860000;
            text-decoration: underline;
            font-weight: 500;
        }

        .policy-link:hover {
            color: #660000;
            text-decoration: underline;
        }

        .required-asterisk {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
        @include('partials.headerblanc')
        <!-- header close -->

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
                <div class="center-y relative text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1>Réservation rapide</h1>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->

        <section id="section-hero" aria-label="section" class="no-top" data-bgcolor="#121212">
            
                                <div class="container">

                                        <div class="row align-items-center">
                                            <div id="booking_form_wrap" class="padding40 rounded-5 shadow-soft" data-bgcolor="#ffffff"> 
                                                
                                                <form name="contactForm" id='reservationForm' method="post" action="{{route('reservations.store')}}" class="form-s2 row g-4 on-submit-hide">
                                                    @csrf
                                                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                                                    <input type="hidden" name="with_driver" id="with_driver" value="0">
                                                    <input type="hidden" name="terms_accepted" id="terms_accepted" value="0">

                                                    <div class="col-lg-6 d-light">


                                                                <!-- Informations de la voiture -->
                                                            
                                                                   
                                                                    <div class="form-control mb-4" style="display: flex; align-items: center; padding: 10px 10px;">
                                                                        <h3 style="margin: 0;">{{ $car->getFullName() }}</h3>
                                                                            
                                                                    </div>
                                                                
                                                                    <div class="row">
                                                                        <!-- Section des dates -->
                                                                        <div class="form-section mb-4">                                            
                                                                            <div class="row">
                                                                                <div class="col-lg-6 mb20">
                                                                                    <h5>Date de prise en charge</h5>
                                                                                    <div class="">
                                                                                        <input type="text" class="form-control" id="start_date" name="reservation_start_date" 
                                                                                        placeholder="Sélectionner la date de début" required>
                                                                                    </div>
                                                                                    <div class="error-message" id="startDateError">
                                                                                        Veuillez sélectionner une date de début valide.
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5>Date de fin</h5>
                                                                                    <input type="text" class="form-control" id="end_date" name="reservation_end_date" 
                                                                                        placeholder="Sélectionner la date de fin" required>
                                                                                    <div class="error-message" id="endDateError">
                                                                                        Veuillez sélectionner une date de fin valide.
                                                                                    </div>
                                                                                    <div class="success-message" id="dataSuccess" style="display: none">
                                                                                        Date disponibles pour cette période.
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mb-2">
                                                                                    <div class="col-lg-6">
                                                                                        <h5>Heure de début</h5>
                                                                                        <div class="custom-time-selector">
                                                                                            <input type="text" id="start_time" name="reservation_start_time" class="form-control time-input" 
                                                                                                placeholder="Choisir une heure" required readonly>
                                                                                            <div class="time-selector-dropdown">
                                                                                                <div class="time-selector-header">Sélectionnez une heure</div>
                                                                                                <div class="time-options-container"></div>
                                                                                                <div class="time-selector-actions">
                                                                                                    <button type="button" class="time-selector-btn cancel">Annuler</button>
                                                                                                    <button type="button" class="time-selector-btn confirm">Confirmer</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="error-message" id="startTimeError">
                                                                                            Veuillez sélectionner une heure de début.
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <h5>Heure de fin (calculée)</h5>
                                                                                        <input type="text" class="form-control" id="end_time" readonly
                                                                                            placeholder="Sera calculée automatiquement">
                                                                                    </div>
                                                                            </div>
                                                                        
                                                                            <div class="row mb-3">
                                                                                <div class="col-lg-12">
                                                                                    <div class="joe">
                                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                                        <strong>Durée calculée :</strong> <span id="calculated_duration">Sélectionnez vos dates</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="success-message" id="dateSuccess">
                                                                                Période disponible pour cette réservation.
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Informations de Localisation -->
                                                                    <h5>Votre position (Où êtes-vous ?)</h5>
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-12">
                                                                            <div class="field-set">
                                                                                <input type="text" name="client_location" id="client_location" 
                                                                                    class="form-control" 
                                                                                    placeholder="Ex: Près de l'école primaire de Godomey, Carrefour Total Akpakpa, etc." 
                                                                                    required>
                                                                                <div class="error-message" id="locationError">
                                                                                    Veuillez indiquer votre position actuelle.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <h5>Zone de déplacement</h5>
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-12">
                                                                            <div class="field-set">
                                                                                <!-- Select original caché pour maintenir la compatibilité backend -->
                                                                                <select name="deployment_zone" id="deployment_zone" class="form-select" required style="display: none;">
                                                                                    <option value="">Sélectionner votre zone de déplacement</option>
                                                                                    <option value="Zone 1 - Centre-ville Cotonou">Zone 1 - Centre-ville Cotonou</option>
                                                                                    <option value="Zone 2 - Akpakpa/Godomey">Zone 2 - Akpakpa/Godomey</option>
                                                                                    <option value="Zone 3 - Calavi/Abomey-Calavi">Zone 3 - Calavi/Abomey-Calavi</option>
                                                                                    <option value="Zone 4 - Porto-Novo">Zone 4 - Porto-Novo</option>
                                                                                    <option value="Zone 5 - Parakou">Zone 5 - Parakou</option>
                                                                                    <option value="Zone 6 - Bohicon/Abomey">Zone 6 - Bohicon/Abomey</option>
                                                                                    <option value="Zone 7 - Ouidah/Grand-Popo">Zone 7 - Ouidah/Grand-Popo</option>
                                                                                    <option value="Zone 8 - Natitingou">Zone 8 - Natitingou</option>
                                                                                    <option value="Inter-zones">Déplacements inter-zones</option>
                                                                                    <option value="Hors Bénin">Déplacements hors Bénin</option>
                                                                                </select>

                                                                                <!-- Select personnalisé visible -->
                                                                                <div class="custom-select-wrapper" id="customSelectWrapper">
                                                                                    <div class="custom-select placeholder" id="customSelect">
                                                                                        Sélectionner votre zone de déplacement
                                                                                    </div>
                                                                                    <div class="select-arrow"></div>
                                                                                    <div class="custom-dropdown" id="customDropdown">
                                                                                        <div class="custom-option" data-value="">Sélectionner votre zone de déplacement</div>
                                                                                        <div class="custom-option" data-value="Zone 1 - Centre-ville Cotonou">Zone 1 - Centre-ville Cotonou</div>
                                                                                        <div class="custom-option" data-value="Zone 2 - Akpakpa/Godomey">Zone 2 - Akpakpa/Godomey</div>
                                                                                        <div class="custom-option" data-value="Zone 3 - Calavi/Abomey-Calavi">Zone 3 - Calavi/Abomey-Calavi</div>
                                                                                        <div class="custom-option" data-value="Zone 4 - Porto-Novo">Zone 4 - Porto-Novo</div>
                                                                                        <div class="custom-option" data-value="Zone 5 - Parakou">Zone 5 - Parakou</div>
                                                                                        <div class="custom-option" data-value="Zone 6 - Bohicon/Abomey">Zone 6 - Bohicon/Abomey</div>
                                                                                        <div class="custom-option" data-value="Zone 7 - Ouidah/Grand-Popo">Zone 7 - Ouidah/Grand-Popo</div>
                                                                                        <div class="custom-option" data-value="Zone 8 - Natitingou">Zone 8 - Natitingou</div>
                                                                                        <div class="custom-option" data-value="Inter-zones">Déplacements inter-zones</div>
                                                                                        <div class="custom-option" data-value="Hors Bénin">Déplacements hors Bénin</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Message d'erreur existant -->
                                                                                <div class="error-message" id="zoneError">
                                                                                    Veuillez sélectionner une zone de déplacement.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Informations Client -->
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-6">
                                                                            <div class="field-set">
                                                                                <h5>Numéro</h5>
                                                                                <input type="tel" name="client_phone" id="client_phone" class="form-control" placeholder="Numéro Mobile" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="field-set">
                                                                                <h5>Email</h5>
                                                                                <input type="email" name="client_email" id="client_email" class="form-control" placeholder="Adresse Email" required>
                                                                            </div>
                                                                        </div>  
                                                                    </div>

                                                                    <!-- Type de réservation -->
                                                                    <div class="col-lg-12">
                                                                        <h5>Type de Réservation</h5>
                                                                        <div id="step-2" class="">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-6 mb-4">
                                                                                    <input id="radio-without-driver" name="reservation_type_input" type="radio" value="0" checked style="display: none;">
                                                                                    <label for="radio-without-driver" class="dura-card selected">
                                                                                        <div class="icon"><i class="fas fa-car fa-2x"></i></div>
                                                                                        <h6>Sans chauffeur</h6>
                                                                                        <p><strong>{{ number_format($car->daily_price_without_driver ?? 20000, 0, ',', ' ') }} FCFA/jour</strong></p>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-lg-6 col-6 mb-4">
                                                                                    <input id="radio-with-driver" name="reservation_type_input" type="radio" value="1" style="display: none;">
                                                                                    <label for="radio-with-driver" class="dura-card">
                                                                                        <div class="icon"><i class="fas fa-user-tie fa-2x"></i></div>
                                                                                        <h6>Avec chauffeur</h6>
                                                                                        <p><strong>{{ number_format($car->daily_price_with_driver ?? 30000, 0, ',', ' ') }} FCFA/jour</strong></p>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="error-message" id="typeError">
                                                                                Veuillez sélectionner un type de réservation.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                    </div>

                                                   
                                                            

                                                    <!-- Récapitulatif -->
                                                    <div class="col-lg-6">
                                                        
                                                        <div class="de-box mb25">
                                                            <h4>Récapitulatif de la réservation</h4>
                                                            <div class="spacer-20"></div>

                                                            <div class="row">
                                                                <div class="col-lg-12 mb20">
                                                                    <div class="de-spec">
                                                                        <div class="d-row">
                                                                            <span class="d-title">Véhicule sélectionné :</span>
                                                                            <span class="d-value">{{ $car->getFullName() }}</span>
                                                                        </div>
                                                                        <div class="d-row d-flex justify-content-between" id="summaryPeriod" style="display: none;">
                                                                            <span class="d-title">Période :</span>
                                                                            <span class="d-value" id="periodText">-</span>
                                                                        </div>
                                                                        <div class="d-row d-flex justify-content-between" id="summaryDuration" style="display: none;">
                                                                            <span class="d-title">Durée :</span>
                                                                            <span class="d-value" id="durationText">-</span>
                                                                        </div>
                                                                        <div class="d-row d-flex justify-content-between" id="summaryType">
                                                                            <span class="d-title">Type de réservation :</span>
                                                                            <span class="d-value" id="typeText">Sans chauffeur</span>
                                                                        </div>
                                                                        <div class="d-row d-flex justify-content-between" id="summaryRate">
                                                                            <span class="d-title">Tarif journalier :</span>
                                                                            <span class="d-value" id="rateText">{{ number_format($car->daily_price_without_driver ?? 20000, 0, ',', ' ') }} FCFA/jour</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Détail des calculs -->
                                                                <div class="col-lg-12 mb20" id="priceBreakdown" style="display: none;">
                                                                    <div class="popover-recap-box">
                                                                        <div class="d-row">
                                                                            <span class="d-title">Sous-total :</span>
                                                                            <span class="d-value" id="subtotalText">0 FCFA</span>
                                                                        </div>
                                                                       
                                                                        <div class="d-row" id="discountRow">
                                                                            <span class="d-title">Réduction <span id="discountBadge" class="discount-badge"></span> :</span>
                                                                            <span class="d-value" id="discountText">- 0 FCFA</span>
                                                                        </div>
                                                                        <div class="amount">
                                                                            <span class="d-title">Montant total :</span>
                                                                            <span class="d-value" id="totalAmount">0 FCFA</span>
                                                                        </div>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Section Politiques -->        
                                                            <div class="policy-checkbox">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="acceptPolicies" required>
                                                                    <label class="form-check-label" for="acceptPolicies">
                                                                      <p>  J'ai lu et j'accepte les politiques de <span><a href=" {{ route('politique.location') }}" target="_blank" class="policy-link">location</a></span> et d' <span><a href="{{ route('politique.annulation') }} " target="_blank" class="policy-link">annulation</a></span><span class="required-asterisk"> *</span></p>
                                                                    </label>
                                                                </div>
                                                                <div class="error-message" id="policyError">
                                                                    Vous devez accepter les conditions pour continuer.
                                                                </div>
                                                            </div>
                                                            <button type="button" id="submitBtn" class="btn-main  btn-sk btn-fullwidth" disabled>
                                                              Procéder au paiement
                                                            </button>

                                                            <!-- Messages de succès et d'erreur -->
                                                            <div id="success_message" class='success s2' style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-lg-8 offset-lg-2 text-light text-center">
                                                                        <h3 class="mb-2">Félicitations! Votre réservation a été envoyée avec succès. Nous vous contacterons bientôt.</h3>
                                                                        Actualisez cette page si vous voulez faire une autre réservation.
                                                                        <div class="spacer-20"></div>
                                                                        <a class="btn-main btn-black" href="{{ route('cars.show', $car) }}">Recharger cette page</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="error_message" class='error' style="display: none;">
                                                                Désolé, une erreur est survenue lors de l'envoi de votre formulaire.
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </form>
                                                 

                                                        
                                                   
                                            </div>
                                                                
                                        </div>

                                        <div class="spacer-double"></div>

                                <!-- Timeline -->
                                <div class="row text-light">
                                    <div class="col-lg-12">
                                        <div class="container-timeline">
                                            <ul>
                                                <li>
                                                    <h4>Choisissez une voiture</h4>
                                                    <p>Unlock unparalleled adventures and memorable journeys with our vast fleet of vehicles tailored to suit every need, taste, and destination.</p>
                                                </li>
                                                <li>
                                                    <h4>Voir les détails</h4>
                                                    <p>Pick your ideal location and date, and let us take you on a journey filled with convenience, flexibility, and unforgettable experiences.</p>
                                                </li>
                                                <li>
                                                    <h4>Passez a la reservation</h4>
                                                    <p>Secure your reservation with ease, unlocking a world of possibilities and embarking on your next adventure with confidence.</p>
                                                </li>
                                                <li>
                                                    <h4>Suivez votre réservation</h4>
                                                    <p>Hassle-free convenience as we take care of every detail, allowing you to unwind and embrace a journey filled comfort.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                    </div>

                                
        </section>

                             

            <!-- Marquee Section -->
            <section aria-label="section" class="pt40 pb40 text-light">
                <div class="wow fadeInRight d-flex">
                  <div class="de-marquee-list s2">
                    <div class="d-item">
                      <span class="d-item-txt">SUV</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Hatchback</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Crossover</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Convertible</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Sedan</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Sports Car</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                    </div>
                  </div>
                  <div class="de-marquee-list s2">
                    <div class="d-item">
                      <span class="d-item-txt">SUV</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Hatchbook</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Crossover</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Convertible</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Sedan</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                      <span class="d-item-txt">Sports Car</span>
                      <span class="d-item-display"><i class="d-item-dot"></i></span>
                    </div>
                  </div>
                </div>
            </section>
        
        <!-- content close -->

        <!-- Modal Conflit de réservation -->
        <div class="modal fade" id="conflictModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle me-2"></i>
                            Réservation non disponible
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Cette voiture a déjà été réservée pour la période suivante :</strong>
                        </div>
                        <p id="conflictDates" class="text-center fs-5 fw-bold"></p>
                        <p class="text-muted">Veuillez choisir une autre date ou une durée différente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            Choisir une autre date
                        </button>
                    </div>
                </div>
            </div>
        </div>
</div>
        <a href="#" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('partials.footer') 
        <!-- footer close -->
        
    </div>

    <!-- Javascript Files -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
     <!-- Script intl-tel-input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

    <script>
        // Configuration optimisée pour Flatpickr
        const flatpickrConfig = {
            locale: "fr",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F Y",
            minDate: "today",
            allowInput: true,
            clickOpens: true,
            zIndex: 9999
        };

        // Variables globales
        let selectedWithDriver = false; // Par défaut sans chauffeur
        let currentPrice = 0;
        let policiesAccepted = false;
        let totalDays = 0;
        let startDatePicker, endDatePicker;

            // Tarifs journaliers
        const dailyRates = {
            without_driver: {{ $car->daily_price_without_driver ?? 20000 }},
            with_driver: {{ $car->daily_price_with_driver ?? 30000 }}
        };

        // Initialisation après chargement complet
        document.addEventListener('DOMContentLoaded', function() {
            // Délai pour s'assurer que tous les scripts sont chargés
            setTimeout(initializeApp, 100);
        });

        function initializeApp() {
            if (typeof flatpickr === 'undefined') {
            console.error('Flatpickr not loaded!');
            return;
        }
        
        console.log('🚀 Initialisation de l\'application de réservation');
        setupDatePickers();
        setupTimeSelector();
        setupTypeHandlers(); // Cette fonction gère maintenant correctement l'état initial
        setupFormHandlers();
        setupPolicyHandlers();
        setupPhoneInput();
        }

        function setupDatePickers() {
            // Date de début
            startDatePicker = flatpickr("#start_date", {
                ...flatpickrConfig,
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length > 0) {
                        updateEndDateMinimum(selectedDates[0]);
                        calculateDurationAndPricing();
                        hideError('startDateError');
                    }
                }
            });

            // Date de fin
            endDatePicker = flatpickr("#end_date", {
                ...flatpickrConfig,
                minDate: new Date(new Date().getTime() + 24*60*60*1000),
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length > 0) {
                        calculateDurationAndPricing();
                        hideError('endDateError');
                    }
                }
            });

            // Mise à jour initiale de l'heure de fin si nécessaire
            if (document.getElementById('start_time').value) {
                updateEndTime();
            }
        }

        function setupPhoneInput() {
            const input = document.querySelector("#client_phone");
            
            // Initialiser intl-tel-input
            window.phoneInput = window.intlTelInput(input, {
                initialCountry: "bj",
                preferredCountries: ["bj", "fr", "us"],
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
            });
            
            // Écouter les changements
            input.addEventListener('input', updateSubmitButton);
            input.addEventListener('countrychange', updateSubmitButton);
        }

        function setupTimeSelector() {
            const timeInput = document.getElementById('start_time');
            const timeDropdown = document.querySelector('.time-selector-dropdown');
            const timeOptionsContainer = document.querySelector('.time-options-container');
            const cancelBtn = document.querySelector('.time-selector-btn.cancel');
            const confirmBtn = document.querySelector('.time-selector-btn.confirm');
            
            // Générer les options d'heure (de 6h à 22h, par intervalles de 30 minutes)
            let timeOptionsHTML = '';
            for (let hour = 6; hour <= 22; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const timeValue = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    const timeDisplay = `${hour}h${minute === 0 ? '00' : minute}`;
                    timeOptionsHTML += `<div class="time-option" data-value="${timeValue}">${timeDisplay}</div>`;
                }
            }
            timeOptionsContainer.innerHTML = timeOptionsHTML;
            
            // Ouvrir le dropdown au clic sur l'input
            timeInput.addEventListener('click', function() {
                timeDropdown.classList.add('active');
                hideError('startTimeError');
            });
            
            // Sélectionner une heure
            timeOptionsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('time-option')) {
                    // Retirer la sélection précédente
                    document.querySelectorAll('.time-option.selected').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    
                    // Ajouter la nouvelle sélection
                    e.target.classList.add('selected');
                    
                    // Mettre à jour la valeur
                    timeInput.value = e.target.getAttribute('data-value');
                    
                    // Mettre à jour l'heure de fin
                    updateEndTime();
                    
                    // Calculer la durée et le prix
                    calculateDurationAndPricing();
                }
            });
            
            // Confirmer la sélection
            confirmBtn.addEventListener('click', function() {
                timeDropdown.classList.remove('active');
            });
            
            // Annuler la sélection
            cancelBtn.addEventListener('click', function() {
                timeDropdown.classList.remove('active');
            });
            
            // Fermer le dropdown en cliquant à l'extérieur
            document.addEventListener('click', function(e) {
                if (!timeInput.contains(e.target) && !timeDropdown.contains(e.target)) {
                    timeDropdown.classList.remove('active');
                }
            });
        }

        function updateEndDateMinimum(startDate) {
            const nextDay = new Date(startDate.getTime() + 24*60*60*1000);
            endDatePicker.set('minDate', nextDay);
        }

        function updateEndTime() {
            const startTime = document.getElementById('start_time').value;
            if (startTime) {
                document.getElementById('end_time').value = startTime;
            }
        }

        function calculateDurationAndPricing() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                // Calcul du nombre de jours (inclusif)
                const timeDiff = end.getTime() - start.getTime();
                totalDays = Math.floor(timeDiff / (1000 * 3600 * 24));
                
                if (totalDays < 1) totalDays = 1;
                
                console.log('📅 Période calculée:', {
                    start_date: startDate,
                    end_date: endDate,
                    total_days: totalDays
                });

                updateDurationDisplay(totalDays, start, end);
                calculatePricing();
                updateSubmitButton();
            }
        }

        function updateDurationDisplay(days, startDate, endDate) {
            const durationText = days === 1 ? '1 jour' : `${days} jours`;
            document.getElementById('calculated_duration').textContent = durationText;
            
            // Formatage des dates en français
            const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
            const startFormatted = startDate.toLocaleDateString('fr-FR', options);
            const endFormatted = endDate.toLocaleDateString('fr-FR', options);
            
            document.getElementById('periodText').textContent = `Du ${startFormatted} au ${endFormatted}`;
            document.getElementById('durationText').textContent = durationText;
            
            // Afficher les sections de récapitulatif
            document.getElementById('summaryPeriod').style.display = 'flex';
            document.getElementById('summaryDuration').style.display = 'flex';
        }

        function calculatePricing() {
            if (totalDays === 0) return;
            
            const rateKey = selectedWithDriver ? 'with_driver' : 'without_driver';
            const dailyRate = dailyRates[rateKey];
            const subtotal = dailyRate * totalDays;
            
            // Calcul des réductions (identique au backend)
            let discountPercentage = 0;
            if (totalDays >= 14) {
                discountPercentage = 20;
            } else if (totalDays >= 10) {
                discountPercentage = 18;
            } else if (totalDays >= 7) {
                discountPercentage = 15;
            }
            
            const discountAmount = Math.round(subtotal * discountPercentage / 100);
            const finalTotal = subtotal - discountAmount;
            
            console.log('💰 Calcul des prix:', {
                daily_rate: dailyRate,
                days: totalDays,
                subtotal: subtotal,
                discount: discountPercentage + '%',
                final_total: finalTotal
            });
            
            updatePriceDisplay(subtotal, discountPercentage, discountAmount, finalTotal);
        }

        
        function updatePriceDisplay(subtotal, discountPercentage, discountAmount, finalTotal) {
            document.getElementById('priceBreakdown').style.display = 'block';
            document.getElementById('subtotalText').textContent = subtotal.toLocaleString('fr-FR') + ' FCFA';
            
            // Correction : Afficher ou masquer la ligne de réduction selon le cas
            const discountRow = document.getElementById('discountRow');
            
            if (discountPercentage > 0) {
                // Afficher la ligne de réduction
                discountRow.style.display = 'flex'; // ou 'block' selon votre CSS
                document.getElementById('discountBadge').textContent = `-${discountPercentage}%`;
                document.getElementById('discountText').textContent = `- ${discountAmount.toLocaleString('fr-FR')} FCFA`;
            } else {
                // Masquer la ligne de réduction
                discountRow.style.display = 'none';
            }
            
            document.getElementById('totalAmount').textContent = finalTotal.toLocaleString('fr-FR') + ' FCFA';
            currentPrice = finalTotal;
        }

        function setupTypeHandlers() {
            const typeCards = document.querySelectorAll('.dura-card');
        const withoutDriverInput = document.getElementById('radio-without-driver');
        const withDriverInput = document.getElementById('radio-with-driver');
        
        // Initialiser l'état par défaut
        updateCardSelection(withoutDriverInput, withDriverInput);
        
        typeCards.forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                
                const inputId = this.getAttribute('for');
                const input = document.getElementById(inputId);
                
                // Mettre à jour la sélection
                if (input.id === 'radio-with-driver') {
                    selectedWithDriver = true;
                    withoutDriverInput.checked = false;
                    withDriverInput.checked = true;
                } else {
                    selectedWithDriver = false;
                    withoutDriverInput.checked = true;
                    withDriverInput.checked = false;
                }
                
                // Mettre à jour l'affichage
                updateCardSelection(withoutDriverInput, withDriverInput);
                
                console.log('🔘 Type sélectionné:', selectedWithDriver ? 'Avec chauffeur' : 'Sans chauffeur');

                // Mettre à jour le champ caché
                document.getElementById('with_driver').value = selectedWithDriver ? '1' : '0';
                
                updateTypeDisplay();
                calculatePricing();
                updateSubmitButton();
                hideError('typeError');
            });
        });
        }

        function updateCardSelection(withoutDriverInput, withDriverInput) {
        const withoutDriverCard = document.querySelector('label[for="radio-without-driver"]');
        const withDriverCard = document.querySelector('label[for="radio-with-driver"]');
        
        if (withoutDriverInput.checked) {
            withoutDriverCard.classList.add('selected');
            withDriverCard.classList.remove('selected');
        } else {
            withDriverCard.classList.add('selected');
            withoutDriverCard.classList.remove('selected');
        }
     }

        function updateTypeDisplay() {
            const typeText = selectedWithDriver ? 'Avec chauffeur' : 'Sans chauffeur';
            const rateKey = selectedWithDriver ? 'with_driver' : 'without_driver';
            
            document.getElementById('typeText').textContent = typeText;
            document.getElementById('rateText').textContent = 
                dailyRates[rateKey].toLocaleString('fr-FR') + ' FCFA/jour';
        }

        function setupPolicyHandlers() {
            const acceptPoliciesCheckbox = document.getElementById('acceptPolicies');
            
            acceptPoliciesCheckbox.addEventListener('change', function() {
                policiesAccepted = this.checked;
                document.getElementById('terms_accepted').value = policiesAccepted ? '1' : '0';
                
                if (policiesAccepted) {
                    hideError('policyError');
                }
                
                updateSubmitButton();
            });
        }

        function setupFormHandlers() {
            const submitBtn = document.getElementById('submitBtn');
            
            // Écouter les changements dans les champs requis
            ['client_email', 'client_location'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateSubmitButton);
                    element.addEventListener('blur', updateSubmitButton);
                }
            });

            // ✅ Gestionnaire spécial pour le select personnalisé
            const originalSelect = document.getElementById('deployment_zone');
            if (originalSelect) {
                originalSelect.addEventListener('change', updateSubmitButton);
                originalSelect.addEventListener('input', updateSubmitButton);
            }
            
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                console.log('🔄 Tentative de soumission du formulaire');
                
                if (validateForm()) {
                    // Mettre à jour le numéro de téléphone avec le format international
                    if (window.phoneInput && window.phoneInput.isValidNumber()) {
                        document.getElementById('client_phone').value = window.phoneInput.getNumber();
                    }
                    
                    console.log('✅ Formulaire valide, soumission...');
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
                    
                    // Soumettre le formulaire
                    document.getElementById('reservationForm').submit();
                } else {
                    console.log('❌ Formulaire invalide');
                }
            });
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            
            // ✅ Vérifier si phoneInput existe avant de l'utiliser
            const phoneValue = window.phoneInput ? window.phoneInput.getNumber() : document.getElementById('client_phone').value;
            const phoneValid = window.phoneInput ? window.phoneInput.isValidNumber() : !!document.getElementById('client_phone').value;
            
            const requiredFields = [
                document.getElementById('start_date').value,
                document.getElementById('end_date').value,
                document.getElementById('start_time').value,
                document.getElementById('client_email').value,
                phoneValue,
                document.getElementById('client_location').value,
                document.getElementById('deployment_zone').value
            ];
            
            const allFieldsValid = requiredFields.every(field => field && field.trim() !== '') && 
                                phoneValid &&
                                policiesAccepted && 
                                totalDays > 0;
            
            console.log('🔍 Validation des champs:', {
                requiredFields: requiredFields.map(f => !!f),
                phoneValid,
                policiesAccepted,
                totalDays,
                allFieldsValid
            });
            
            submitBtn.disabled = !allFieldsValid;
            
            if (allFieldsValid) {
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }

        function validateForm() {
            let isValid = true;

            // Validation des dates
            if (!document.getElementById('start_date').value) {
                showError('startDateError', 'Veuillez sélectionner une date de début.');
                isValid = false;
            }

            if (!document.getElementById('end_date').value) {
                showError('endDateError', 'Veuillez sélectionner une date de fin.');
                isValid = false;
            }

            if (!document.getElementById('start_time').value) {
                showError('startTimeError', 'Veuillez sélectionner une heure de début.');
                isValid = false;
            }

            // Validation des politiques
            if (!policiesAccepted) {
                showError('policyError', 'Vous devez accepter les conditions pour continuer.');
                isValid = false;
            }

            // Validation email
            const email = document.getElementById('client_email').value;
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Veuillez saisir une adresse email valide.');
                isValid = false;
            }

            // ✅ Validation téléphone corrigée
            if (window.phoneInput) {
                if (!window.phoneInput.isValidNumber()) {
                    alert('Veuillez saisir un numéro de téléphone valide.');
                    isValid = false;
                }
            } else {
                const phone = document.getElementById('client_phone').value;
                if (!phone || phone.trim().length < 8) {
                    alert('Veuillez saisir un numéro de téléphone valide.');
                    isValid = false;
                }
            }

            // Validation localisation
            const location = document.getElementById('client_location').value;
            if (!location || location.trim().length < 3) {
                showError('locationError', 'Veuillez indiquer votre position actuelle (minimum 3 caractères).');
                isValid = false;
            } else {
                hideError('locationError');
            }

            // Validation zone de déplacement
            if (!document.getElementById('deployment_zone').value) {
                showError('zoneError', 'Veuillez sélectionner une zone de déplacement.');
                isValid = false;
            } else {
                hideError('zoneError');
            }

            return isValid;
        }

        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            if (message) element.textContent = message;
            element.style.display = 'block';
        }

        function hideError(elementId) {
            document.getElementById(elementId).style.display = 'none';
        }
    
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const customSelectWrapper = document.getElementById('customSelectWrapper');
        const customSelect = document.getElementById('customSelect');
        const customDropdown = document.getElementById('customDropdown');
        const originalSelect = document.getElementById('deployment_zone');
        const selectedValueDisplay = document.getElementById('selectedValue');
        
        let isOpen = false;

        // Fonction pour ouvrir/fermer le dropdown
        function toggleDropdown() {
            isOpen = !isOpen;
            customSelectWrapper.classList.toggle('open', isOpen);
            customDropdown.classList.toggle('show', isOpen);
        }

        // Fonction pour fermer le dropdown
        function closeDropdown() {
            isOpen = false;
            customSelectWrapper.classList.remove('open');
            customDropdown.classList.remove('show');
        }

        // Fonction pour sélectionner une option
        function selectOption(option) {
            const value = option.dataset.value;
            const text = option.textContent;

            // Mettre à jour le select original
            originalSelect.value = value;

            // Mettre à jour l'affichage du select personnalisé
            customSelect.textContent = text;
            customSelect.classList.toggle('placeholder', value === '');
            customSelect.classList.toggle('has-value', value !== '');

            // Mettre à jour les classes selected
            customDropdown.querySelectorAll('.custom-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            option.classList.add('selected');

            // Déclencher l'événement input sur le select original
            const event = new Event('input', { bubbles: true });
            originalSelect.dispatchEvent(event);

            // Fermer le dropdown
            closeDropdown();

            // Mettre à jour l'affichage de démonstration
            selectedValueDisplay.textContent = value || 'Aucune';
        }

        // Event listeners
        customSelect.addEventListener('click', toggleDropdown);

        // Gérer les clics sur les options
        customDropdown.querySelectorAll('.custom-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                selectOption(this);
            });
        });

        // Fermer le dropdown en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!customSelectWrapper.contains(e.target)) {
                closeDropdown();
            }
        });

        // Support du clavier
        customSelect.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        // Navigation au clavier dans les options
        customDropdown.addEventListener('keydown', function(e) {
            const options = Array.from(customDropdown.querySelectorAll('.custom-option'));
            const currentIndex = options.findIndex(opt => opt.classList.contains('selected'));

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = Math.min(currentIndex + 1, options.length - 1);
                selectOption(options[nextIndex]);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = Math.max(currentIndex - 1, 0);
                selectOption(options[prevIndex]);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                closeDropdown();
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        // Fonction pour définir une valeur par programmation (pour la compatibilité)
        window.setDeploymentZone = function(value) {
            const option = customDropdown.querySelector(`[data-value="${value}"]`);
            if (option) {
                selectOption(option);
            }
        };

        // Fonction pour obtenir la valeur actuelle
        window.getDeploymentZone = function() {
            return originalSelect.value;
        };

        // Fonction pour ajouter la classe d'erreur
        window.setDeploymentZoneError = function(hasError) {
            customSelect.classList.toggle('error', hasError);
        };
    });
    </script>
</body> 
</html>