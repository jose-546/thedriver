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

<body>
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
                @include('partials.header')
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="full-height vertical-center" data-bgimage="url(images/background/yyye.png) bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="spacer-double sm-hide"></div>
                        <div class="col-lg-6">
                            <h4><span class="id-color">Votre mobilité, notre priorité.</span></h4>
                            <div class="spacer-10"></div>
                            <h1>Location de véhicules facile, rapide et fiable à Cotonou.</h1>
                            <p class="lead">WiDriveU vous offre une location de voitures simple, rapide et sécurisée, 24h/7j, avec une flotte adaptée à tous vos besoins.</p>

                            <a class="btn-main" href="{{ route('cars.search') }}">Réservez maintenant</a>&nbsp;&nbsp;&nbsp;<a class="btn-main btn-black" href="{{ route('login') }}">Démarrer</a>
                        </div>

                        <div class="col-lg-6">
                            <img src="{{ asset('images/misc/car-2.png') }}" class="img-fluid" alt="">
                        </div>
                        
                    </div>
                </div>
            </section>

            <section id="section-cars" class="no-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 offset-lg-3 text-center">
                            <h2>Découvrez notre flotte variée</h2>
                            <p>Des véhicules adaptés pour répondre parfaitement à vos besoins de déplacement, que ce soit au quotidien ou pour des occasions spéciales.</p></p>
                            <div class="spacer-20"></div>
                        </div>

                        <div class="clearfix"></div>
						{{-- Lites des Voitures disponibles --}}
						<div id="items-carousel" class="owl-carousel wow fadeIn">
								@foreach($cars as $car)
							<div class="col-lg-12">
							
									<div class="de-item mb30">
										<div class="d-img">
											<img src="{{ $car->getImageUrl() }}" style="height: 200px; object-fit: cover;" class="img-fluid" alt="{{ $car->name }}">
										</div>
										<div class="d-info">
											<div class="d-text">
												<h4>{{ $car->getFullName() }}</h4>
												
                                                    <div class="d-item_like">
                                                <a class="bouton-disponible" href="car-single.html">{{ $car->getStatusLabel() }}</a>
                                              <!--   <i class="fa fa-heart"></i><span>74</span> -->
                                                </div>
												<div class="d-atr-group">
													<span class="d-atr"><img src="{{ asset('images/icons/1-green.png') }}" alt=""> {{ $car->seats }} Places</span>
													<span class="d-atr"><img src="{{ asset('images/icons/2-green.png') }}" alt="">{{ $car->getFuelTypeLabel() }}</span>
													<span class="d-atr"><img src="{{ asset('images/icons/4-green.png') }}" alt="">{{ $car->getTransmissionLabel() }}</span>
												</div>
												<div class="d-price">
													<div class="pricing-info">
														<div class="price-without-driver">
														À partir de <span class="price-value">{{ number_format($car->daily_price_without_driver, 0, ',', ' ') }} FCFA</span>/jour
														</div>
													</div>
													<a class="btn-main mt-2" href="{{ route('cars.show', $car) }}">Voir Détail</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								@endforeach

						</div>

						<div class="spacer-10"></div>
						<div class="yy">  
							<a href="{{ route('cars.search') }}" class="bouton-voitures">Voir les voitures disponibles</a>
						</div>
                    </div>
                </div>
            </section>

              <section class="text-light jarallax" aria-label="section">
                <img src="{{ asset('images/background/3.jpg.png') }}" alt="" class="jarallax-img">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-light">
                            <div class="container-timeline">
                                <div class="col-lg-6 offset-lg-3 text-center">
                            <h2>Comment ça marche ?</h2>
                            <p>Réserver votre véhicule chez WiDriveU, c’est simple et rapide. Suivez ces étapes et profitez de votre voiture en toute tranquillité.</p>
                            <div class="spacer-20"></div>
                        </div>
                               
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

            
            <section aria-label="section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 offset-lg-3 text-center">
                            <h2>Pourquoi choisir WiDriveU ?</h2>
                            <p>Notre engagement : vous offrir une expérience de location de voiture sans stress, avec un service fiable, flexible et de qualité. Voici ce qui fait notre différence :</p>
                            <div class="spacer-20"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3">
                            <div class="box-icon s2 p-small mb20 wow fadeInRight" data-wow-delay=".5s">
                                <i class="fa bg-color fa-trophy"></i>
                                <div class="d-inner">
                                    <h4> Service Premium</h4>
                                    Des véhicules bien entretenus, un service client réactif et des prestations haut de gamme, pour une satisfaction totale.
                                </div>
                            </div>
                            <div class="box-icon s2 p-small mb20 wow fadeInL fadeInRight" data-wow-delay=".75s">
                                <i class="fa bg-color fa-road"></i>
                                <div class="d-inner">
                                    <h4>Flexibilité de réservation</h4>
                                     Profitez d’un excellent rapport qualité-prix, sans frais cachés. La location adaptée à tous les budgets.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <img src="{{ asset('images/misc/car-2.png') }}" alt="" class="img-fluid wow fadeInUp">
                        </div>

                        <div class="col-lg-3">
                            <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1s">
                                <i class="fa bg-color fa-tag"></i>
                                <div class="d-inner">
                                    <h4>Tarifs accessibles</h4>
                                     Réservez en toute liberté, pour une heure, une journée ou plus. Avec ou sans chauffeur, vous avez le choix.
                                </div>
                            </div>
                            <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1.25s">
                                <i class="fa bg-color fa-map-pin"></i>
                                <div class="d-inner">
                                    <h4>Sécurité garantie</h4>
                                     Tous nos véhicules sont assurés et contrôlés régulièrement pour garantir votre sécurité à chaque trajet.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

              <section id="section-img-with-tab" data-bgcolor="#f8f8f8">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 offset-lg-7">
                            
                            <h2>L’excellence au service de votre mobilité</h2>
                            <div class="spacer-20"></div>
                            
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                              <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Luxe</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Confort</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Prestige</button>
                              </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"><p>Chez WiDriveU, nous sélectionnons des véhicules qui incarnent le raffinement, avec des finitions soignées, un design moderne et des équipements haut de gamme. Chaque trajet devient une expérience où style et performance se rencontrent, pour que vous rouliez avec classe en toutes circonstances.</p></div>
                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"><p>Nos véhicules sont pensés pour rendre vos déplacements agréables, que ce soit pour de courts trajets ou de longues distances. Sièges ergonomiques, climatisation, insonorisation optimisée et espace généreux : tout est réuni pour que chaque instant passé à bord soit synonyme de détente.</p></div>
                              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"><p>Rouler avec WiDriveU, c’est opter pour des modèles qui attirent le regard et suscitent le respect. Que ce soit pour un rendez-vous professionnel, un événement spécial ou simplement pour vous faire plaisir, nous vous offrons le prestige d’un véhicule qui reflète votre goût de l’excellence.</p></div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="image-container col-md-6 pull-right" data-bgimage="url(images/background/5.jpg) center"></div>
            </section>

            <div class="spacer-40"></div>
            <div class="spacer-40"></div>
            <div class="spacer-40"></div>
              <section id="section-testimonials" class="no-top no-bottom">
                <div class="container-fluid">
                    <div class="row g-2 p-2 align-items-center">

                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-colo"><i class="fa fa-quote-right"></i></div>
                                    <h4>Un service impeccable</h4>
                                    <blockquote>
                                      J’ai loué un véhicule pour un week-end et tout s’est passé à merveille. La voiture était propre, confortable et en parfait état. L’équipe a été très professionnelle du début à la fin.
                                   <span class="by">Sandra Houénou</span>
                                    </blockquote>
                                </div> 
                                <img src="{{ asset('images/testimonial/P.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-colo"><i class="fa fa-quote-right"></i></div>
                                    <h4>Une expérience sans stress</h4>
                                    <blockquote>
                                       Réserver avec WiDriveU a été simple et rapide. La flexibilité des horaires et la gentillesse du chauffeur ont rendu mon voyage beaucoup plus agréable.
                                       <span class="by">Fabrice Agossou</span>
                                   </blockquote>
                                </div>
                                <img src="{{ asset('images/testimonial/P.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="de-image-text">
                                <div class="d-text">
                                    <div class="d-quote id-colo"><i class="fa fa-quote-right"></i></div>
                                    <h4>Qualité et fiabilité au rendez-vous</h4>
                                    <blockquote>
                                       C’est rassurant de savoir que les véhicules sont bien entretenus. Je recommande WiDriveU à tous ceux qui veulent voyager en toute sécurité. 
                                       <span class="by">Mireille Zinsou</span>
                                   </blockquote>
                                </div>
                                <img src="{{ asset('images/testimonial/P.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section id="section-faq">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <h2>Vos questions, nos réponses</h2>
                            <div class="spacer-20"></div>
                        </div>
                    </div>
                    <div class="row g-custom-x">
                        <div class="col-md-6 wow fadeInUp">
                            <div class="accordion secondary">
                                <div class="accordion-section">
                                    <div class="accordion-section-title" data-tab="#accordion-1">
                                        Comment réserver un véhicule chez WiDriveU ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-1">
                                        <p>Vous pouvez réserver directement via notre application, notre site web ou par téléphone. Choisissez votre véhicule, vos dates et validez en quelques clics.</p>
                                    </div>
                                    <div class="accordion-section-title" data-tab="#accordion-2">
                                        Proposez-vous un service avec chauffeur ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-2">
                                        <p>Oui, vous pouvez louer un véhicule avec chauffeur pour plus de confort et de tranquillité, que ce soit pour quelques heures ou plusieurs jours.</p>
                                    </div>
                                    <div class="accordion-section-title" data-tab="#accordion-3">
                                        Quels types de véhicules sont disponibles ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-3">
                                        <p>Notre flotte comprend des SUV, berlines, 4x4, pick-ups et véhicules pour occasions spéciales, tous bien entretenus et récents.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 wow fadeInUp">
                            <div class="accordion secondary">
                                <div class="accordion-section">
                                    <div class="accordion-section-title" data-tab="#accordion-b-4">
                                        Puis-je louer un véhicule pour une courte durée ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-b-4">
                                        <p>Oui, nous proposons la location journalière et à long terme, selon vos besoins.</p>
                                    </div>
                                    <div class="accordion-section-title" data-tab="#accordion-b-5">
                                        Les véhicules sont-ils assurés ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-b-5">
                                        <p>Oui, tous nos véhicules sont couverts par une assurance et subissent des contrôles techniques réguliers pour garantir votre sécurité.</p>
                                    </div>
                                    <div class="accordion-section-title" data-tab="#accordion-b-6">
                                       Proposez-vous un service de prise en charge à l’aéroport ?
                                    </div>
                                    <div class="accordion-section-content" id="accordion-b-6">
                                        <p>Oui, nous pouvons venir vous chercher ou vous déposer à l’aéroport à l’heure de votre choix.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-call-to-action" class="bg-color pt60 pb60 text-light">
                <div class="container">
                    <div class="container">
                    <div class="row">

                        <div class="col-lg-4 offset-lg-2">
                            <span class="subtitle text-white">Appelez-nous pour plus d'informations</span>
                            <h2 class="s2">Le service client de WiDriveU est là pour vous aider à tout moment.</h2>
                        </div>

                        <div class="col-lg-4 text-lg-center text-sm-center">
                            <div class="phone-num-big">
                                <i class="fa fa-phone"></i>
                                <span class="pnb-text">
                                    Appelez-nous maintenant
                                </span>
                                <span class="pnb-num">
                                    +229 0194080808
                                </span>
                                
                            </div>
                            <a href="{{ asset('#') }}" class="btn-main btn-line">Contactez-nous</a>
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
    
    <!-- Javascript Files
    ================================================== -->
    <script>
    document.getElementById("year").textContent = new Date().getFullYear();
    </script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

</body>

</html>