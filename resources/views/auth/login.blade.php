<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Movex | Admin Panel</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Portfolio Admin Login" name="description" />
    <meta content="Admin" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{URL::to('resources/admin_ui/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{URL::to('resources/admin_ui/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{URL::to('resources/admin_ui/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <style type="text/css">
        body,
        html {
            height: 90%;
            margin: 0;
        }

        .login {
            /* background-color: #a3b3ca !important; */
            background-image: url('/resources/admin_ui/assets/img/galaxy.jpg');
            height: 90%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /* background-position: center;  */
        }
    </style>
</head>

<body class="login">
    <div class="menu-toggler sidebar-toggler"></div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGO -->
    <div class="logo">
        @if(Session::has('username'))
        {{Session::get('username')}}
        @endif
    </div>
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="{{ route('login') }}" method="post">
            @csrf
            <h3 class="form-title" style="color:#1f75b0">Sign In</h3>
            @if(Session::has('error'))
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span> {{ Session::get('error') }}</span>
            </div>
            @endif

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control form-control-solid placeholder-no-fix" placeholder="Email" id="email" type="email" name="email" required />
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" id="password" placeholder="Password" name="password" required />
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-block blue uppercase">{{ __('Login') }}</button>
            </div>
        </form>
        <!-- END LOGIN FORM -->
    </div>
    <script src="{{URL::to('resources/admin_ui/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::to('resources/admin_ui/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::to('resources/admin_ui/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::to('resources/admin_ui/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::to('resources/admin_ui/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
</body>

</html>