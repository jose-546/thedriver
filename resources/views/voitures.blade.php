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
    <!-- color scheme -->
    <link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="images/background/14.jpg" class="jarallax-img" alt="">
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1>My Profile</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-settings" class="bg-gray-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 mb30">
                            <div class="card p-4 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="images/profile/1.jpg" alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            {{ auth()->user()->username }}                                                  
                                            <span class="profile_username text-gray">{{ auth()->user()->email }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li>
                                        <a href="{{ route('dashboard') }}" 
                                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <i class="fa fa-home"></i> Tableau de bord
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('profile.edit') }}" 
                                        class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i> Mon Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reservations.index') }}" 
                                        class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                                        <i class="fa fa-calendar"></i> Mes Réservations
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('cars.search') }}" 
                                        class="{{ request()->routeIs('cars.search') ? 'active' : '' }}">
                                        <i class="fa fa-car"></i> Voitures Disponibles
                                        </a>
                                    </li>

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-sign-out"></i> Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="card p-4  rounded-5">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form id="form-create-item" class="form-border" method="post" action="email.php">
                                        <div class="de_tab tab_simple">
                                        
                                            <ul class="de_nav">
                                                <li class="active"><span>Informations personnelles</span></li>
                                                <li><span>Modifier Mot de passe</span></li>
                                                <li><span>Gérer mon Compte</span></li>
                                            </ul>
                                            
                                            <div class="de_tab_content">                            
                                                <div class="tab-1">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb20">
                                                            <h5>Username</h5>
                                                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" />
                                                        </div>
                                                        <div class="col-lg-6 mb20">
                                                            <h5>Email Address</h5>
                                                            <input type="text" name="email_address" id="email_address" class="form-control" placeholder="Enter email" />
                                                        </div>
                                                        <div class="col-lg-6 mb20">
                                                            <h5>New Password</h5>
                                                            <input type="Password" name="user_password" id="user_password" class="form-control" placeholder="********" />
                                                        </div>
                                                        <div class="col-lg-6 mb20">
                                                            <h5>Re-enter Password</h5>
                                                            <input type="Password" name="user_password_re-enter" id="user_password_re-enter" class="form-control" placeholder="********" />
                                                        </div>
                                                        <div class="col-md-6 mb20">
                                                            <h5>Language</h5>
                                                            <p class="p-info">Select your prefered language.</p>
                                                            <div id="select_lang" class="dropdown fullwidth">
                                                                <a href="#" class="btn-selector">English</a>
                                                                <ul>
                                                                    <li class="active"><span>English</span></li>
                                                                    <li><span>France</span></li>
                                                                    <li><span>German</span></li>
                                                                    <li><span>Japan</span></li>
                                                                    <li><span>Italy</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb20">
                                                            <h5>Hour Format</h5>
                                                            <p class="p-info">Select your prefered language.</p>
                                                            <div id="select_hour_format" class="dropdown fullwidth">
                                                                <a href="#" class="btn-selector">24-hour</a>
                                                                <ul>
                                                                    <li class="active"><span>24-hour</span></li>
                                                                    <li><span>12-hour</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>                               
                                                    </div>
                                                </div>

                                                <div class="tab-2">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-sm-20">
                                                            <div class="switch-with-title s2">
                                                                <h5>Discount Notifications</h5>
                                                                <div class="de-switch">
                                                                  <input type="checkbox" id="notif-item-sold" class="checkbox">
                                                                  <label for="notif-item-sold"></label>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <p class="p-info">You'll get notification while new discount available.</p>
                                                            </div>

                                                            <div class="spacer-20"></div>

                                                            <div class="switch-with-title s2">
                                                                <h5>New Product Notification</h5>
                                                                <div class="de-switch">
                                                                  <input type="checkbox" id="notif-bid-activity" class="checkbox">
                                                                  <label for="notif-bid-activity"></label>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <p class="p-info">You'll get notification while new product available.</p>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="switch-with-title s2">
                                                                <h5>Daily Reports</h5>
                                                                <div class="de-switch">
                                                                  <input type="checkbox" id="notif-auction-expiration" class="checkbox">
                                                                  <label for="notif-auction-expiration"></label>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <p class="p-info">We will send you a report everyday.</p>
                                                            </div>

                                                            <div class="spacer-20"></div>

                                                            <div class="switch-with-title s2">
                                                                <h5>Monthly Reports</h5>
                                                                <div class="de-switch">
                                                                  <input type="checkbox" id="notif-outbid" class="checkbox">
                                                                  <label for="notif-outbid"></label>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <p class="p-info">We will send you a report each month.</p>
                                                            </div>

                                                        </div>

                                                        <div class="spacer-20"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <input type="button" id="submit" class="btn-main" value="Update profile">
                                        </form>
                                    </div>
                                </div>
                            </div>
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


    <!-- Javascript Files
    ================================================== -->
    <script src="js/plugins.js"></script>
    <script src="js/designesia.js"></script>

</body>

</html>