<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--favicon-->
        <link rel="icon" href="{{ asset('/images/site/'. getSiteSettings()->site_favicon) }}" type="image/png" />
        <!--plugins-->
		<link href="{{ asset('/backend-template/assets/plugins/notifications/css/lobibox.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('/backend-template/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
        <link href="{{ asset('/backend-template/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
        <link href="{{ asset('/backend-template/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
        <!-- loader-->
        <link href="{{ asset('/backend-template/assets/css/pace.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('/backend-template/assets/js/pace.min.js') }}"></script>
        <!-- Bootstrap CSS -->
        <link href="{{ asset('/backend-template/assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/backend-template/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('/backend-template/assets/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/backend-template/assets/css/icons.css') }}" rel="stylesheet">

        <title>{{ $title ?? 'Page Title' }}</title>
        
        @stack('stylesheets')
        @livewireStyles
    </head>

    <body class="">
        <!--wrapper-->
        <div class="wrapper">
            <div class="section-authentication-cover">
                <div class="">
                    <div class="row g-0">
                        <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                            <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                                <div class="card-body">
                                    @php
                                        $leftImage = asset('/backend-template/assets/images/login-images');

                                        switch (Route::currentRouteName()) {
                                            case 'login':
                                                $leftImage .= '/login-cover.svg';
                                                break;

                                            case 'register':
                                                $leftImage .= '/register-cover.svg';
                                                break;

                                            default:
                                                $leftImage .= '/login-cover.svg';
                                                break;
                                        }
                                    @endphp

                                    <img src="{{ $leftImage }}" class="img-fluid auth-img-cover-login" width="650" alt=""/>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                            <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <!--end wrapper-->
        <!-- Bootstrap JS -->
        <script src="{{ asset('/backend-template/assets/js/bootstrap.bundle.min.js') }}"></script>
        <!--plugins-->
        <script src="{{ asset('/backend-template/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/backend-template/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('/backend-template/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('/backend-template/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
		<!--notification js -->
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/notifications.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
        <!--Password show & hide js -->
        <script>
            $(document).ready(function () {
                $("#show_hide_password a").on('click', function (event) {
                    event.preventDefault();
                    if ($('#show_hide_password input').attr("type") == "text") {
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass("bx-hide");
                        $('#show_hide_password i').removeClass("bx-show");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass("bx-hide");
                        $('#show_hide_password i').addClass("bx-show");
                    }
                });
            });
        </script>
        <!--app JS-->
        {{-- <script src="{{ asset('/backend-template/assets/js/app.js') }}"></script> --}}
        <script>
            if ( navigator.userAgent.indexOf("Firefox") != -1){
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', function(){
                    history.pushState(null, null, document.URL);
                });
            }
        </script>

		<script src="{{ asset('/system-scripts/global/global.js?v='.filemtime('system-scripts/global/global.js')) }}"></script>
        
        @stack('scripts')
        @livewireScripts
    </body>
</html>