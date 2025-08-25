<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Rentaly - Multipurpose Vehicle Car Rental Website Template</title>
    <link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Rentaly - Multipurpose Vehicle Car Rental Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="css/mdb.min.css" rel="stylesheet" type="text/css" id="mdb">
    <link href="css/plugins.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/coloring.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css">
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
            <section id="section-hero" aria-label="section" class="jarallax">
                <img src="images/background/2.jpg" class="jarallax-img" alt="">
                <div class="v-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-4 offset-lg-4">
                                <div class="padding40 rounded-3 shadow-soft" data-bgcolor="#ffffff">
                                    <h4>{{ __('Login') }}</h4>
                                    
                                    <!-- Session Status -->
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    
                                    <div class="spacer-10"></div>
                                    
                                    <!-- Formulaire Laravel Breeze intégré -->
                                    <form method="POST" action="{{ route('login') }}" id="form_login" class="form-border">
                                        @csrf
                                        
                                        <!-- Email Address -->
                                        <div class="field-set">
                                            <input type="email" 
                                                   name="email" 
                                                   id="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   placeholder="{{ __('Email Address') }}"
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
                                        
                                        <!-- Password -->
                                        <div class="field-set">
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="{{ __('Password') }}"
                                                   required 
                                                   autocomplete="current-password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Remember Me -->
                                        <div class="field-set">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="remember_me" 
                                                       name="remember">
                                                <label class="form-check-label" for="remember_me">
                                                    {{ __('Remember me') }}
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div id="submit">
                                            <input type="submit" 
                                                   id="send_message" 
                                                   value="{{ __('Sign In') }}" 
                                                   class="btn-main btn-fullwidth rounded-3" />
                                        </div>
                                        
                                        <!-- Liens additionnels -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            @if (Route::has('password.request'))
                                                <a class="text-decoration-none text-muted" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('register') }}" class="text-decoration-none">
                                                {{ __("Don't have an account?") }}
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
        <!-- content close -->
    
        <!-- Javascript Files
        ================================================== -->
        <script src="js/plugins.js"></script>
        <script src="js/designesia.js"></script>

        <!-- CSS personnalisé pour les erreurs Bootstrap -->
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
        </style>

    </body>
</html>