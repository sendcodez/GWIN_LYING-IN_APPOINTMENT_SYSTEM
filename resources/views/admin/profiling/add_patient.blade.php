@extends ('layouts.sidebar')
@section('title', 'Add Patient')
@section('contents')
    <!-- SweetAlert CSS -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableForm, #printableForm * {
                visibility: visible;
            }
            #printableForm {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
        }
        #printHeader {
            display: none;
        }
        </style>

    <script src="{{ asset('src/scripts/jquery.min.js') }}"></script>
    <div class="main-container">

        <a href="{{ route('patient.index') }}" class="btn btn-danger btn-sm scroll-click"><i class="fa fa-arrow-left"
                aria-hidden="true"></i> BACK</a>
        <div class="text-right">
            <button type="button" class="btn btn-secondary" onclick="printForm()">Print</button>
        </div>

        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Patient's Information</h4>
                        <p class="mb-30">(Type N/A if None)</p>
                    </div>

                </div>
                <form method="POST" action="{{ route('patient.medicalprofile') }} " enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-3 col-sm-12">
                        <video id="scanner" width="100%" height="auto"></video>
                        <div class="form-group">
                            <label>ID Search / QR Code Scan</label>
                            <div class="input-group">
                                <input type="text" id="user_id" name="user_id" class="form-control"
                                    placeholder="Enter user ID" />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                <div id="printableForm">
                        <div id="printHeader">
                            <h1>Patient's Information</h1>
                            <p>(Write N/A if None)</p>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">First Name</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control"
                                        required="true" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">Middle Name</label>
                                    <input type="text" id="middlename" name="middlename" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control" required="true" />
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                          
                    </div>

                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Pregnancy History</h4>
                                <p class="mb-30">(Type N/A if None)</p>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">Gravida</label>
                                    <input type="text" name="gravida" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">Para</label>
                                    <input type="text" name="para" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label>T</label>
                                    <input type="text" name="t"class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">P</label>
                                    <input type="text" name="p"class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">A</label>
                                    <input type="text" name="a"class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label style="font-weight:700">L</label>
                                    <input type="text" name="l"class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div data-row-counter="0">
                            <table id="dataTable">
                                <thead>
                                    <tr>

                                        <th data-type="number">No. of Pregnancy</th>
                                        <th data-type="date">Date</th>
                                        <th>AOG</th>
                                        <th>Manner of Delivery</th>
                                        <th>BW</th>
                                        <th data-type="select">Sex</th>
                                        <th>Present Status</th>
                                        <th>Complications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="first_row">

                                        <td><input type="number" name="pregnancies[0][pregnancy]"
                                                class="form-control pregnancy" /></td>
                                        <td><input type="date" name="pregnancies[0][pregnancy_date]"
                                                class="form-control pregnancy_date" /></td>
                                        <td><input type="text" name="pregnancies[0][aog]" class="form-control aog" />
                                        </td>
                                        <td><input type="text" name="pregnancies[0][manner]"
                                                class="form-control manner" />
                                        </td>
                                        <td><input type="text" name="pregnancies[0][bw]" class="form-control bw" />
                                        </td>
                                        <td>
                                            <select class="form-control sex" name="pregnancies[0][sex]">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="pregnancies[0][present_status]"
                                                class="form-control present_status" /></td>
                                        <td><input type="text" name="pregnancies[0][complications]"
                                                class="form-control complications" />
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-success font-18" title="Add"
                                                id="addBtn"><i class="fa fa-plus"></i></a></td>
                                    </tr>
                        </div>
                        </tbody>
                        </table>
                    </div>
      
           <br>
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Medical History</h4>
                        <p class="mb-30"></p>
                    </div>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="hypertension"
                                    name="hypertension" value="hypertension" />
                                <label class="custom-control-label" for="hypertension">Hypertension</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="heartdisease"
                                    name="heartdisease" value="heartdisease" />
                                <label class="custom-control-label" for="heartdisease">Heart Disease</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="asthma" name="asthma"
                                    value="asthma" />
                                <label class="custom-control-label" for="asthma">Asthma</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="tuberculosis"
                                    name="tuberculosis" value="tuberculosis" />
                                <label class="custom-control-label" for="tuberculosis">Tuberculosis</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="diabetes" name="diabetes"
                                    value="diabetes" />
                                <label class="custom-control-label" for="diabetes">Diabetes</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="goiter" name="goiter"
                                    value="goiter" />
                                <label class="custom-control-label" for="goiter">Goiter</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="epilepsy" name="epilepsy"
                                    value="epilepsy" />
                                <label class="custom-control-label" for="epilepsy">Epilepsy</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="allergy" name="allergy"
                                    value="allergy" />
                                <label class="custom-control-label" for="allergy">Allergy</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="hepatitis" name="hepatitis"
                                    value="hepatitis" />
                                <label class="custom-control-label" for="hepatitis">Hepatitis</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="vdrl" name="vdrl"
                                    value="vdrl" />
                                <label class="custom-control-label" for="vdrl">VDRL/RPR</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="bleeding" name="bleeding"
                                    value="bleeding" />
                                <label class="custom-control-label" for="bleeding">Bleeding</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="operation" name="operation"
                                    value="operation" />
                                <label class="custom-control-label" for="operation">Operation</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="othersCheckbox"
                                    name="othersCheckbox">
                                <label class="custom-control-label" for="othersCheckbox">Others</label>
                            </div>
                            <div id="othersInput" style="display: none;">
                                <input type="text" class="form-control" id="othersTextInput" name="others"
                                    placeholder="Please specify">
                            </div>
                        </div>


                        <div class="col-md-2 col-sm-12">
                            <label class="weight-600">Tetanus Toxoid</label>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="tt1" class="col-form-label">TT1</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="tt2" name="tt1" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="tt2" class="col-form-label">TT2</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="tt2" name="tt2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="tt3" class="col-form-label">TT3</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="tt3" name="tt3" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="tt4" class="col-form-label">TT4</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="tt4" name="tt4" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="tt5" class="col-form-label">TT5</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="tt5" name="tt5" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



            <!-- ACTION BUTTON -->

          
        </div>
       
    </div>
    <div class="col-12 d-flex justify-content-end">

        <button type="reset" class="btn btn-danger">Reset</button>&nbsp
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Submit</span>
        </button>
    </div>
    </form>
    </div>
    </div>
    </div>
    <!-- Form grid End -->
    </div>


    <script>
        $(document).ready(function() {
            // Function to perform ID search
            $('#searchButton').on('click', function() {
                var userId = $('#user_id').val();
                if (userId) {
                    $.ajax({
                        url: '/get-user-details/' + userId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#firstname').val(data.firstname);
                            $('#middlename').val(data.middlename);
                            $('#lastname').val(data.lastname);
                          
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            // Handle error
                            console.log(errorThrown);
                        }
                    });
                }
            });

            $(document).ready(function() {
                // Initialize the scanner
                let scanner = new Instascan.Scanner({
                    video: document.getElementById('scanner')
                });

                // Add listener for scan event
                scanner.addListener('scan', function(content) {
                    // Display the scanned content in the user_id input field
                    $('#user_id').val(content);

                    // Call a function to fetch user details based on the scanned ID
                    getUserDetails(content);
                });

                // Get available cameras and start the scanner
                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]); // Use the first available camera
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });

                // Function to fetch user details based on the scanned ID
                function getUserDetails(userId) {
                    // Perform AJAX request to fetch user details using the scanned ID
                    $.ajax({
                        url: '/get-user-details/' + userId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // Populate the input fields with user details if found
                            $('#firstname').val(data.firstname);
                            $('#middlename').val(data.middlename);
                            $('#lastname').val(data.lastname);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            // Handle error if user details retrieval fails
                            console.log(errorThrown);
                            // Show SweetAlert for invalid QR code
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid QR Code',
                                text: 'The scanned QR code is invalid.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
                }
            });



        });



        //APPEND ROWS
        $("#addBtn").on("click", function() {
            var pregnancyIndex = parseInt($("[data-row-counter]").attr('data-row-counter'));
            pregnancyIndex++;
            $("[data-row-counter]").attr('data-row-counter', pregnancyIndex);
            console.log("Current pregnancyIndex:", pregnancyIndex);

            var newRow = '<tr>' +
                '<td><input type="number" name="pregnancies[' + pregnancyIndex +
                '][pregnancy]" class="form-control pregnancy" /></td>' +
                '<td><input type="date" name="pregnancies[' + pregnancyIndex +
                '][pregnancy_date]" class="form-control pregnancy_date" /></td>' +
                '<td><input type="text" name="pregnancies[' + pregnancyIndex +
                '][aog]" class="form-control aog" /></td>' +
                '<td><input type="text" name="pregnancies[' + pregnancyIndex +
                '][manner]" class="form-control manner" /></td>' +
                '<td><input type="text" name="pregnancies[' + pregnancyIndex +
                '][bw]" class="form-control bw" /></td>' +
                '<td><select class="form-control sex" name="pregnancies[' + pregnancyIndex +
                '][sex]"><option value="male">Male</option><option value="female">Female</option></select></td>' +
                '<td><input type="text" name="pregnancies[' + pregnancyIndex +
                '][present_status]" class="form-control present_status" /></td>' +
                '<td><input type="text" name="pregnancies[' + pregnancyIndex +
                '][complications]" class="form-control complications" /></td>' +
                '<td><a href="javascript:void(0)" class="text-danger font-16 remove" title="Remove"> <i class="fa fa-trash-o"></i></a></td>' +
                '</tr>';

            $("#dataTable tbody").append(newRow);
        });

        $("#dataTable").on("click", ".remove", function() {
            $(this).closest("tr").remove();
        });


        function clearRowData(row) {
            const inputs = row.querySelectorAll("input, select"); // Select all input and select elements within the row
            inputs.forEach(input => {
                // Clear the value of each input element
                if (input.type === "text" || input.type === "number" || input.tagName === "SELECT") {
                    input.value = "";
                } else if (input.type === "date") {
                    input.value = ""; // Set date inputs to an empty string or default date value
                }
            });
        }

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
        $(document).ready(function() {
            $('#othersCheckbox').change(function() {
                if (this.checked) {
                    $('#othersInput').show(); // Show the input field if the checkbox is checked
                } else {
                    $('#othersInput').hide(); // Hide the input field if the checkbox is unchecked
                }
            });
        });

        function printForm() {
    // Show the print header before printing
    document.getElementById('printHeader').style.display = 'block';
    window.print();
    // Hide the print header after printing
    document.getElementById('printHeader').style.display = 'none';
}
document.getElementById('spouseDropdown').addEventListener('change', function() {
        var spouseInfoDiv = document.getElementById('spouseInfo');
        if (this.value === 'with') {
            spouseInfoDiv.style.display = 'block';  // Show spouse form
        } else {
            spouseInfoDiv.style.display = 'none';   // Hide spouse form
        }
    });

    // Initialize the spouse form visibility based on the selected option
    window.onload = function() {
        var spouseDropdown = document.getElementById('spouseDropdown');
        var spouseInfoDiv = document.getElementById('spouseInfo');
        if (spouseDropdown.value === 'with') {
            spouseInfoDiv.style.display = 'block';  // Show spouse form
        } else {
            spouseInfoDiv.style.display = 'none';   // Hide spouse form
        }
    };          
    </script>
@endsection
