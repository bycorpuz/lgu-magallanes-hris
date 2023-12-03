<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>{{ getSiteSettings()->site_name }}</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('/images/site/'. getSiteSettings()->site_favicon) }}" rel="icon">
        <link href="{{ asset('/images/site/'. getSiteSettings()->site_favicon) }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('/landing-page-template/assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('/landing-page-template/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/landing-page-template/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('/landing-page-template/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/landing-page-template/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/landing-page-template/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('/landing-page-template/assets/css/style.css') }}" rel="stylesheet">

        <!-- =======================================================
        * Template Name: BizLand
        * Updated: Sep 18 2023 with Bootstrap v5.3.2
        * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
        
		<link href="{{ asset('/backend-template/assets/plugins/notifications/css/lobibox.min.css') }}" rel="stylesheet" />

        @stack('stylesheets')
        @livewireStyles
    </head>

    <body>
        @yield('top-bar')

        @yield('header')

        @yield('hero')

        @yield('main')

        @yield('footer')

        <!-- Vendor JS Files -->
        <script src="{{ asset('/landing-page-template/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
        <script src="{{ asset('/landing-page-template/assets/vendor/php-email-form/validate.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('/landing-page-template/assets/js/main.js') }}"></script>
        <script src="{{ asset('/backend-template/assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
		<script src="{{ asset('/system-scripts/global/global.js?v='.filemtime('system-scripts/global/global.js')) }}"></script>

        @stack('scripts')
        @livewireScripts
    </body>
</html>