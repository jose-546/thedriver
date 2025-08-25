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
       
        /* Sections */
        .policy-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        .policy-section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .section-title {
            font-size: 1.4rem;
            font-family: Outfit, Helvetica, Arial, sans-serif;
            font-weight: bold;
            color: #860000;
            border-left: 5px solid #ffb400;
            padding-left: 10px;
            margin-bottom: 1rem;
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
                <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1>Politique de Location</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->


    <!-- Content -->
    <div class="container py-5">
        <div class="policy-section">
            <h4>Chez <strong>WiDriveU</strong>, nous nous engageons à offrir un service de location de véhicules fiable et professionnel. Veuillez lire attentivement cette politique avant toute réservation.</h4>
        </div>

        <div class="policy-section">
            <div class="section-title">1. Éligibilité pour la location</div>
            <ul>
                <li>Être âgé de 18 ans.</li>
                <li>Permis de conduire valide depuis au moins 3 mois.</li>
                <li>Pièce d’identité valide.</li>
                <li>Preuve de domicile si nécessaire.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">2. Documents requis</div>
            <ul>
                <li>Permis de conduire valide.</li>
                <li>Pièce d’identité valide.</li>
                <li>Contrat de location signé.</li>
                <li>Moyen de paiement pour la caution.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">3. Conditions de location</div>
            <h6>a. Durée</h6>
            <p>Durée minimale : 1 jour. Retard non signalé : 5 000 F CFA/h.</p>
            <h6>b. Paiement</h6>
            <p>Paiement à l’avance. Inclus : assurance de base, entretien. Exclut : carburant, péages.</p>
            <h6>c. Caution</h6>
            <p>50 000 F CFA, restituée après contrôle.</p>
            <h6>d. Zone</h6>
            <p>Uniquement zones définies. Hors zone : frais supplémentaires.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">4. Responsabilités du locataire</div>
            <ul>
                <li>Retourner propre et en bon état.</li>
                <li>Carburant rempli comme au départ.</li>
                <li>Pas de transport illégal, courses ou sous-location.</li>
                <li>Informer immédiatement en cas d’accident.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">5. Assurance</div>
            <ul>
                <li>Incluse : assurance de base.</li>
                <li>Non couverts : dommages par conduite imprudente.</li>
                <li>Franchise possible selon contrat.</li>
                <li>Assurance supplémentaire disponible.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">6. Annulation et modification</div>
            <p>Annulation au moins 48h avant. Modifications sous réserve de disponibilité.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">7. Résiliation</div>
            <ul>
                <li>Par TheDriver : non-respect du contrat, usage abusif.</li>
                <li>Par locataire : restitution dans les délais.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">8. Loi applicable</div>
            <p>Lois de la République du Bénin. Litiges : tribunaux d’Abomey-Calavi.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">9. Contact</div>
            <p>
                📧 <a href="reservation@widriveu.com">reservation@widriveu.com</a><br>
                📞 +229 94 08 08 08<br>
                📍 Fidjrossè, Cotonou, Bénin
            </p>
        </div>
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
         <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
      


    // Sélectionne toutes les sections
    const sections = document.querySelectorAll('.policy-section');

    // On rend visibles immédiatement les deux premières sections
    sections.forEach((section, index) => {
        if (index < 2) { // Les deux premières sections visibles tout de suite
            section.classList.add('visible');
        }
    });

    // Fonction d'animation au scroll pour les autres sections
    const revealOnScroll = () => {
        const triggerBottom = window.innerHeight * 0.85;
        sections.forEach((section, index) => {
            if (index >= 2) { // Animation uniquement pour les sections après la 2ème
                const sectionTop = section.getBoundingClientRect().top;
                if (sectionTop < triggerBottom) {
                    section.classList.add('visible');
                }
            }
        });
    };

    // Événements
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();


    </script>
</body>

</html>