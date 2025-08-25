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
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
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
									<h1>{{ __('Inscription') }}</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->
            

            <section aria-label="section">
                <div class="container">
					<div class="row">
						<div class="col-md-8 offset-md-2">
							<h3>{{ __("Rejoignez WiDriveU dès aujourd’hui !") }}</h3>
                            <p>Créez votre compte en quelques secondes et profitez d’un accès rapide à notre flotte de véhicules, à la réservation en ligne et à des offres exclusives. Louez facilement, suivez vos réservations et vivez une expérience de mobilité sans stress.</p>
							<div class="spacer-10"></div>
							
							<!-- Formulaire Laravel Breeze intégré -->
							<form method="POST" action="{{ route('register') }}" name="contactForm" id='contact_form' class="form-border">
                                @csrf

                                <div class="row">

                                    <!-- Nom -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="name">{{ __('Nom') }}:</label>
                                            <input type='text' 
                                                   name='name' 
                                                   id='name' 
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                                   required 
                                                   autofocus 
                                                   autocomplete="name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="email">{{ __('Adresse Email') }}:</label>
                                            <input type='email' 
                                                   name='email' 
                                                   id='email' 
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}"
                                                   required 
                                                   autocomplete="username">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Username (Nouveau champ) -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="username">{{ __('Choisir un nom d\'utilisateur') }}:</label>
                                            <input type='text' 
                                                   name='username' 
                                                   id='username' 
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   value="{{ old('username') }}"
                                                   required 
                                                   autocomplete="username">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Téléphone (Nouveau champ) -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="phone">{{ __('Téléphone') }}:</label>
                                            <input type='tel' 
                                                   name='phone' 
                                                   id='phone' 
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}"
                                                   required 
                                                   autocomplete="tel">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Mot de passe -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="password">{{ __('Mot de passe') }}:</label>
                                            <input type='password' 
                                                   name='password' 
                                                   id='password' 
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   required 
                                                   autocomplete="new-password">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Confirmation mot de passe -->
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <label for="password_confirmation">{{ __('Confirmer le mot de passe') }}:</label>
                                            <input type='password' 
                                                   name='password_confirmation' 
                                                   id='password_confirmation' 
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   required 
                                                   autocomplete="new-password">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <a class="text-decoration-none text-muted" href="{{ route('login') }}">
                                                {{ __('Déjà inscrit ?') }}
                                            </a>
                                            
                                            <div id='submit'>
                                                <input type='submit' 
                                                       id='send_message' 
                                                       value='{{ __("S'inscrire maintenant") }}' 
                                                       class="btn-main color-2">
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </form>
							
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

    <!-- CSS personnalisé pour les erreurs Bootstrap -->
    <style>
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>

</body>

</html>