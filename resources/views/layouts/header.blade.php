<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Admin panel</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<link rel="apple-touch-icon" href="{{ asset('admin/images/logo/favicon.png') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/logo/favicon.png') }}">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
<!-- BEGIN custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/extensions/unslider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/weather-icons/climacons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/fonts/meteocons/style.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/charts/morris.css') }}">
<!-- END VENDOR CSS-->

<link href="{{ asset('admin/plugins/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />


<!-- BEGIN STACK CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/app.min.css') }}">
<!-- END STACK CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/menu/menu-types/vertical-menu.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/colors/palette-gradient.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/plugins/forms/validation/form-validation.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('admin/fonts/simple-line-icons/style.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/core/colors/palette-gradient.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/pages/timeline.min.css') }}">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
<!-- END Custom CSS-->

<!-- Data tables-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/forms/selects/select2.min.css') }}">

<!-- Krajee File input css-->
<!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"
          crossorigin="anonymous"> -->
<link rel="stylesheet" href="{{asset('admin/plugins/file_input/css/fileinput.css')}}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="{{asset('admin/plugins/file_input/themes/explorer-fas/theme.css')}}" media="all" rel="stylesheet" type="text/css" />
<!--End of Krajee File input-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">

<link rel="stylesheet" type="text/css" href="{{ asset('admin/custom/custom.css') }}">