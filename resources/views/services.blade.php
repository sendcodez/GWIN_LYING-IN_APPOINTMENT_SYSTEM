<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Lying In</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href=" {{ asset('img/gwinlogo2.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href=" {{ asset('img/gwinlogo2.png') }}" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href=" {{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href=" {{ asset('css/style.css') }}" rel="stylesheet">
</head>
<style>
    .logo-image {
        width: 180px;
        /* Adjust the size as needed */
        height: 100px;
        /* Adjust the size as needed */
        /* Makes the image round */
        object-fit: cover;
        /* Ensures the image covers the entire container */
    }
</style>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid py-2 border-bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-decoration-none text-body pe-3" href=""><i
                                class="bi bi-telephone me-2"></i>{{ $website->contact_no }}</a>
                        <span class="text-body">|</span>
                        <a class="text-decoration-none text-body px-3" href=""><i
                                class="bi bi-envelope me-2"></i>{{ $website->email }}</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="{{ route('index') }}" class="navbar-brand">

                    <h1 class="m-0 text-uppercase text-primary">
                        @if ($website->logo)
                            <img src="{{ asset('website_images/' . $website->logo) }}" alt="Website Logo"
                                class="logo-image">
                        @else
                            <img src="{{ asset('img/gwinlogo.png') }}" alt="Default Logo" class="logo-image">
                        @endif

                        {{ $website->business_name }}
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('index') }}" class="nav-item nav-link">Home</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                        <a href="javascript:void(0);" class="nav-item nav-link active">Service</a>
                        <a href="{{ route('pricing') }}" class="nav-item nav-link">Pricing</a>
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Services</h5>
                <h1 class="display-4">Excellent Medical Services</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-user-md text-white"></i>
                        </div>
                        <h4 class="mb-3">Obstetrician Gynecologist</h4>
                        <p class="m-0">An experienced Obstetrician Gynecologist dedicated to providing comprehensive
                            care. Specializes in women's health, including pregnancy, childbirth, and reproductive
                            system disorders, ensuring personalized and compassionate treatment.</p>

                        <a class="btn btn-lg btn-primary rounded-pill" href="">

                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-procedures text-white"></i>
                        </div>
                        <h4 class="mb-3">Normal Delivery</h4>
                        <p class="m-0">Providing safe and supportive care for expectant mothers during natural
                            childbirth, ensuring a healthy delivery experience for both mother and baby.</p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-stethoscope text-white"></i>
                        </div>
                        <h4 class="mb-3">Prenatal Checkup</h4>
                        <p class="m-0">Comprehensive prenatal care to monitor the health of both mother and baby
                            throughout pregnancy, ensuring early detection and management of any complications.</p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa fa-heartbeat text-white"></i>
                        </div>
                        <h4 class="mb-3">New Born</h4>
                        <p class="m-0">Specialized care and support for newborns to ensure healthy development
                            during the crucial early days of life.</p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-pills text-white"></i>
                        </div>
                        <h4 class="mb-3">Immunization & Vaccine</h4>
                        <p class="m-0">Offering a complete range of immunizations and vaccines to protect children
                            and adults from various preventable diseases.</p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa fa-medkit text-white"></i>
                        </div>
                        <h4 class="mb-3">Papsmear</h4>
                        <p class="m-0">Routine Papsmear tests to screen for cervical cancer and ensure early
                            detection and treatment of potential issues.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <div class="container-fluid bg-dark text-light border-top border-secondary py-4">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4 text-center text-md-start">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>{{ $website->address }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>{{ $website->email }}</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary me-3"></i>{{ $website->contact_no }}</p>
                </div>
            </div>

        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
