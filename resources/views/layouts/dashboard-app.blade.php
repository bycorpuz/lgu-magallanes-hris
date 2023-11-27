<!DOCTYPE html>
<html lang="en" class="{{ getUserThemeSettingsTrimmed() }}">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="{{ asset('/images/site/'. getSettings()->site_favicon) }}" type="image/png" />
		<!--plugins-->
		<link href="{{ asset('/backend-template/assets/plugins/notifications/css/lobibox.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('/backend-template/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
		<link href="{{ asset('/backend-template/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
		<link href="{{ asset('/backend-template/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('/backend-template/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
		<!-- loader-->
		<link href="{{ asset('/backend-template/assets/css/pace.min.css') }}" rel="stylesheet" />
		<script src="{{ asset('/backend-template/assets/js/pace.min.js') }}"></script>
		<!-- Bootstrap CSS -->
		<link href="{{ asset('/backend-template/assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/backend-template/assets/css/bootstrap-extended.css') }}" rel="stylesheet"> 
		{{-- Select2 CSS --}}
		<link href="{{ asset('/backend-template/assets/css/select2.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/backend-template/assets/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
		{{-- fonts and app CSS --}}
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
		<link href="{{ asset('/backend-template/assets/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('/backend-template/assets/css/icons.css') }}" rel="stylesheet">
		<!-- Theme Style CSS -->
		<link rel="stylesheet" href="{{ asset('/backend-template/assets/css/dark-theme.css') }}" />
		<link rel="stylesheet" href="{{ asset('/backend-template/assets/css/semi-dark.css') }}" />
		<link rel="stylesheet" href="{{ asset('/backend-template/assets/css/header-colors.css') }}" />
		
        <title>{{ $title ?? 'Page Title' }}</title>

		@stack('stylesheets')
		@livewireStyles
	</head>

	<body>
        <!--wrapper-->
        <div class="wrapper">
            <livewire:dashboard-page.sidebar-wrapper>

            <livewire:dashboard-page.header>
				
			<!--start page wrapper -->
			<div class="page-wrapper">
				<div class="page-content">
					{{ $slot }}
				</div>
			</div>
			<!--end page wrapper -->

            <livewire:dashboard-page.footer>
        </div>
        <!--end wrapper-->

		<!--start switcher-->
		<livewire:dashboard-page.switcher-wrapper>
		<!--end switcher-->

		<!-- Bootstrap JS -->
		<script src="{{ asset('/backend-template/assets/js/bootstrap.bundle.min.js') }}"></script>
		<!--plugins-->
		<script src="{{ asset('/backend-template/assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
		<!--notification js -->
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/notifications.min.js') }}"></script>
		<script src="{{ asset('/backend-template/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
		<!--Chart-->
		{{-- <script src="{{ asset('/backend-template/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script> --}}
        <!--index JS-->
		{{-- <script src="{{ asset('/backend-template/assets/js/index.js?v='.filemtime('backend-template/assets/js/index.js')) }}"></script> --}}

		{{-- Select2 js --}}
		<script src="{{ asset('/backend-template/assets/js/select2.min.js') }}"></script>

		<!--app JS-->
		<script src="{{ asset('/backend-template/assets/js/app.js?v='.filemtime('backend-template/assets/js/app.js')) }}"></script>
		
		{{-- global js --}}
		@can('view-leave-dashboard')
			<script src="{{ asset('/system-scripts/global/leave-dashboard.js?v='.filemtime('system-scripts/global/leave-dashboard.js')) }}"></script>
		@endcan
		<script src="{{ asset('/system-scripts/global/global.js?v='.filemtime('system-scripts/global/global.js')) }}"></script>
		{{-- <script src="{{ asset('/system-scripts/global/alpine-init.js?v='.filemtime('system-scripts/global/alpine-init.js')) }}"></script> --}}

		@stack('scripts')
		@livewireScripts
	</body>
</html>