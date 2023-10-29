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

						<li class="nav-item dropdown dropdown-large">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown"><span class="alert-count">7</span>
								<i class='bx bx-bell'></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a href="javascript:;">
									<div class="msg-header">
										<p class="msg-header-title">Notifications</p>
										<p class="msg-header-badge">8 New</p>
									</div>
								</a>
								<div class="header-notifications-list">
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="user-online">
												<img src="{{ asset('/backend-template/assets/images/avatars/avatar-1.png') }}" class="msg-avatar" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Daisy Anderson<span class="msg-time float-end">5 sec
											ago</span></h6>
												<p class="msg-info">The standard chunk of lorem</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="notify bg-light-danger text-danger">dc
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
											ago</span></h6>
												<p class="msg-info">You have recived new orders</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="user-online">
												<img src="{{ asset('/backend-template/assets/images/avatars/avatar-2.png') }}" class="msg-avatar" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
											sec ago</span></h6>
												<p class="msg-info">Many desktop publishing packages</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="notify bg-light-success text-success">
												<img src="{{ asset('/backend-template/assets/images/app/outlook.png') }}" width="25" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Account Created<span class="msg-time float-end">28 min
											ago</span></h6>
												<p class="msg-info">Successfully created new email</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="notify bg-light-info text-info">Ss
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">New Product Approved <span
											class="msg-time float-end">2 hrs ago</span></h6>
												<p class="msg-info">Your new product has approved</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="user-online">
												<img src="{{ asset('/backend-template/assets/images/avatars/avatar-4.png') }}" class="msg-avatar" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
											min ago</span></h6>
												<p class="msg-info">Making this the first true generator</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="notify bg-light-success text-success"><i class='bx bx-check-square'></i>
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
											ago</span></h6>
												<p class="msg-info">Successfully shipped your item</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="notify bg-light-primary">
												<img src="{{ asset('/backend-template/assets/images/app/github.png') }}" width="25" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
											ago</span></h6>
												<p class="msg-info">24 new authors joined last week</p>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center">
											<div class="user-online">
												<img src="{{ asset('/backend-template/assets/images/avatars/avatar-8.png') }}" class="msg-avatar" alt="user avatar">
											</div>
											<div class="flex-grow-1">
												<h6 class="msg-name">Peter Costanzo <span class="msg-time float-end">6 hrs
											ago</span></h6>
												<p class="msg-info">It was popularised in the 1960s</p>
											</div>
										</div>
									</a>
								</div>
								<a href="javascript:;">
									<div class="text-center msg-footer">
										<button class="btn btn-primary w-100">View All Notifications</button>
									</div>
								</a>
							</div>
						</li>

						<li class="nav-item dropdown dropdown-large">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
								<i class='bx bx-shopping-bag'></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a href="javascript:;">
									<div class="msg-header">
										<p class="msg-header-title">My Cart</p>
										<p class="msg-header-badge">10 Items</p>
									</div>
								</a>
								<div class="header-message-list">
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/11.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/02.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/03.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/04.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/05.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/06.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/07.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/08.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
									<a class="dropdown-item" href="javascript:;">
										<div class="d-flex align-items-center gap-3">
											<div class="position-relative">
												<div class="cart-product rounded-circle bg-light">
													<img src="{{ asset('/backend-template/assets/images/products/09.png') }}" class="" alt="product image">
												</div>
											</div>
											<div class="flex-grow-1">
												<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
												<p class="cart-product-price mb-0">1 X $29.00</p>
											</div>
											<div class="">
												<p class="cart-price mb-0">$250</p>
											</div>
											<div class="cart-product-cancel"><i class="bx bx-x"></i>
											</div>
										</div>
									</a>
								</div>
								<a href="javascript:;">
									<div class="text-center msg-footer">
										<div class="d-flex align-items-center justify-content-between mb-3">
											<h5 class="mb-0">Total</h5>
											<h5 class="mb-0 ms-auto">$489.00</h5>
										</div>
										<button class="btn btn-primary w-100">Checkout</button>
									</div>
								</a>
							</div>
						</li>
					</ul>
				</div>
				
				<div class="user-box dropdown px-3">
					<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="{{ asset('/backend-template/assets/images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar">
						<div class="user-info">
							<p class="user-name mb-0">{{ Auth::user()->name }}</p>
							<p class="designattion mb-0">{{ Auth::user()->email }}</p>
						</div>
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}"><i class="bx bx-home-circle fs-5"></i><span>Dashboard</span></a>
						</li>
						<li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
						</li>
						<li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="bx bx-cog fs-5"></i><span>Settings</span></a>
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