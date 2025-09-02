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
    
    <!-- Icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                                <!-- Conteneur de connexion -->
                                <div class="login-container padding40 rounded-3 shadow-soft" data-bgcolor="#ffffff">
                                    <div class="text-center mb-4">
                                        <h4 class="login-title">Connexion</h4>
                                    </div>
                                    
                                    <!-- Messages de statut de session -->
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            <i class="fas fa-check-circle me-2"></i>
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    
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
                                            <div class="password-input-wrapper">
                                                <input type="password" 
                                                       name="password" 
                                                       id="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       placeholder="Mot de passe"
                                                       required 
                                                       autocomplete="current-password" />
                                                <button type="button" class="password-toggle-btn" id="togglePassword">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
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
        
        <!-- Script pour l'affichage/masquage du mot de passe -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');
                
                if (togglePassword && passwordInput && eyeIcon) {
                    togglePassword.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        
                        // Changer l'icône
                        if (type === 'password') {
                            eyeIcon.classList.remove('fa-eye-slash');
                            eyeIcon.classList.add('fa-eye');
                        } else {
                            eyeIcon.classList.remove('fa-eye');
                            eyeIcon.classList.add('fa-eye-slash');
                        }
                    });
                }
            });
        </script>
        
        <!-- CSS personnalisé pour les styles de validation Bootstrap -->
        <style>
            /* Wrapper pour le champ mot de passe avec bouton toggle */
            .password-input-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }
            
            .password-input-wrapper .form-control {
                padding-right: 45px;
            }
            
            .password-toggle-btn {
                position: absolute;
                right: 10px;
                background: none;
                border: none;
                color: #6c757d;
                cursor: pointer;
                padding: 5px;
                z-index: 10;
                transition: color 0.3s ease;
            }

            
            
            .password-toggle-btn:hover {
                color: #860000;
            }
            
            .password-toggle-btn:focus {
                outline: none;
                color: #860000;
            }
            
            /* Styles de validation */
            .is-invalid {
                border-color: #dc3545 !important;
            }
            
            .invalid-feedback {
                display: block !important;
                color: #dc3545;
                font-size: 0.875em;
                margin-top: 0.5rem;
                margin-left: 0.25rem;
                padding: 0.5rem;
                background-color: rgba(220, 53, 69, 0.1);
                border-radius: 0.25rem;
                border-left: 3px solid #dc3545;
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
                border: 2px solid #860000 !important;
                width: 1.1em;
                height: 1.1em;
                border-radius: 0.25rem;
                background-color: transparent;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .policy-checkbox .form-check-input:checked {
                background-color: #860000 !important;
                border-color: #860000 !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
            }
            
            .policy-checkbox .form-check-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(134, 0, 0, 0.25);
            }
            
            /* Bouton principal avec couleur #860000 */
            .btn-main {
                background-color: #860000;
                border-color: #860000;
                color: white;
                padding: 0.75rem 1.5rem;
                font-weight: 500;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .btn-main:hover {
                background-color: #a40000;
                border-color: #a40000;
                color: white;
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(134, 0, 0, 0.3);
            }
            
            .btn-main:focus {
                background-color: #860000;
                border-color: #860000;
                color: white;
                box-shadow: 0 0 0 0.2rem rgba(134, 0, 0, 0.25);
            }
            
            .btn-fullwidth {
                width: 100%;
            }
            
            /* Liens avec couleur principale */
            a {
                color: #860000;
                transition: color 0.3s ease;
            }
            
            a:hover {
                color: #a40000;
                text-decoration: underline;
            }
            
            .text-muted {
                color: #6c757d !important;
            }
            
            .text-muted:hover {
                color: #860000 !important;
            }
        </style>
        <style>
    /* Wrapper champ mot de passe avec bouton toggle */
    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-wrapper .form-control {
        padding-right: 45px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 5px;
        z-index: 5; /* réduit pour ne pas écraser l'erreur */
        transition: color 0.3s ease;
    }

    .password-toggle-btn:hover,
    .password-toggle-btn:focus {
        color: #860000;
        outline: none;
    }

    /* Conteneur pour forcer les messages à être sous l'input */
    .field-set {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem; /* espace entre les champs */
    }

    /* Styles de validation */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block !important;
        position: relative !important; /* ne pas superposer */
        margin-top: 0.4rem;
        margin-left: 0.25rem;
        padding: 0.5rem;
        color: #dc3545;
        font-size: 0.875em;
        background-color: rgba(220, 53, 69, 0.1);
        border-radius: 0.25rem;
        border-left: 3px solid #dc3545;
    }
</style>

    </div>
</body>
</html>