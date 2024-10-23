@extends ('layouts.sidebar')
@section('title', 'Create Patient Account')
@section('contents')

    <script src="{{ asset('src/scripts/jquery.min.js') }}"></script>
    <div class="main-container">

        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Patient's Information</h4>
                        <p class="mb-30">(Type N/A if None)</p>
                    </div>

                </div>

                <form method="POST" action="{{ route('patient.storeAccount') }}" id="myForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" id="firstname" name="firstname" class="form-control"
                                    required="true" />
                                <div id="firstname-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" id="middlename" name="middlename" class="form-control" />
                                <div id="middlename-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" id="lastname" name="lastname" class="form-control" required="true" />
                                <div id="lastname-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Maiden Name (If Married)</label>
                                <input type="text" id="maiden" name="maiden" class="form-control" />
                                <div id="maiden-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div> <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Maiden Name (If Married)</label>
                                <input type="text" id="maiden" name="maiden" class="form-control" />
                                <div id="maiden-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div> <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Maiden Name (If Married)</label>
                                <input type="text" id="maiden" name="maiden" class="form-control" />
                                <div id="maiden-error" class="text-danger mt-1"></div> <!-- Error message div -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" required="true" />

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" name="password" class="form-control" />
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input type="text" id="birthplace" name="birthplace" class="form-control"
                                    required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label style="font-weight:100">Birthday</label>
                            <input type="date" id="birthday" name="birthday" class="form-control" required="true"
                                onchange="calculateAge()">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="company-column" style="font-weight:100">Age</label>
                                <input type="text" id="age" class="form-control" name="age" placeholder="Age"
                                    required="true" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Civil Status</label>
                                <select name="civil" class="form-control" required>

                                    <option value="married" selected>Married</option>
                                    <option value="single">Single</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number" class="form-control"
                                    pattern="^09[0-9]{9}$" title="Enter a valid mobile number starting with 09." required
                                    maxlength="11" oninput="validateContactNumber(event)" />
                                <span id="error-message-2" style="color: red; display: none;"></span>
                                <!-- Error message placeholder -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Religion</label>
                                <input type="text" name="religion" class="form-control" required="true" />
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Occupation</label>
                                <input type="text" name="occupation" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Nationality</label>
                                <input type="text" name="nationality" value="Filipino" class="form-control"
                                    required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Province</label>
                                <input type="text" name="province" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">City</label>
                                <input type="text" name="city" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Barangay</label>
                                <input type="text" name="barangay" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight:100">Spouse</label>
                                <select class="form-control" name="spouse" id="spouseDropdown" required="true">
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
                                    <label style="font-weight:100">Husband's First Name</label>
                                    <input type="text" id="husband_firstname" name="husband_firstname"
                                        class="form-control" />
                                    <div id="husband_firstname-error" class="text-danger mt-1"></div>
                                    <!-- Error message div -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:100">Husband's Middle Name</label>
                                    <input type="text" id="husband_middlename" name="husband_middlename"
                                        class="form-control" />
                                    <div id="husband_middlename-error" class="text-danger mt-1"></div>
                                    <!-- Error message div -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:100">Husband's Last Name</label>
                                    <input type="text" id="husband_lastname" name="husband_lastname"
                                        class="form-control" />
                                    <div id="husband_lastname-error" class="text-danger mt-1"></div>
                                    <!-- Error message div -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:100">Occupation</label>
                                    <input type="text" name="husband_occupation" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <label style="font-weight:100">Birthday</label>
                                <input type="date" id="husband_birthday" name="husband_birthday" class="form-control"
                                    onchange="calculateHusbandAge()">
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="company-column" style="font-weight:100">Age</label>
                                    <input type="text" id="husband_age" class="form-control" name="husband_age"
                                        placeholder="Age" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:100">Contact Number</label>
                                    <input type="text" id="husband_contact_number" name="husband_contact_number"
                                        class="form-control" pattern="^09[0-9]{9}$"
                                        title="Enter a valid mobile number starting with 09." maxlength="11"
                                        oninput="validateContactNumber(event)" />
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

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-block">Submit</span>
                        </button>&nbsp
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Form grid End -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var password = document.getElementById('password');
            var passwordConfirmation = document.getElementById('password_confirmation');
            var passwordMatchStatus = document.getElementById('password-match-status');

            function checkPasswordMatch() {
                if (password.value === passwordConfirmation.value) {
                    passwordConfirmation.classList.add('input-valid');
                    passwordConfirmation.classList.remove('input-invalid');
                    passwordMatchStatus.textContent = 'Passwords match';
                    passwordMatchStatus.style.color = 'green';
                } else {
                    passwordConfirmation.classList.add('input-invalid');
                    passwordConfirmation.classList.remove('input-valid');
                    passwordMatchStatus.textContent = 'Passwords do not match';
                    passwordMatchStatus.style.color = 'red';
                }
            }

            password.addEventListener('input', checkPasswordMatch);
            passwordConfirmation.addEventListener('input', checkPasswordMatch);
        });

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
            const errorField = document.getElementById(`${event.target.id}-error`);

            if (input === "") {
                // If input is empty, do not show an error (skip validation)
                errorField.textContent = '';
                event.target.classList.remove('is-invalid');
            } else if (!regex.test(input)) {
                // If input is not empty and doesn't match regex, show error
                errorField.textContent = "Only letters are allowed.";
                event.target.classList.add('is-invalid');
            } else {
                // Input is valid, clear the error message
                errorField.textContent = '';
                event.target.classList.remove('is-invalid');
            }
        }

        // Add event listeners for real-time validation
        document.getElementById('firstname').addEventListener('input', validateNameInput);
        document.getElementById('middlename').addEventListener('input', validateNameInput);
        document.getElementById('lastname').addEventListener('input', validateNameInput);
        document.getElementById('maiden').addEventListener('input', validateNameInput);
        document.getElementById('husband_firstname').addEventListener('input', validateNameInput);
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
    </script>
@endsection
