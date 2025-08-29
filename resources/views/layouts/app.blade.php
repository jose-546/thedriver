<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Profil')</title>

    <!-- CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap">
 <link href="css/mdb.min.css" rel="stylesheet" type="text/css" id="mdb"> 
 <link href="css/plugins.css" rel="stylesheet" type="text/css"> 
 <link href="css/style.css" rel="stylesheet" type="text/css"> 
 <link href="css/custom-1.css" rel="stylesheet" type="text/css"> 
 <link href="css/coloring.css" rel="stylesheet" type="text/css"> <!-- color scheme --> 
<link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css">
</head>
<body>

       <div id="wrapper">
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

  
        <div id="content">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    <!-- JS -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
</body>
</html>
