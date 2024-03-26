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


                <table>
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
                    <tbody id="dataTable">
                        <tr class="data-row">
                        
                            <td><input type="number" name="pregnancies[0][pregnancy]" class="form-control pregnancy" /></td>
                            <td><input type="date" name="pregnancies[0][pregnancy_date]"
                                    class="form-control pregnancy_date" /></td>
                            <td><input type="text" name="pregnancies[0][aog]" class="form-control aog" /></td>
                            <td><input type="text" name="pregnancies[0][manner]" class="form-control manner" />
                            </td>
                            <td><input type="text" name="pregnancies[0][bw]" class="form-control bw" /></td>
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
    </div>
    </div>
    </div>
    <!-- Form grid End -->
    </div>

    <script>
var pregnancyIndex = 0;

$("#addBtn").on("click", function() {
    pregnancyIndex++;
    console.log("Current pregnancyIndex:", pregnancyIndex);
    var newRow = '<tr>' +
        '<td><input type="number" name="pregnancies[' + pregnancyIndex + '][pregnancy]" class="form-control pregnancy" /></td>' +
        '<td><input type="date" name="pregnancies[' + pregnancyIndex + '][pregnancy_date]" class="form-control pregnancy_date" /></td>' +
        '<td><input type="text" name="pregnancies[' + pregnancyIndex + '][aog]" class="form-control aog" /></td>' +
        '<td><input type="text" name="pregnancies[' + pregnancyIndex + '][manner]" class="form-control manner" /></td>' +
        '<td><input type="text" name="pregnancies[' + pregnancyIndex + '][bw]" class="form-control bw" /></td>' +
        '<td><select class="form-control sex" name="pregnancies[' + pregnancyIndex + '][sex]"><option value="male">Male</option><option value="female">Female</option></select></td>' +
        '<td><input type="text" name="pregnancies[' + pregnancyIndex + '][present_status]" class="form-control present_status" /></td>' +
        '<td><input type="text" name="pregnancies[' + pregnancyIndex + '][complications]" class="form-control complications" /></td>' +
        '<td><a href="javascript:void(0)" class="text-danger font-16 remove" title="Remove"> <i class="fa fa-trash-o"></i></a></td>' +
        '</tr>';
    $("#dataTable").append(newRow); // Append the new row to the table
});
            // Remove row function
            $("#dataTable").on("click", ".remove", function() {
                $(this).closest("tr").remove();
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
