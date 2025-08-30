<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentaly - Location de Véhicules</title>
    
    <!-- Balises Meta -->
    <meta name="description" content="Rentaly - Site de location de véhicules multiusage">
    <meta name="keywords" content="location, voiture, véhicule, rental, automobile">
    <meta name="author" content="Rentaly">
    <link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">
    
    <!-- Fichiers CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="css/mdb.min.css" rel="stylesheet" type="text/css" id="mdb">
    <link href="css/plugins.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/coloring.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Schéma de couleurs -->
    <link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        <!-- Préchargeur de page -->
        <div id="de-preloader"></div>
        
        <!-- En-tête de la page -->
        @include('partials.headerblanc')
        <!-- Fin de l'en-tête -->
        
        <!-- Contenu principal -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            
            <!-- Section Hero avec formulaire de connexion -->
            <section id="section-hero" aria-label="section" class="jarallax">
                <img src="images/background/2.jpg" class="jarallax-img" alt="Image d'arrière-plan">
                
                <div class="v-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-4 offset-lg-4">
                                <!-- Conteneur de connexion -->
                                <div class="padding40 rounded-3 shadow-soft" data-bgcolor="#ffffff">
                                    <h4>Connexion</h4>
                                    
                                    <!-- Messages de statut de session -->
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    
                                    <div class="spacer-10"></div>
                                    
                                    <!-- Formulaire de connexion -->
                                    <form method="POST" action="{{ route('login') }}" id="form_login" class="">
                                        @csrf
                                        
                                        <!-- Champ Email -->
                                        <div class="field-set">
                                            <input type="text" 
                                                   name="email" 
                                                   id="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   placeholder="Adresse email"
                                                   value="{{ old('email') }}"
                                                   required 
                                                   autofocus 
                                                   autocomplete="username" />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="spacer-10"></div>
                                        
                                        <!-- Champ Mot de passe -->
                                        <div class="field-set">
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Mot de passe"
                                                   required 
                                                   autocomplete="current-password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Case à cocher "Se souvenir de moi" -->
                                        <div class="field-set policy-checkbox">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="remember_me" 
                                                       name="remember">
                                                <label class="form-check-label" for="remember_me">
                                                    Se souvenir de moi
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <!-- Bouton de soumission -->
                                        <div id="submit">
                                            <input type="submit" 
                                                   id="send_message" 
                                                   value="Se connecter" 
                                                   class="btn-main btn-fullwidth rounded-3" />
                                        </div>
                                        
                                        <!-- Liens supplémentaires -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            @if (Route::has('password.request'))
                                                <a class="text-decoration-none text-muted" href="{{ route('password.request') }}">
                                                    Mot de passe oublié ?
                                                </a>
                                            @endif
                                        </div>
                                        <div class="text-right mt-2">
                                            <a href="{{ route('register') }}" class="text-decoration-none">
                                                Pas encore de compte ?
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Fin du contenu -->
        
        <!-- Fichiers Javascript -->
        <script src="js/plugins.js"></script>
        <script src="js/designesia.js"></script>
        
        <!-- CSS personnalisé pour les styles de validation Bootstrap -->
        <style>
            .is-invalid {
                border-color: #dc3545 !important;
            }
            
            .invalid-feedback {
                display: block;
                color: #dc3545;
                font-size: 0.875em;
                margin-top: 0.25rem;
            }
            
            .form-check {
                margin-bottom: 1rem;
                margin-left: 4px;
            }
            
            .form-check-input {
                margin-right: 0.5rem;
            }
            
            .alert-success {
                background-color: #d4edda;
                border-color: #c3e6cb;
                color: #155724;
                padding: 0.75rem 1.25rem;
                border: 1px solid;
                border-radius: 0.375rem;
            }
            
            .policy-checkbox {
                margin-top: 15px;
            }

            .policy-checkbox .form-check-input {
                border: 1px solid #860000;
                width: 1em;
                height: 1em;
            }

            .policy-checkbox .form-check-input:checked {
                background-color: #860000;
                border-color: #860000;
            }
        </style>
    </div>
</body>
</html>