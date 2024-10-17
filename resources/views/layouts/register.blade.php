<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="32x32" href=" {{ asset('img/gwinlogo2.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href=" {{ asset('img/gwinlogo2.png') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href=" {{ asset('css/style.css') }}" rel="stylesheet">
    <title>Register</title>
</head>
<style>
    .logo-image {
        width: 150px;
        /* Adjust the size as needed */
        height: 80px;
        /* Adjust the size as needed */
        border-radius: 50%;
        /* Makes the image round */
        object-fit: cover;
        /* Ensures the image covers the entire container */
    }
</style>

<body class="my-login-page">
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
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="index.html" class="navbar-brand">
                    <h1 class="m-0 text-uppercase text-primary"><img src="{{ asset('img/gwinlogo.png') }}"
                            alt="GWIN Lying-in Logo" class="logo-image">GWIN Lying-In</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('index') }}" class="nav-item nav-link ">Home</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                        <a href="{{ route('services') }}" class="nav-item nav-link">Service</a>
                        <a href="{{ route('pricing') }}" class="nav-item nav-link">Pricing</a>
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <body class="my-login-page">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <section class="h-100">
                <div class="container h-100">
                    <div class="row justify-content-md-center h-100">
                        <div class="row">
                            <div class="card fat">
                                <div class="row">
                                    <h4 class="card-title">Personal Information</h4>
                                    <form method="POST" class="my-login-validation" novalidate="">

                                        <div class="form-group col-md-4">
                                            @yield('firstname')
                                        </div>
                                        <div class="form-group col-md-4">
                                            @yield('middlename')
                                        </div>
                                        <div class="form-group col-md-4">
                                            @yield('lastname')
                                        </div>


                                        <div class="form-group col-md-4">
                                            @yield('email')
                                        </div>
                                        <div class="form-group col-md-4">
                                            @yield('password')
                                        </div>
                                        <div class="form-group col-md-4">
                                            @yield('confirm_password')
                                        </div>

                                    </form>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Maiden Name (If Married)</label>
                                            <input type="text" name="maiden" pattern="[A-Za-z\s]+"
                                                title="Only letters are allowed." class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Place of Birth</label>
                                            <input type="text" name="birthplace" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label style="font-weight:100">Birthday</label>
                                        <input type="date" id="birthday" name="birthday" class="form-control"
                                            required="true" onchange="calculateAge()">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="company-column" style="font-weight:100">Age</label>
                                            <input type="text" id="age" class="form-control" name="age"
                                                placeholder="Age" required="true" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Civil Status</label>
                                            <select class="form-control" name="civil" required="true">
                                                <option value="single">Single</option>
                                                <option value="married" selected>Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" id="contact_number" name="contact_number"
                                                class="form-control" pattern="^09[0-9]{9}$"
                                                title="Enter a valid mobile number starting with 09." required
                                                maxlength="11" oninput="validateContactNumber(event)" />
                                            <span id="error-message-2" style="color: red; display: none;"></span>
                                            <!-- Error message placeholder -->
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Religion</label>
                                            <input type="text" name="religion" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Occupation</label>
                                            <input type="text" name="occupation" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Nationality</label>
                                            <input type="text" name="nationality" value="Filipino"
                                                class="form-control" required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Province</label>
                                            <input type="text" name="province" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">City</label>
                                            <input type="text" name="city" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Barangay</label>
                                            <input type="text" name="barangay" class="form-control"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-weight:100">Spouse</label>
                                            <select class="form-control" name="spouse" id="spouseDropdown"
                                                required="true">
                                                <option value="with" selected>With Spouse</option>
                                                <option value="without" selected>Without Spouse</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- HUSBAND INFO -->
                                <div id="spouseInfo">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4">Spouse Information</h4>
                                            <p class="mb-30">(Type N/A if None)</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">First Name</label>
                                                <input type="text" name="husband_firstname" pattern="[A-Za-z\s]+"
                                                    title="Only letters are allowed." class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Middle Name</label>
                                                <input type="text" pattern="[A-Za-z\s]+"
                                                    title="Only letters are allowed." name="husband_middlename"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Last Name</label>
                                                <input type="text" pattern="[A-Za-z\s]+"
                                                    title="Only letters are allowed." name="husband_lastname"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Occupation</label>
                                                <input type="text" name="husband_occupation"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label style="font-weight:100">Birthday</label>
                                            <input type="date" id="husband_birthday" name="husband_birthday"
                                                class="form-control" onchange="calculateHusbandAge()">
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="company-column" style="font-weight:100">Age</label>
                                                <input type="text" id="husband_age" class="form-control"
                                                    name="husband_age" placeholder="Age" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Contact Number</label>
                                                <input type="text" id="husband_contact_number"
                                                    name="husband_contact_number" class="form-control"
                                                    pattern="^09[0-9]{9}$"
                                                    title="Enter a valid mobile number starting with 09." required
                                                    maxlength="11" oninput="validateContactNumber(event)" />
                                                <span id="error-message" style="color: red; display: none;"></span>
                                                <!-- Error message placeholder -->
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group" style="font-weight:100">
                                                <label>Religion</label>
                                                <input type="text" name="husband_religion" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Province</label>
                                                <input type="text" name="husband_province" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">City</label>
                                                <input type="text" name="husband_city" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-weight:100">Barangay</label>
                                                <input type="text" name="husband_barangay" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-0" style="font-size: 1.2rem">
                                    @yield('terms')
                                </div>

                                <div class="form-group m-0">
                                    @yield('register')
                                </div>

                                <div class="mt-4 text-center">
                                    Already have an account? <a href="{{ route('login') }}">Login</a>
                                </div>
                            </div>
                            <div class="footer">
                                Copyright &copy; 2024 &mdash; Lying In
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
            </script>
            <script src="js/my-login.js"></script>

            <script>
                document.getElementById('spouseDropdown').addEventListener('change', function() {
                    var spouseInfoDiv = document.getElementById('spouseInfo');
                    if (this.value === 'with') {
                        spouseInfoDiv.style.display = 'block'; // Show spouse form
                    } else {
                        spouseInfoDiv.style.display = 'none'; // Hide spouse form
                    }
                });

                // Initialize the spouse form visibility based on the selected option
                window.onload = function() {
                    var spouseDropdown = document.getElementById('spouseDropdown');
                    var spouseInfoDiv = document.getElementById('spouseInfo');
                    if (spouseDropdown.value === 'with') {
                        spouseInfoDiv.style.display = 'block'; // Show spouse form
                    } else {
                        spouseInfoDiv.style.display = 'none'; // Hide spouse form
                    }
                };

                function validateNameInput(event) {
                    const regex = /^[A-Za-z\s]+$/; // Regular expression for letters and spaces only
                    const input = event.target.value;

                    if (!regex.test(input)) {
                        alert("Only letters are allowed.");
                        event.target.value = ''; // Optionally clear the input field
                    }
                }

                document.getElementById('firstname').addEventListener('input', validateNameInput);
                document.getElementById('middlename').addEventListener('input', validateNameInput);
                document.getElementById('lastname').addEventListener('input', validateNameInput);
                document.getElementById('maiden').addEventListener('input', validateNameInput);
                document.getElementById('husband_firstame').addEventListener('input', validateNameInput);
                document.getElementById('husband_middlename').addEventListener('input', validateNameInput);
                document.getElementById('husband_lastname').addEventListener('input', validateNameInput);


                function validateContactNumber(event) {
                    const input = event.target.value;
                    const errorMessage = event.target.nextElementSibling; // Get the next sibling span for the error message

                    // Check if the input is exactly 11 digits long and starts with 09
                    const regex = /^09[0-9]{9}$/; // Pattern for exactly 11 digits

                    if (input.length > 11) {
                        // Trim input if length exceeds 11
                        event.target.value = input.slice(0, 11);
                        errorMessage.style.display = 'none'; // Clear error message
                    } else if (input.length < 11) {
                        // If the input is less than 11 digits, show an error message
                        errorMessage.textContent = "The contact number must be exactly 11 digits.";
                        errorMessage.style.display = 'block'; // Show error message
                    } else if (!regex.test(input)) {
                        // If the input is not valid, show an error message
                        errorMessage.textContent = "Enter a valid mobile number starting with 09.";
                        errorMessage.style.display = 'block'; // Show error message
                    } else {
                        // Hide the error message if the input is valid
                        errorMessage.style.display = 'none';
                    }
                }

                // Attach the event listener to both input fields
                document.getElementById('husband_contact_number').addEventListener('input', validateContactNumber);
                document.getElementById('contact_number').addEventListener('input', validateContactNumber);




                function calculateAge() {
                    var birthday = new Date(document.getElementById("birthday").value);
                    var today = new Date();
                    var age = today.getFullYear() - birthday.getFullYear();
                    var m = today.getMonth() - birthday.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
                        age--;
                    }
                    document.getElementById("age").value = age;
                }

                function calculateHusbandAge() {
                    var birthday = new Date(document.getElementById("husband_birthday").value);
                    var today = new Date();
                    var age = today.getFullYear() - birthday.getFullYear();
                    var m = today.getMonth() - birthday.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
                        age--;
                    }
                    document.getElementById("husband_age").value = age;
                }
            </script>
    </body>

</html>
