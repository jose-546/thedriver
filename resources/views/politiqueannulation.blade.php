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
									<h1>Politique d’Annulation</h1>
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
            <h4>Chez <strong>WiDriveU</strong>, nous comprenons que des imprévus peuvent survenir. Cette politique d’annulation détaille les conditions et modalités applicables aux annulations de réservation de location de véhicules.</h4>
        </div>

        <div class="policy-section">
            <div class="section-title">1. Annulation par le client</div>
            <h6>a. Modalités d’annulation</h6>
            <p>Toute demande d’annulation doit être effectuée en contactant notre service client par email (<a href="mailto:reservation@widriveu.com">reservation@widriveu.com</a>) ou par téléphone au +229 94 08 08 08. L’annulation sera confirmée uniquement après réception par notre équipe.</p>
            <h6>b. Frais d’annulation</h6>
            <ul>
                <li>Plus de 48h avant : annulation gratuite, remboursement intégral.</li>
                <li>Entre 24 et 48h : frais de 10% du montant total.</li>
                <li>Moins de 24h : frais de 30% du montant total.</li>
            </ul>
            <h6>c. Non-présentation (no-show)</h6>
            <p>Si le locataire ne se présente pas et n’a pas informé TheDriver, la réservation sera annulée après 2 heures. Aucun remboursement ne sera effectué.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">2. Annulation par TheDriver</div>
            <ul>
                <li>Non-respect des conditions par le locataire (documents manquants, paiement incomplet, etc.).</li>
                <li>Indisponibilité du véhicule pour raisons indépendantes de notre volonté. Dans ce cas, nous proposerons une solution alternative ou un remboursement intégral.</li>
            </ul>
        </div>

        <div class="policy-section">
            <div class="section-title">3. Modifications de réservation</div>
            <p>Pour modifier votre réservation (dates, véhicule, etc.), contactez-nous au moins 48h avant. Modifications sous réserve de disponibilité et peuvent entraîner frais supplémentaires ou ajustement tarifaire.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">4. Remboursements</div>
            <p>Les remboursements seront effectués selon le mode de paiement utilisé. Délai : généralement entre 7 et 10 jours ouvrables.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">5. Cas de force majeure</div>
            <p>En cas de force majeure (catastrophe naturelle, restrictions gouvernementales, etc.), aucun frais d’annulation ne sera appliqué. Le locataire devra fournir une preuve appropriée.</p>
        </div>

        <div class="policy-section">
            <div class="section-title">6. Contact pour l’annulation</div>
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