<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">

  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <title>Movex | Admin Panel</title>
  <link rel="apple-touch-icon" href="{{ asset('favicon/favicon-32x32.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/logo/stack-logo.png') }}">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <!-- yajra data table css start -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- end -->
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors.min.css') }}"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/forms/icheck/icheck.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/forms/icheck/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/charts/morris.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/extensions/unslider.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/weather-icons/climacons.min.css') }}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/app.css') }}">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/menu/menu-types/vertical-menu.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/colors/palette-climacon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/colors/palette-gradient.css') }}">
  <!-- <link rel="stylesheet" type="text/html" href="{{ asset('admin/fonts/simple-line-icons/style.min.css') }}/"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/fonts/meteocons/style.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/pages/users.css') }}">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
  <!-- END Custom CSS-->
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/js/gallery/photo-swipe/photoswipe.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/js/gallery/photo-swipe/default-skin/default-skin.css') }}"> -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" rel="stylesheet">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/custom/custom.css?v1') }}">
  @yield('header_extends')
</head>

<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
  <!-- navigation bar -->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark bg-gradient-x-grey-blue">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
            <a class="navbar-brand" href="{{route('home')}}">
              <img class="brand-logo" style="margin-left: 8px;" alt="stack admin logo" src="{{ asset('favicon/favicon-32x32.png') }}" height="40" width="40">
              <h3 class="brand-text">MoveX</h3>
            </a>
          </li>
          <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu text-white"></i></a></li>
          </ul>

          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item"><a style="color:white;" class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-divider"></div>

                <!-- <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a> -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          </ul>

          <ul class="nav navbar-nav float-right">
            <li class="">
              <!-- <a class=" nav-link dropdown-user-link" href="" data-toggle=""><span class="avatar avatar-online"><img src="{{ asset('admin/images/portrait/small/avatar-s-19.png') }}" alt="avatar"><i></i></span>
                <span class="user-name">Profile</span>
              </a> -->
              <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">
                  <i class="ft-user"></i> Reset Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="login-with-bg-image.html"></a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>
                 
              </div> -->
            </li>
          </ul>


          <!-- <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>
          <select class="nav navbar-nav float-right" style="background: #6e84ac;border: #6b80a7;color: white;">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
          </select> -->
        </div>
      </div>
  </nav>
  <!-- sidebar -->
  @include('layouts.side_bar')
  <!-- body section -->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-body">

        @yield('content')

      </div>
    </div>
  </div>
  <!-- Footer -->
  @include('layouts.footer')
  @yield('footer_extends')
</body>

</html>