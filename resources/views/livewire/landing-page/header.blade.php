<div>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="/">{{ getSettings()->site_name }}<span></span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#hero" class="logo"><img src="{{ asset('/landing-page-template/assets/img/logo.png') }}" alt=""></a>-->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>

                @guest
                    <li><a class="nav-link" href="/login">Login</a></li>
                @endguest
                
                @auth
                    <li><a class="nav-link" href="/dashboard">Dashboard</a></li>
                @endauth
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->
</div>
