<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    

    <!-- Styles -->
    <link href="{{asset('img/favicon.144x144.png?v=1')}}" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="{{asset('img/favicon.114x114.png?v=1')}}" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="{{asset('img/favicon.72x72.png?v=1')}}" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="{{asset('img/favicon.57x57.png?v=1')}}" rel="apple-touch-icon" type="image/png">
    <link href="{{asset('img/favicon.png?v=1')}}" rel="icon" type="image/png">
    <link href="{{asset('img/favicon.ico?v=1')}}" rel="shortcut icon">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('css/lib/lobipanel/lobipanel.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/separate/vendor/lobipanel.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/lib/jqueryui/jquery-ui.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/separate/pages/widgets.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/lib/font-awesome/font-awesome.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/panel.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap/bootstrap.min.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/main.css?v=2')}}">
    <link rel="stylesheet" href="{{asset('css/lightbox.css')}}">


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css">

    @yield('css')

    <script type="text/javascript" src="{{asset('js/jquery-1.10.2.min.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/tether/tether.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/bootstrap/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/jqueryui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/lobipanel/lobipanel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://www.gstatic.com/charts/loader.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js"></script>
    <script type="text/javascript" src="{{asset('js/lightbox.min.js')}}"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = "{{url('/home')}}"; 
        $(document).ready(function() {           
        });
    </script>

    <script type="text/javascript" src="{{asset('js/common.js?v=1')}}"></script>
</head>
<body class="with-side-menu control-panel control-panel-compact">
     @include('layouts.admin.header')
     <div class="mobile-menu-left-overlay"></div>
     @include('layouts.admin.leftsidebar')
     <div class="page-content">
        <div class="container-fluid">
            @include('layouts.admin.flashmessage')
            @yield('content')         
        </div><!--.container-fluid-->
    </div><!--.container-fluid-->
    <?php /* @include('layouts.admin.rightsidebar') */ ?>
    
    @yield('scripts')
    <script type="text/javascript">
        
        hideModal = function(selector) {
            jQuery(selector).modal('hide');
        }
        jQuery("body").on("hidden.bs.modal", ".modal", function() {
            $(this).removeData("bs.modal");
        });
        jQuery(document).ajaxStart(function() {
            jQuery("#overlay").fadeIn();
        }).ajaxStop(function() {
            jQuery("#overlay").fadeOut();
        });
    </script>    
            
    </body>
</html>