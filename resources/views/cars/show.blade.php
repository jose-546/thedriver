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
</head>
    <style>
        /* Styles personnalisés pour la galerie d'images */
        .owl-carousel .item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
         
        .owl-dots {
            text-align: center;
            margin-top: 20px;
        }
        
        .owl-dot {
            display: inline-block;
            margin: 0 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ccc;
            cursor: pointer;
        }
        
        .carousel-container {
            position: relative;
        }

        /* Styles pour la section tarifs */
        .pricing-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        .pricing-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .pricing-item:last-child {
            border-bottom: none;
        }

        .pricing-label {
            font-weight: 500;
            color: #495057;
        }

        .pricing-value {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }

        .discount-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #2196f3;
        }

        .discount-info h6 {
            color: #1976d2;
            margin-bottom: 8px;
        }

        .discount-info ul {
            margin: 0;
            padding-left: 20px;
        }

        .discount-info li {
            color: #424242;
            font-size: 14px;
        }
    </style>

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
                            <div class="col-md-12 text-center">
                                <h1>Détail véhicules</h1>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
            
            <section id="section-car-details">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6">
                            <div class="carousel-container">
                                <div id="slider-carousel" class="owl-carousel">
                                    <!-- Image principale de la voiture -->
                                    <div class="item">
                                        <img src="{{ $car->getImageUrl() }}" alt="{{ $car->name }} - Image principale">
                                    </div>
                                   
                                    <!-- Images de la galerie -->
                                    @if($car->galleries && $car->galleries->count() > 0)
                                        @foreach($car->galleries as $gallery)
                                            <div class="item">
                                                <img src="{{ $gallery->getImageUrl() }}" alt="{{ $gallery->alt_text ?? $car->name }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3">
                            <h3>{{ $car->name }}</h3>
                            <p>{{ $car->description ? Str::limit($car->description, 190) : 'Aucune description disponible.' }}</p>
                            
                            <div class="spacer-10"></div>

                            <h4>Détails Techniques</h4>
                            <div class="de-spec">
                                <div class="d-row">
                                    <span class="d-title">Marque</span>
                                    <span class="d-value">{{ $car->brand }}</span>
                                </div>
                                <div class="d-row">
                                    <span class="d-title">Modèle</span>
                                    <span class="d-value">{{ $car->model }}</span>
                                </div>
                                <div class="d-row">
                                    <span class="d-title">Année</span>
                                    <span class="d-value">{{ $car->year }}</span>
                                </div>
                                <div class="d-row">
                                    <span class="d-title">Carburant</span>
                                    <span class="d-value">{{ $car->getFuelTypeLabel() }}</span>
                                </div>
                                <div class="d-row">
                                    <span class="d-title">Transmission</span>
                                    <span class="d-value">{{ $car->getTransmissionLabel() }}</span>
                                </div>
                                <div class="d-row">
                                    <span class="d-title">Places</span>
                                    <span class="d-value">{{ $car->seats }}</span>
                                </div>
                                <div class="mt-1">
                                    <span class="d-title">Statut</span>
                                    <spam class="d-value"><a class="bbadge" href="{{ asset('#') }}">{{ $car->getStatusLabel()}}</a></spam>
                                </div>
                                
                            </div>

                            <div class="spacer-single"></div>

                            
                        </div>

                        <div class="col-lg-3">
                            
                            <!-- <div class="spacer-30"></div> -->
                             <div class="de-price text-center">
                                 Tarif journalier
                            <h3>{{ number_format($car->daily_price_without_driver, 0, ',', ' ') }} <br> FCFA</h3>       
                            </div>
                            <div class="spacer-30"></div>
                            <div class="de-box mb25">
                                <form name="contactForm" id='contact_form' method="post">
                                    <h4>Offres de réduction</h4>

                              

                                    <div class="row">
                                        <div class="col-lg-12 mb20">
                                           
                                           <div class="de-spec">
                                                <div class="d-row">
                                                    <span class="d-title">7-9 jours</span>
                                                    <spam class="d-value">-15%</spam>
                                                </div>
                                                <div class="d-row">
                                                    <span class="d-title">10-13 jours</span>
                                                    <spam class="d-value">-18%</spam>
                                                </div>
                                                <div class="d-row">
                                                    <span class="d-title">14+ jours</span>
                                                    <spam class="d-value">-20%</spam>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>


                                        
                                    </div>

                                <!-- Bouton de réservation -->
                               <!--  @if($car->isAvailable())
                                    <input type='button' id='send_message' value='Réserver maintenant'
                                    onclick="window.location.href='{{ route('reservations.create', $car) }}'"
                                    class="btn-main btn-fullwidth">
                                @else
                                    <input type='button' id='send_message' value='Non disponible' class="btn-main btn-fullwidth" disabled>
                                @endif -->

                                @if($car->isAvailable())
    <a href="{{ route('reservations.create', $car) }}" class="btn-main btn-fullwidth">
        Réserver maintenant
    </a>
@else
    <a href="#" class="btn-main btn-fullwidth disabled" aria-disabled="true">
        Non disponible
    </a>
@endif
                                    <div class="clearfix"></div>
                                    
                                </form>
                            </div>

                            
                        </div>                
                    </div>
                    
                </div>
            </section>
            
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
        <!-- content close -->

        <a href="#" id="back-to-top"></a>
        
        <!-- footer begin -->
        @include('partials.footer')
        <!-- footer close -->
    </div>

    <!-- Javascript Files -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Configuration du carousel Owl
            var owl = $('#slider-carousel').owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                navText: [
                    '<i class="fa fa-chevron-left"></i>',
                    '<i class="fa fa-chevron-right"></i>'
                ],
                autoplay: false,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    992: {
                        items: 1
                    }
                }
            });

            // Navigation au clavier
            $(document).keydown(function(e) {
                if (e.keyCode == 37) { // Flèche gauche
                    owl.trigger('prev.owl.carousel');
                } else if (e.keyCode == 39) { // Flèche droite
                    owl.trigger('next.owl.carousel');
                }
            });

            // Gestion du swipe sur mobile (si pas déjà inclus dans Owl Carousel)
            var startX = 0;
            var endX = 0;

            $('.owl-carousel').on('touchstart', function(e) {
                startX = e.originalEvent.touches[0].clientX;
            });

            $('.owl-carousel').on('touchend', function(e) {
                endX = e.originalEvent.changedTouches[0].clientX;
                var threshold = 50;
                
                if (startX - endX > threshold) {
                    owl.trigger('next.owl.carousel');
                } else if (endX - startX > threshold) {
                    owl.trigger('prev.owl.carousel');
                }
            });
        });
        
    </script>
</body>

</html>