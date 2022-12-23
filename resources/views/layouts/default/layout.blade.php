<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        <?php 
            if($title_for_layout){
                echo $title_for_layout;
            }else{
                echo 'Fayaz Sons Builders';
            }
        ?>
    </title>

    <?php
        if (isset($description_for_layout)) {
            echo "<meta name='description' content='" . $description_for_layout . "' />";
        }
    ?>
    <?php
        if (isset($keywords_for_layout)) {
            echo "<meta name='keywords' content='" . $keywords_for_layout . "' />";
        }
    ?>
    <?php if (isset($meta_title_content)) { ?>
            <meta property="og:title" content="<?php echo $meta_title_content; ?>"/>
    <?php } ?>
    <?php //$currentPath= Route::getFacadeRoot()->current()->uri(); ?>
    <meta property="og:url" content="{{$currentPath}}"/>
    
    <meta property="og:site_name" content="{{ config('app.name', 'Fayaz Sons') }}"/>
    <!-- Styles -->
    <link rel="stylesheet" media="screen" href="{{asset('css/bootstrap.css?v=1')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/fayazsons-business.css?v=1')}}" />
    <link rel="stylesheet" media="screen" href="{{asset('css/jquery-ui.css?v=1')}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    @yield('css')

    <script type="text/javascript" src="{{asset('js/jquery-1.10.2.min.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/common.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.bootstrap.min.js?v=1')}}"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = "{{url('/')}}"; 
    </script>
</head>
    <body>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        @include('layouts.default.topnav')
        @include('layouts.default.slider')
        @include('layouts.admin.flashmessage')
        @yield('content')
        <div class="footer-size">
            @include('layouts.default.footer')
        </div>
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