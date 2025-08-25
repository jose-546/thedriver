<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>WiDriveU</title>
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Rentaly - Multipurpose Vehicle Car Rental Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css') }}">

    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    
    <style>
        /* Styles de remplacement pour les classes Tailwind */
        .tw-container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }
        
        @media (min-width: 640px) {
            .tw-container {
                max-width: 640px;
            }
        }
        
        @media (min-width: 768px) {
            .tw-container {
                max-width: 768px;
            }
        }
        
        @media (min-width: 1024px) {
            .tw-container {
                max-width: 1024px;
            }
        }
        
        @media (min-width: 1280px) {
            .tw-container {
                max-width: 1280px;
            }
        }
        
        .tw-mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .tw-px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .tw-py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .tw-flex {
            display: flex;
        }
        
        .tw-flex-col {
            flex-direction: column;
        }
        
        @media (min-width: 1024px) {
            .lg\:tw-flex-row {
                flex-direction: row;
            }
        }
        
        .tw-gap-8 {
            gap: 2rem;
        }
        
        .tw-bg-white {
            background-color: #fff;
        }
        
        .tw-rounded-lg {
            border-radius: 0.5rem;
        }
        
        .tw-shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .tw-overflow-hidden {
            overflow: hidden;
        }
        
        .tw-transition-shadow {
            transition-property: box-shadow;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .tw-duration-300 {
            transition-duration: 300ms;
        }
        
        .tw-w-full {
            width: 100%;
        }
        
        .tw-h-48 {
            height: 12rem;
        }
        
        .tw-object-cover {
            object-fit: cover;
        }
        
        .tw-p-4 {
            padding: 1rem;
        }
        
        .tw-flex-justify-between {
            justify-content: space-between;
        }
        
        .tw-items-start {
            align-items: flex-start;
        }
        

        
        .tw-text-lg {
            font-size: 1.125rem;
            line-height: 1.40rem;
        }
        
        .tw-font-semibold {
            font-weight: 600;
        }
        
        .tw-text-gray-900 {
            color: #1a202c;
        }
        
        .tw-text-gray-600 {
            color: #718096;
        }
        
        .tw-text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .tw-mb-3 {
            margin-bottom: 0.75rem;
        }
        
        .tw-mb-4 {
            margin-bottom: 1rem;
        }
        
        .tw-text-2xl {
            font-size: 1.3rem;
            line-height: 2rem;
        }
        
        .tw-font-bold {
            font-weight: 700;
        }
        
        .tw-text-black {
            color: #000;
        }
        
        .tw-text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .tw-text-gray-500 {
            color: #a0aec0;
        }
        
        .tw-mt-2 {
            margin-top: 0.5rem;
        }
        
        .tw-text-center {
            text-align: center;
        }
        
        .tw-py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        
        .tw-text-gray-400 {
            color: #cbd5e0;
        }
        
        .tw-mb-4 {
            margin-bottom: 1rem;
        }
        
        .tw-text-6xl {
            font-size: 3.75rem;
            line-height: 1;
        }
        
        .tw-text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
        .tw-font-medium {
            font-weight: 500;
        }
        
        .tw-flex-wrap {
            flex-wrap: wrap;
        }
        
        /* Classes responsives */
        @media (min-width: 768px) {
            .md\:tw-w-1\/2 {
                width: 50%;
            }
        }
        
        @media (min-width: 1280px) {
            .xl\:tw-w-1\/3 {
                width: 33.333333%;
            }
        }
        
        /* Classes pour les marges négatives et padding */
        .-tw-mx-3 {
            margin-left: -0.75rem;
            margin-right: -0.75rem;
        }
        
        .tw-px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .tw-mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .tw-mt-8 {
            margin-top: 2rem;
        }
        
        /* Classes pour les états de survol */
        .hover\:tw-shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Classes pour les largeurs responsives */
        @media (min-width: 1024px) {
            .lg\:tw-w-3\/4 {
                width: 75%;
            }
        }
        
        /* Styles pour les boutons */
        .tw-bg-blue-600 {
            background-color: #860000;
        }
        
        .tw-text-white {
            color: #fff;
        }
        
        .tw-py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .tw-px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .tw-rounded-md {
            border-radius: 0.375rem;
        }
        
        .hover\:tw-bg-blue-700:hover {
            background-color: #860000;
        }
        
        .tw-transition {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .tw-duration-200 {
            transition-duration: 200ms;
        }
        
        /* Classes utilitaires pour flexbox */
        .tw-items-center {
            align-items: center;
        }
        
        .tw-gap-1 {
            gap: 0.25rem;
        }
        
        .tw-gap-2 {
            gap: 0.5rem;
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
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
                <!-- section begin -->
                    <section id="subheader" class="jarallax text-light">
                        <img src="{{asset('images/background/2.jpg') }}" class="jarallax-img" alt="#">
                        <div class="center-y relative text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="text-5xl">
                                        <h1>Voitures disponibles</h1>
                                        <div class="text-sm text-light mt-2">
                                        {{ $stats['total_found'] }} voiture(s) trouvée(s) sur {{ $stats['total_available'] }} disponibles
                                    </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- section close -->
                 <section id="section-cars">
                <div class="container">
                    <div class="row">
          
                <div class="tw-container tw-mx-auto tw-px-4 tw-py-8">
                    <div class="tw-flex tw-flex-col lg:tw-flex-row tw-gap-8">
                        <!-- Sidebar Filtres -->
                        <div class="col-lg-3">
                                    <form id="filterForm" method="GET" action="{{ route('cars.search') }}">
                                        <!-- Marques -->
                                        <div class="item_filter_group">
                                            <h4>Marques</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['brands'] as $brand)
                                                <div class="de_checkbox">
                                                    <input id="brand_{{ $brand }}" name="brands[]" type="checkbox" value="{{ $brand }}"
                                                        {{ in_array($brand, request('brands', [])) ? 'checked' : '' }}>
                                                    <label for="brand_{{ $brand }}">{{ ucfirst($brand) }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Modèles -->
                                        <div class="item_filter_group">
                                            <h4>Modèles</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['models'] as $model)
                                                <div class="de_checkbox">
                                                    <input id="model_{{ $model }}" name="models[]" type="checkbox" value="{{ $model }}"
                                                        {{ in_array($model, request('models', [])) ? 'checked' : '' }}>
                                                    <label for="model_{{ $model }}">{{ $model }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Années -->
                                        <div class="item_filter_group">
                                            <h4>Année</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['years'] as $year)
                                                <div class="de_checkbox">
                                                    <input id="year_{{ $year }}" name="years[]" type="checkbox" value="{{ $year }}"
                                                        {{ in_array($year, request('years', [])) ? 'checked' : '' }}>
                                                    <label for="year_{{ $year }}">{{ $year }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Type de carburant -->
                                        <div class="item_filter_group">
                                            <h4>Carburant</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['fuel_types'] as $fuel)
                                                <div class="de_checkbox">
                                                    <input id="fuel_{{ $fuel }}" name="fuel_types[]" type="checkbox" value="{{ $fuel }}"
                                                        {{ in_array($fuel, request('fuel_types', [])) ? 'checked' : '' }}>
                                                    <label for="fuel_{{ $fuel }}">{{ ucfirst($fuel) }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Transmission -->
                                        <div class="item_filter_group">
                                            <h4>Transmission</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['transmissions'] as $transmission)
                                                <div class="de_checkbox">
                                                    <input id="trans_{{ $transmission }}" name="transmissions[]" type="checkbox" value="{{ $transmission }}"
                                                        {{ in_array($transmission, request('transmissions', [])) ? 'checked' : '' }}>
                                                    <label for="trans_{{ $transmission }}">{{ ucfirst($transmission) }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Nombre de places -->
                                        <div class="item_filter_group">
                                            <h4>Nombre de places</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['seats_options'] as $seats)
                                                <div class="de_checkbox">
                                                    <input id="seats_{{ $seats }}" name="seats[]" type="checkbox" value="{{ $seats }}"
                                                        {{ in_array($seats, request('seats', [])) ? 'checked' : '' }}>
                                                    <label for="seats_{{ $seats }}">{{ $seats }} places</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Gamme de prix -->
                                        <div class="item_filter_group">
                                            <h4>Prix par jour (FCFA)</h4>
                                            <div class="de_form">
                                                @foreach($filterOptions['price_ranges'] as $key => $label)
                                                <div class="de_checkbox">
                                                    <input id="price_{{ $key }}" name="price_ranges[]" type="checkbox" value="{{ $key }}"
                                                        {{ in_array($key, request('price_ranges', [])) ? 'checked' : '' }}>
                                                    <label for="price_{{ $key }}">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Boutons -->
                                        <div class="reinitialiser">
                                            <a href="{{ route('cars.search') }}" class="btn-main btn-full">Réinitialiser</a>
                                        </div>
                                    </form>
                                </div>

                        <!-- Résultats -->
                                <div class="lg:tw-w-3/4">
                                    @if($cars->count() > 0)
                                    <div class="tw-flex tw-flex-wrap -tw-mx-3">
                                        @foreach($cars as $car)
                                        <div class="tw-w-full md:tw-w-1/2 xl:tw-w-1/3 tw-px-3 tw-mb-6">
                                            <div class="tw-bg-white tw-rounded-lg tw-shadow-md tw-overflow-hidden hover:tw-shadow-lg tw-transition-shadow tw-duration-300">
                                                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                                    <img src="{{ $car->getImageUrl() }}" 
                                                        alt="{{ $car->name }}" 
                                                        class="tw-w-full tw-h-48 tw-object-cover">
                                                </div>
                                                
                                                <div class="tw-p-4">
                                                    <div class="tw-flex tw-justify-between tw-items-start">
                                                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">{{ $car->name }}</h3>
                                                    </div>
                                                    
                                                    <p class="tw-text-gray-600 tw-text-sm tw-mb-3">{{ $car->getFullName() }}</p>
                                                    
                                                    <div class="d-atr-group tw-flex tw-flex-wrap tw-gap-2 tw-mb-3">
                                                        <span class="dooo tw-flex tw-items-center tw-gap-1">
                                                            <img src="{{ asset('images/icons/1-green.png') }}" alt=""> {{ $car->seats }} Places
                                                        </span>
                                                        <span class="dooo tw-flex tw-items-center tw-gap-1">
                                                            <img src="{{ asset('images/icons/2-green.png') }}" alt="">{{ $car->getFuelTypeLabel() }}
                                                        </span>
                                                        <span class="dooo tw-flex tw-items-center tw-gap-1">
                                                            <img src="{{ asset('images/icons/4-green.png') }}" alt="">{{ $car->getTransmissionLabel() }}
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="tw-mb-4">
                                                        <div class="tw-text-2xl tw-font-bold tw-text-black">
                                                            {{ number_format($car->daily_price_without_driver, 0, ',', ' ') }} FCFA /
                                                            <small class="tw-text-xs tw-text-gray-500"> par jour</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="">
                                                        <div class="tw-flex tw-mt-2 tw-gap-2">
                                                            <a class="bouton-detail" href="{{ route('cars.show', $car->id) }}">Détails</a>
                                                            <a class="btn-main" href="{{ route('reservations.create', $car->id) }}">Réserver</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- Pagination -->
                                    <div class="tw-mt-8">
                                        {{ $cars->links() }}
                                    </div>
                                    @else
                                    <div class="tw-text-center tw-py-12">
                                        <div class="tw-text-gray-400 tw-mb-4">
                                            <i class="fas fa-search tw-text-6xl"></i>
                                        </div>
                                        <h3 class="tw-text-xl tw-font-medium tw-text-gray-900">Aucune voiture trouvée</h3>
                                        <p class="tw-text-gray-600 tw-mb-4">Essayez de modifier vos critères de recherche</p>
                                        <a href="{{ route('cars.search') }}" class="tw-bg-blue-600 tw-text-white tw-py-2 tw-px-4 tw-rounded-md tw-transition tw-duration-200">
                                            Voir toutes les voitures
                                        </a>
                                    </div>
                                    @endif
                                    </div>

                    </div>
                </div>
                </div>
                </div>
                </section>
        </div>
                <section id="section-car-details" aria-label="section" class="no-top" data-bgcolor="#121212">
            <div class="container">
                <div class=" g-5 row text-light">
                    <div class="spacer-10"></div>
                    <div class="col-lg-12">
                        <div class="container-timeline">
                            <ul>
                                    <li>
                                        <h4>Choisissez votre véhicule</h4>
                                        <p>Parcourez notre flotte et trouvez la voiture qui correspond parfaitement à vos besoins et à votre style.</p>
                                    </li>
                                    <li>
                                        <h4>Consultez les informations</h4>
                                        <p>Accédez aux caractéristiques, options et tarifs détaillés pour comparer et être sûr de faire le bon choix avant de réserver.</p>
                                    </li>
                                    <li>
                                        <h4>Réservez en quelques clics</h4>
                                        <p> Indiquez vos dates, vos options et validez votre réservation en ligne ou par téléphone.</p>
                                    </li>
                                    <li>
                                        <h4>Suivez votre réservation</h4>
                                        <p>Recevez toutes les informations et mises à jour sur votre réservation, du suivi en temps réel jusqu’à la remise des clés en main.</p>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            
			 <section aria-label="section" class="pt40 pb40 text-light">
                <div class="wow fadeInRight d-flex">
                  <div class="de-marquee-list s2">
                    <div class="d-item">
                      <span class="d-item-txt">SUV</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Berlines</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Pick-up</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Breaks</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Voitures de luxe</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Sports Car</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Véhicules compacts</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                     
                     </div>
                  </div>
                     <div class="de-marquee-list s2">
                    <div class="d-item">
                      <span class="d-item-txt">SUV</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Berlines</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Pick-up</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Breaks</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Voitures de luxe</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Sports Car</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                      <span class="d-item-txt">Véhicules compacts</span>
                      <span class="d-item-display">
                        <i class="d-item-dot"></i>
                      </span>
                     </div>
                  </div>
               
                </div>
            </section>
    </div>

    <!-- Font Awesome pour les icônes -->
    <a href="#" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('partials.footer')
        <!-- footer close -->

    <!-- Javascript Files -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
    <script>
        // Auto-submit du formulaire lors du changement des checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            const selectElements = form.querySelectorAll('select');
            
            // Auto-submit pour les checkboxes (avec un petit délai pour éviter trop de requêtes)
            let submitTimeout;
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    clearTimeout(submitTimeout);
                    submitTimeout = setTimeout(() => {
                        form.submit();
                    }, 500);
                });
            });
            
            // Auto-submit pour les selects
            selectElements.forEach(select => {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });
            
            // Recherche avec délai pour la barre de recherche
            const searchInput = form.querySelector('input[name="search"]');
            let searchTimeout;
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        form.submit();
                    }, 1000);
                });
            }
        });
    </script>
      <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>