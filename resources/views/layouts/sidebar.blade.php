<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('title', config('app.name'))</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href=" {{ asset('vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href=" {{ asset('img/gwinlogo2.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href=" {{ asset('img/gwinlogo2.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/fullcalendar/fullcalendar.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/toastr.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}" />
	


    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
</head>
<style>
    .logo-image {
    width: 280px; /* Adjust the size as needed */
    height: 280px; /* Adjust the size as needed */
    border-radius: 50%; /* Makes the image round */
    object-fit: cover; /* Ensures the image covers the entire container */
}
.gwin {
    width: 100px; /* Adjust the size as needed */
    height: 100px; /* Adjust the size as needed */
    border-radius: 50%; /* Makes the image round */
    object-fit: cover; /* Ensures the image covers the entire container */
}
</style>
<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset ('img/gwinlogo.png') }}" alt="GWIN Lying-in Logo" class="logo-image">
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>

            <div class="header-search">

            </div>
        </div>
        <div class="header-right">
            <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div>
    
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{ asset ('vendors/images/avatar.png') }}" alt="" />
                        </span>
                        <span class="user-name"> {{ Auth::user()->firstname }}  {{ Auth::user()->lastname }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="javascript:void(0);"><i class="dw dw-user1"></i> Profile</a>
                        <a class="dropdown-item" href="javascript:void(0);"><i class="dw dw-settings2"></i> Setting</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item" href="route('logout')"
                                onclick="event.preventDefault();
							this.closest('form').submit();">
                                {{ __('Log Out') }}

                                <i class="dw dw-logout"></i> </a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i
                                class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i
                                class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i
                                class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i
                                class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i
                                class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i
                                class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i
                                class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i
                                class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="#">
                <img src="{{ asset ('img/gwinlogo.png') }}" alt="GWIN Lying-in Logo" class="gwin"> <h1>GWIN</h1>
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
					@if (Auth::user()->usertype == '1' || Auth::user()->usertype == '0')
                    <li class="dropdown">
                        <a href="{{ route('admin.home') }}" class="dropdown-toggle no-arrow @isActiveRoute('admin.home')">
                            <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>
                    <!--
                    <li class="dropdown">
                        <a href="{{route('appointments.show')}}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Appointments</span>
                        </a>

                    </li>
                    -->
                    <li class="dropdown @isActiveRoute('appointments.*')">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-calendar4-week"></span><span class="mtext">Appointments</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('appointments.pending') }}" class="@isActiveRoute('appointments.pending')">
                                    Pending
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('appointments.approved') }}" class="@isActiveRoute('appointments.approved')">
                                    Approved
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('appointments.completed') }}" class="@isActiveRoute('appointments.completed')">
                                    Completed
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('appointments.cancelled') }}" class="@isActiveRoute('appointments.cancelled')">
                                    Cancelled
                                </a>
                            </li>
                        </ul>
                    </li>
                    

                    @if (Auth::user()->usertype == '1')
                    <li class="dropdown">
                        <a href="{{ route('admin.calendar') }}" class="dropdown-toggle no-arrow @isActiveRoute('admin.calendar')">
                            <span class="micon bi bi-person-walking"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="bi bi-person-walking" viewBox="0 0 16 16">
                                <path d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z"/>
                                <path d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z"/>
                              </svg></span><span class="mtext">Add Walk In Appointments</span>
                        </a>
                    </li>
                    @endif

                    <li class="dropdown">
                        <a href="{{ route ('doctor.create')}}" class="dropdown-toggle no-arrow @isActiveRoute('doctor.create')">
                            <span class="micon fa fa-stethoscope"></span><span class="mtext">Doctors</span>
                        </a>
                    </li>

                    <li class="dropdown @isActiveRoute('patient.*')">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi-people"></span><span class="mtext">Patients</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('create-patient-account')}}" class="@isActiveRoute('create-patient-account')">
                                    Add Patient Account
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('patient.add') }}" class="@isActiveRoute('patient.add')">
                                    Add Patient Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('patient.index') }}" class="@isActiveRoute('patient.index')">
                                    Manage Patients
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                 
                    <li class="dropdown">
                        <a href="{{ route('record.index') }}" class="dropdown-toggle no-arrow @isActiveRoute('record.index')">
                            <span class="micon bi bi-files"></span><span class="mtext">Records</span>
                        </a>
                    </li>
                    @if (Auth::user()->usertype == '0')
                    <li class="dropdown">
                        <a href="{{ route('report.index') }}" class="dropdown-toggle no-arrow @isActiveRoute('report.index')">
                            <span class="micon bi bi-file-earmark"></span><span class="mtext">Reports</span>
                        </a>
                    </li>
                    
                    <li class="dropdown">
                        <a href="{{route('service.index')}}" class="dropdown-toggle no-arrow @isActiveRoute('service.index')">
                            <span class="micon bi bi-file-check"></span><span class="mtext">Services</span>
                        </a>
                    </li>
                    @endif

               

                    <li>
                        <div class="sidebar-small-cap">Extra</div>
                    </li>
                    @if (Auth::user()->usertype == '0')
                    <li class="dropdown">
                        <a href="{{route('activity.show')}}" class="dropdown-toggle no-arrow @isActiveRoute('activity.show')">
                            <span class="micon bi bi-clock"></span><span class="mtext">Activity Log</span>
                        </a>
                    </li>
                   
                    <li class="dropdown">
                        <a href="{{route('user.create')}}" class="dropdown-toggle no-arrow @isActiveRoute('user.create')">
                            <span class="micon bi bi-people"></span><span class="mtext">User Setting</span>
                        </a>
                    </li>
                    @endif
                    <li class="dropdown">
                        <a href="{{route('website.index')}}" class="dropdown-toggle no-arrow @isActiveRoute('website.index')">
                            <span class="micon fa fa-globe"></span><span class="mtext">Website Setting</span>
                        </a>
                    </li>
					@endif

                   
					@if (Auth::user()->usertype == '2')

					<li class="dropdown">
						<a href="{{route('admin.dashboard')}}" class="dropdown-toggle no-arrow">
							<span class="micon bi bi-house"></span><span class="mtext">
								Home</span>
						</a>
					</li>
                    @endif
                   
                    @if ( Auth::user()->usertype == '3')
					<li class="dropdown">
						<a href="{{route('appointment.index')}}" class="dropdown-toggle no-arrow @isActiveRoute('appointment.index')">
							<span class="micon bi bi-calendar4-week"></span><span class="mtext">Book
								Appointments</span>
						</a>
					</li>
                    @endif

					@if (Auth::user()->usertype == '2')
					<li class="dropdown">
						<a href="{{route('mypatients.index')}}" class="dropdown-toggle no-arrow @isActiveRoute('mypatients.index')">
							<span class="micon bi bi-people"></span><span class="mtext">My Patients</span>
						</a>
					</li>
					@endif

					@if (Auth::user()->usertype == '3')
					<li class="dropdown">
						<a href="{{route('myrecord.index')}}" class="dropdown-toggle no-arrow @isActiveRoute('myrecord.index')">
							<span class="micon bi bi-files"></span><span class="mtext">My Records</span>
						</a>
					</li>
					@endif
                    <!--
                    @if (Auth::user()->usertype == '2')
					<li class="dropdown">
						<a href="" class="dropdown-toggle no-arrow">
							<span class="micon bi bi-files"></span><span class="mtext">Medical Records</span>
						</a>
					</li>
					@endif
                -->
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
    @yield ('contents')

    <!-- js -->
    <script src="{{ asset('vendors/scripts/toastr.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
	<script src="{{ asset('src/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('js/instascan.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src=" {{ asset('vendors/scripts/datatable-setting.js')}}"></script> 
    <script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/dashboard3.js') }}"></script>


    @if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error('{{ session('error') }}');
    </script>
@endif
<script>
   document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission behavior
        
        const form = this.closest('form'); // Find the closest form element
        
        // Display SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                form.submit();
            }
        });
    });
});

document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission behavior
        
        const form = this.closest('form'); // Find the closest form element
        
        // Display SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                form.submit();
            }
        });
    });
});

    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });
</script>

    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>
