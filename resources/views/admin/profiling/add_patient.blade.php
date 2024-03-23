@extends ('layouts.sidebar')
@section('contents')
    <script src="{{ asset('src/scripts/jquery.min.js') }}"></script>
    <div class="main-container">

        <a href="#form-grid-form" class="btn btn-danger btn-sm scroll-click" rel="content-y" data-toggle="collapse"
            role="button"><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a>

        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Patient's Information</h4>
                        <p class="mb-30">(Type N/A if None)</p>
                    </div>

                </div>
                <form method="POST" action="{{ route('patient.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" name="firstname" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Middle name</label>
                                <input type="text" name="middlename" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="lastname" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Maiden Name (If Married)</label>
                                <input type="text" name="maiden" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input type="text" name="birthplace" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label>Birthday</label>
                            <input type="date" id="birthday" name="birthday" value="" class="form-control"
                                required="true" onchange="calculateAge()">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="company-column">Age</label>
                                <input type="text" id="age" class="form-control" name="age" placeholder="Age"
                                    required="true" readonly>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Civil Status</label>
                                <select class="custom-select2 form-control" name="civil" required="true">
                                    <option value="single">Single</option>
                                    <option value="married" selected>Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="religion" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Occupation</label>
                                <input type="text" name="occupation" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Nationality</label>
                                <input type="text" name="nationality" value="Filipino" class="form-control"
                                    required="true" />
                            </div>
                        </div>
                    </div>

                    <!-- HUSBAND INFO -->

                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Husband/Partner's Information</h4>
                            <p class="mb-30">(Type N/A if None)</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="husband_firstname" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="husband_middlename" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="husband_lastname" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Occupation</label>
                                <input type="text" name="husband_occupation" class="form-control" required="true" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label>Birthday</label>
                            <input type="date" id="husband_birthday" name="husband_birthday" value=""
                                class="form-control" required="true" onchange="calculateHusbandAge()">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="company-column">Age</label>
                                <input type="text" id="husband_age" class="form-control" name="husband_age"
                                    placeholder="Age" required="true" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" name="husband_contact_number" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="husband_religion" class="form-control" required="true" />
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Province</label>
                                <input type="text" name="province" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" class="form-control" required="true" />
                            </div>
                        </div>
                    </div>
            </div>

        </div>


    </div>

    </div>
    </div>
    </div>
    <!-- PATIENT PERSONAL INFORMATION END -->
    </div>

    <!-- PREGNANCY HISTORY -->

    <div class="main-container">

        <div class="pd-ltr-20 xs-pd-20-10">

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
                            <label>Gravida</label>
                            <input type="text" name="gravida" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Para</label>
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
                            <label>P</label>
                            <input type="text" name="p"class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>A</label>
                            <input type="text" name="a"class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>L</label>
                            <input type="text" name="l"class="form-control" />
                        </div>
                    </div>
                </div>

                <button class="btn btn-success" data-color="#ffffff" id="addColumnBtn"><i class="fa fa-plus"
                        aria-hidden="true"></i></button>
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
                        <tr>
                            <td><input type="number" name="pregnancy[]" class="form-control" /></td>
                            <td><input type="date" name="pregnancy_date[]" class="form-control" /></td>
                            <td><input type="text" name="aog[]" class="form-control" /></td>
                            <td><input type="text" name="manner[]" class="form-control" /></td>
                            <td><input type="text" name="bw[]" class="form-control" /></td>
                            <td>
                                <select class="form-control" name="sex[]">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </td>
                            <td><input type="text" name="present_status[]" class="form-control" /></td>
                            <td><input type="text" name="complications[]" class="form-control" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>




                                <div class="main-container">

                                    <div class="pd-ltr-20 xs-pd-20-10">

                                        <div class="pd-20 card-box mb-30">
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

    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Submit</span>
        </button>&nbsp
        <button type="reset" class="btn btn-danger">Reset</button>
    </div>
    </div>


    </div>

    </form>
    </code></pre>
    </div>
    </div>
    </div>
    <!-- Form grid End -->
    </div>

    <script>
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
            var index = $('#dataTable tbody tr').length; // Initialize index variable

            $('#addColumnBtn').click(function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                var newRow = $('<tr></tr>'); // Create a new table row
                var columns = $('#dataTable thead th')
                .length; // Get the number of columns from table header

                // Loop through the number of columns and append input fields to the new row
                for (var i = 0; i < columns; i++) {
                    var inputType = $('#dataTable thead th').eq(i).data(
                    'type'); // Get the data-type attribute of the header cell
                    var inputField;

                    if (inputType === 'select') {
                        // Create a select element with options
                        inputField = '<select class="form-control" name="sex[' + index + '][sex]">';
                        inputField += '<option value="male">Male</option>';
                        inputField += '<option value="female">Female</option>';
                        inputField += '</select>';
                    } else {
                        // Create input field with the specified type
                        inputField = '<input type="' + inputType + '" name="sex[' + index + '][' + i +
                            ']" class="form-control" />';
                    }

                    // Append input field or select element to the new row
                    newRow.append('<td>' + inputField + '</td>');
                }

                // Append "x" button to the new row
                newRow.append(
                    '<td><button class="btn btn-danger removeRowBtn" data-color="#ffffff"><i class="fa fa-times" aria-hidden="true"></i></button></td>'
                    );

                $('#dataTable tbody').append(newRow); // Append the new row to the table body

                index++; // Increment index for the next row
            });

            // Handle click events on dynamically added "x" buttons
            $('#dataTable').on('click', '.removeRowBtn', function(event) {
                event.preventDefault(); // Prevent the default action
                $(this).closest('tr').remove(); // Remove the entire row containing the clicked "x" button
            });
        });


        $(document).ready(function() {
            $('#othersCheckbox').change(function() {
                if (this.checked) {
                    $('#othersInput').show(); // Show the input field if the checkbox is checked
                } else {
                    $('#othersInput').hide(); // Hide the input field if the checkbox is unchecked
                }
            });
        });
    </script>
@endsection
