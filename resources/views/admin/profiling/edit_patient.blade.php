@extends ('layouts.sidebar')
@section('title', 'Edit Patient')
@section('contents')
    <script src="{{ asset('src/scripts/jquery.min.js') }}"></script>
    <div class="main-container">

        <a href="{{route('patient.index')}}" class="btn btn-danger btn-sm scroll-click" ><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a>

        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Patient's Information</h4>
                        <p class="mb-30">(Type N/A if None)</p>
                    </div>

                </div>
    
                <form action="{{ route('patient.update', ['userId' => $patient->user_id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" id="firstname" name="firstname" class="form-control" value="{{ $patient->firstname }}" required="true" />

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" id="middlename" name="middlename" value="{{ $patient->middlename }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" id="lastname" name="lastname"  value="{{ $patient->lastname }}" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Maiden Name (If Married)</label>
                                <input type="text" name="maiden"  value="{{ $patient->maiden }}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input type="text" name="birthplace" value="{{ $patient->birthplace }}" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label>Birthday</label>
                            <input type="date" id="birthday" name="birthday" value="{{ $patient->birthday}}" class="form-control"
                                required="true" onchange="calculateAge()">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="company-column">Age</label>
                                <input type="text" id="age" class="form-control" value="{{ $patient->age }}"name="age" placeholder="Age"
                                    required="true" readonly>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Civil Status</label>
                                <select class="custom-select2 form-control" value="{{ $patient->civil }}" name="civil" required="true">
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
                                <input type="text" name="contact_number" value="{{ $patient->contact_number }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="religion" value="{{ $patient->religion }}" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Occupation</label>
                                <input type="text" name="occupation" value="{{ $patient->occupation}}" class="form-control" required="true" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Nationality</label>
                                <input type="text" name="nationality" value="Filipino"  class="form-control"
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
                                <input type="text" id="firstname" name="husband_firstname" value="{{ $patient->husband_firstname }}" class="form-control" value="{{ $patient->firstname }}" />

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" name="husband_middlename" value="{{ $patient->husband_middlename }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="husband_lastname" class="form-control" value="{{ $patient->husband_lastname }}" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Occupation</label>
                                <input type="text" name="husband_occupation" class="form-control" value="{{ $patient->husband_occupation }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label>Birthday</label>
                            <input type="date" id="husband_birthday" name="husband_birthday" value="{{ $patient->husband_birthday }}"
                                class="form-control" onchange="calculateHusbandAge()">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="company-column">Age</label>
                                <input type="text" id="husband_age" class="form-control" name="husband_age" value="{{ $patient->husband_age}}"
                                    placeholder="Age" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" name="husband_contact_number" value="{{ $patient->husband_contact_number }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="husband_religion" value="{{ $patient->husband_religion }}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Province</label>
                                <input type="text" name="province" class="form-control" value="{{ $patient->province }}" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ $patient->city }}" required="true" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Barangay</label>
                                <input type="text" name="barangay" class="form-control" value="{{ $patient->barangay }}" required="true" />
                            </div>
                        </div>
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
                            <label>Gravida</label>
                            <input type="text" name="gravida" value="{{ $pregnancyterm->gravida}}" class="form-control" />

                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Para</label>
                            <input type="text" name="para" value="{{ $pregnancyterm->para }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>T</label>
                            <input type="text" name="t" value="{{ $pregnancyterm->t }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>P</label>
                            <input type="text" name="p" value="{{ $pregnancyterm->p }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>A</label>
                            <input type="text" name="a" value="{{ $pregnancyterm->a }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>L</label>
                            <input type="text" name="l" value="{{ $pregnancyterm->l }}" class="form-control" />
                        </div>
                    </div>
                </div>

                <div data-row-counter="0">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>No. of Pregnancy</th>
                                <th>Date</th>
                                <th>AOG</th>
                                <th>Manner of Delivery</th>
                                <th>BW</th>
                                <th>Sex</th>
                                <th>Present Status</th>
                                <th>Complications</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pregnancyHistories as $index => $pregnancyHistory)
                            <tr>
                                <td><input type="number" name="pregnancies[{{ $index }}][pregnancy]" class="form-control pregnancy" value="{{ $pregnancyHistory->pregnancy }}" /></td>
                                <td><input type="date" name="pregnancies[{{ $index }}][pregnancy_date]" class="form-control pregnancy_date" value="{{ $pregnancyHistory->pregnancy_date }}" /></td>
                                <td><input type="text" name="pregnancies[{{ $index }}][aog]" class="form-control aog" value="{{ $pregnancyHistory->aog }}" /></td>
                                <td><input type="text" name="pregnancies[{{ $index }}][manner]" class="form-control manner" value="{{ $pregnancyHistory->manner }}" /></td>
                                <td><input type="text" name="pregnancies[{{ $index }}][bw]" class="form-control bw" value="{{ $pregnancyHistory->bw }}" /></td>
                                <td>
                                    <select class="form-control sex" name="pregnancies[{{ $index }}][sex]">
                                        <option value="male" @if($pregnancyHistory->sex == 'male') selected @endif>Male</option>
                                        <option value="female" @if($pregnancyHistory->sex == 'female') selected @endif>Female</option>
                                    </select>
                                </td>
                                <td><input type="text" name="pregnancies[{{ $index }}][present_status]" class="form-control present_status" value="{{ $pregnancyHistory->present_status }}" /></td>
                                <td><input type="text" name="pregnancies[{{ $index }}][complications]" class="form-control complications" value="{{ $pregnancyHistory->complications }}" /></td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
        </div>
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
                                name="hypertension" value="hypertension" @if($medicalHistory && $medicalHistory->hypertension) checked @endif />
                            <label class="custom-control-label" for="hypertension">Hypertension</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="heartdisease"
                                name="heartdisease" value="heartdisease" @if($medicalHistory && $medicalHistory->heartdisease) checked @endif />
                            <label class="custom-control-label" for="heartdisease">Heart Disease</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="asthma" name="asthma"
                            value="asthma" @if($medicalHistory && $medicalHistory->asthma) checked @endif/>
                            <label class="custom-control-label" for="asthma">Asthma</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="tuberculosis"
                                name="tuberculosis" value="tuberculosis" @if($medicalHistory && $medicalHistory->tuberculosis) checked @endif/>
                            <label class="custom-control-label" for="tuberculosis">Tuberculosis</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="diabetes" name="diabetes"
                            value="diabetes" @if($medicalHistory && $medicalHistory->diabetes) checked @endif />
                            <label class="custom-control-label" for="diabetes">Diabetes</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="goiter" name="goiter"
                            value="goiter" @if($medicalHistory && $medicalHistory->goiter) checked @endif/>
                            <label class="custom-control-label" for="goiter">Goiter</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="epilepsy" name="epilepsy"
                            value="epilepsy" @if($medicalHistory && $medicalHistory->epilepsy) checked @endif />
                            <label class="custom-control-label" for="epilepsy">Epilepsy</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="allergy" name="allergy"
                            value="allergy" @if($medicalHistory && $medicalHistory->allergy) checked @endif />
                            <label class="custom-control-label" for="allergy">Allergy</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="hepatitis" name="hepatitis"
                            value="hepatitis" @if($medicalHistory && $medicalHistory->hepatitis) checked @endif />
                            <label class="custom-control-label" for="hepatitis">Hepatitis</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="vdrl" name="vdrl"
                            value="vdrl" @if($medicalHistory && $medicalHistory->vdrl) checked @endif/>
                            <label class="custom-control-label" for="vdrl">VDRL/RPR</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="bleeding" name="bleeding"
                            value="bleeding" @if($medicalHistory && $medicalHistory->bleeding) checked @endif/>
                            <label class="custom-control-label" for="bleeding">Bleeding</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-5">
                            <input type="checkbox" class="custom-control-input" id="operation" name="operation"
                            value="operation" @if($medicalHistory && $medicalHistory->operation) checked @endif/>
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
                                    <input type="text" id="tt2" value="{{ $medicalHistory->tt1 }}" name="tt1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="tt2" class="col-form-label">TT2</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="tt2" value="{{ $medicalHistory->tt2 }}" name="tt2" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="tt3" class="col-form-label">TT3</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="tt3" value="{{ $medicalHistory->tt3 }}" name="tt3" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="tt4" class="col-form-label">TT4</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="tt4" value="{{ $medicalHistory->tt4 }}" name="tt4" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="tt5" class="col-form-label">TT5</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="tt5" value="{{ $medicalHistory->tt5 }}" name="tt5" class="form-control">
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
                <span class="d-none d-sm-block">Update</span>
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
//APPEND ROWS
$("#addBtn").on("click", function() {
    var pregnancyIndex = parseInt($("[data-row-counter]").attr('data-row-counter'));
    pregnancyIndex++;
    $("[data-row-counter]").attr('data-row-counter', pregnancyIndex);
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
    </script>
@endsection

