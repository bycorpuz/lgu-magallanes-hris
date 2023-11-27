<div>
    <!--start header -->
	<header>
		<div class="topbar d-flex align-items-center">
			<nav class="navbar navbar-expand gap-3">
				<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
				</div>

				<div class="position-relative search-bar d-lg-block d-none" >
					<div class="user-info">
						<p class="user-name mb-0">System Date & Time:</p>
						<div class="designattion mb-0" x-data="{ ct: '', dtr_time: '' }">
							<div x-text="ct" x-init="displayC"></div>
							{{-- <div x-text="dtr_time" x-init="displayDtrTimer"></div> --}}
						</div>
					</div>
				</div>

				<div class="top-menu ms-auto">
					<ul class="navbar-nav align-items-center gap-1">
						<li class="nav-item dark-mode d-none d-sm-flex">
							@php
								$themeStyle = getUserThemeSettings()->theme_style;
								$isDarkTheme = $themeStyle === 'dark-theme';
								$iconClass = !$isDarkTheme ? 'bx-moon' : 'bx-sun';
							@endphp

							<a class="nav-link dark-mode-icon" href="javascript:;" wire:click='themeStyles("{{ $themeStyle }}")'>
								<i class="bx {{ $iconClass }}"></i>
							</a>
						</li>

						@can('view-leave-dashboard')
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown"><span class="alert-count" wire:poll.30s='fetchDataQuickCount'>{{ number_format($pendingLeave->count(), 0) }}</span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Pending Leaves</p>
											<p class="msg-header-badge" wire:poll.30s='fetchDataQuickCount'>{{ number_format($pendingLeave->count(), 0) }} New</p>
										</div>
									</a>
									<div class="header-notifications-list">
										@if ($pendingLeave->count() > 0)
											@foreach ($pendingLeave as $row)
												<a class="dropdown-item" href="javascript:;">
													<div class="d-flex align-items-center">
														<div class="user-offline">
															<img src="{{ asset('/images/users/'.getUsers($row->user_id)['upi_picture']) }}" class="msg-avatar" alt="user avatar">
														</div>
														<div class="flex-grow-1">
															<h6 class="msg-name">
																{{ getUsers($row->user_id)['upi_firstname'] . ' ' . getUsers($row->user_id)['upi_lastname'] }}
																<span class="msg-time float-end">{{ $row->days }} {{ $row->days > 1 ? 'days' : 'day' }}</span>
															</h6>
															<p class="msg-info">
																{{ getLeaveTypes($row->leave_type_id)['name'] }}
																<span class="msg-time float-end">{{ $row->date_from }} - {{ $row->date_to }}</span>
															</p>
														</div>
													</div>
												</a>
											@endforeach
										@endif
									</div>
									<a href="{{ route('leaves') }}">
										<div class="text-center msg-footer">
											<button class="btn btn-primary w-100">View All Pending Leaves</button>
										</div>
									</a>
								</div>
							</li>
						@endcan
					</ul>
				</div>
				
				<div class="user-box dropdown px-3">
					<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="{{ asset('/images/users/'.getUsers(Auth::user()->id)['upi_picture']) }}" class="user-img" alt="user avatar">
						<div class="user-info">
							<p class="user-name mb-0">{{ getUsers(Auth::user()->id)['upi_firstname'] }} {{ getUsers(Auth::user()->id)['upi_lastname'] }}</p>
							<p class="designattion mb-0">{{ Auth::user()->email }}</p>
						</div>
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item d-flex align-items-center" href="{{ route('my-profile') }}"><i class="bx bx-user fs-5"></i><span>My Profile</span></a>
						</li>
						<li><a class="dropdown-item d-flex align-items-center" href="{{ route('my-leave') }}"><i class="bx bx-cog fs-5"></i><span>My Leave</span></a>
						</li>
						<li>
							<div class="dropdown-divider mb-0"></div>
						</li>
						<li><a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}" wire:click='logoutHandler'><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</header>
    <!--end header -->
</div>

@push('scripts')
    <script type="text/javascript">
        function displayC() {
            const refresh = 1000;
    
            const updateDisplayC = () => {
                const x = new Date();
                this.ct = x;
                setTimeout(updateDisplayC, refresh);
            };
    
            updateDisplayC();
        }
    
        function displayDtrTimer() {
            const refresh = 1000;
    
            const updateDisplayDtrTime = () => {
                const x = new Date();
                const ampm = x.getHours() >= 12 ? ' PM' : ' AM';
                let hours = x.getHours() % 12;
                    hours = hours ? hours : 12;
                    hours = hours.toString().length == 1 ? '0' + hours.toString() : hours;
                let minutes = x.getMinutes().toString();
                    minutes = minutes.length == 1 ? '0' + minutes : minutes;
                let seconds = x.getSeconds().toString();
                    seconds = seconds.length == 1 ? '0' + seconds : seconds;
                const x1 = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
                this.dtr_time = x1;
    
                setTimeout(updateDisplayDtrTime, refresh);
            };
    
            updateDisplayDtrTime();
        }
    </script>
@endpush