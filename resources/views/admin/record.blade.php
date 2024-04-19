@extends('layouts.sidebar')
@section('title', 'Records')
@section('contents')
    <style>
        .Yes {
            color: red;
        }

        .No {
            color: blue;
        }
    </style>
    <script src="{{ asset('src/scripts/jquery.min.js') }}"></script>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <a href="{{ route('patient.index') }}" class="btn btn-danger btn-sm scroll-click"><i class="fa fa-arrow-left"
                        aria-hidden="true"></i> BACK</a>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-50-p">
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
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#personal"
                                                role="tab">Personal Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#appointment" role="tab">Recent
                                                Appointment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#pregnancy" role="tab">Pregnancy
                                                History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#medical" role="tab">Medical
                                                History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#laboratory"
                                                role="tab">Laboratory Result</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#ultrasound"
                                                role="tab">Ultrasound Result</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <!-- PERSONAL -->
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                            <div class="pd-20 profile-task-wrap">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="pd-20 card-box height-100-p">
                                                            <div class="profile-info">
                                                                <h5 class="mb-20 h5 text-green">Patient Informations</h5>
                                                                <ul>
                                                                    <li>
                                                                        <span>Full Name:</span>
                                                                        <span id="fullname" style="color: black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Phone Number:</span>
                                                                        <span id="contact_number" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Birthplace:</span>
                                                                        <span id="birthplace" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Birthday:</span>
                                                                        <span id="birthday" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Age:</span>
                                                                        <span id="age" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Civil Status:</span>
                                                                        <span id="civil" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Religion:</span>
                                                                        <span id="religion" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Occupation:</span>
                                                                        <span id="occupation" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Nationality:</span>
                                                                        <span id="nationality" style="color:black"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="pd-20 card-box height-100-p">
                                                            <div class="profile-info">
                                                                <h5 class="mb-20 h5 text-green">Husband Informations</h5>
                                                                <ul>
                                                                    <li>
                                                                        <span>Full Name:</span>
                                                                        <span id="husband_fullname" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Contact Number:</span>
                                                                        <span id="husband_contact_number" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Birthday:</span>
                                                                        <span id="husband_birthday" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Age:</span>
                                                                        <span id="husband_age" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Occupation:</span>
                                                                        <span id="husband_occupation" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Religion:</span>
                                                                        <span id="husband_religion" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Address:</span>
                                                                        <span id="address" style="color:black"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                    


                                          <!-- APPOINTMENT -->
                                          <div class="tab-pane fade " id="appointment" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th class="table-plus">Doctor</th>
                                                            <th>Service</th>
                                                            <th>Time</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="app_date"></td>
                                                            <td id="doctor"></td>
                                                            <td id="service"></td>
                                                            <td id="start_time"></td>
                                                            <td id="status"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- PREGNANCY -->
                                        <div class="tab-pane fade " id="pregnancy" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Gravida</th>
                                                            <th class="table-plus">Para</th>
                                                            <th>T</th>
                                                            <th style="text-align: center">P</th>
                                                            <th>A</th>
                                                            <th>L</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="gravida"></td>
                                                            <td id="para"></td>
                                                            <td id="t"></td>
                                                            <td id="p"></td>
                                                            <td id="a"></td>
                                                            <td id="l"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="table table-striped" id="pregnancy_histories">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="table-plus">Pregnancy number</th>
                                                            <th class="table-plus">Pregnancy Date</th>
                                                            <th>AOG</th>
                                                            <th>Manner</th>
                                                            <th>BW</th>
                                                            <th>Sex</th>
                                                            <th>Present Status</th>
                                                            <th>Complications</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="pregnancy_number"></td>
                                                            <td id="pregnancy_date"></td>
                                                            <td id="aog"></td>
                                                            <td id="manner"></td>
                                                            <td id="bw"></td>
                                                            <td id="sex"></td>
                                                            <td id="present_status"></td>
                                                            <td id="complications"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <!-- MEDICAL -->
                                        <div class="tab-pane fade " id="medical" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="text-center">Hypertension</th>
                                                            <th class="text-center">Heart Disease</th>
                                                            <th class="text-center">Asthma</th>
                                                            <th class="text-center">Tuberculosis</th>
                                                            <th class="text-center">Diabetes</th>
                                                            <th class="text-center">Goiter</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="hypertension" class="text-center"></td>
                                                            <td id="heartdisease" class="text-center"></td>
                                                            <td id="asthma" class="text-center"></td>
                                                            <td id="tuberculosis" class="text-center"></td>
                                                            <td id="diabetes" class="text-center"></td>
                                                            <td id="goiter" class="text-center"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="pd-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="text-center">Epilepsy</th>
                                                            <th class="text-center">Allergy</th>
                                                            <th class="text-center">Hepatitis</th>
                                                            <th class="text-center">VDRL</th>
                                                            <th class="text-center">Bleeding</th>
                                                            <th class="text-center">Operation</th>
                                                            <th class="text-center">Others</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="epilepsy" class="text-center"></td>
                                                            <td id="allergy" class="text-center"></td>
                                                            <td id="hepatitis" class="text-center"></td>
                                                            <td id="medical_vdrl" class="text-center"></td>
                                                            <td id="bleeding" class="text-center"></td>
                                                            <td id="operation" class="text-center"></td>
                                                            <td id="others" class="text-center"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <!-- LABORATORY -->
                                        <div class="tab-pane fade " id="laboratory" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped" id="laboratory">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th class="table-plus">Urinalysis</th>
                                                            <th style="text-align: center">CBC</th>
                                                            <th>Blood Type</th>
                                                            <th>HBSAG</th>
                                                            <th>VDRL</th>
                                                            <th>FBS</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="date"></td>
                                                            <td id="urinalysis"></td>
                                                            <td id="cbc"></td>
                                                            <td id="blood_type"></td>
                                                            <td id="hbsag"></td>
                                                            <td id="vdrl"></td>
                                                            <td id="fbs"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- ULTRASOUND -->

                                        <div class="tab-pane fade " id="ultrasound" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped" id="ultrasound">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th class="table-plus">Result</th>
                                                            <th style="text-align: center">Attachment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="ultra_date"></td>
                                                            <td id="result"></td>
                                                            <td class="text-center" id="attachment"> <img src="{{ asset('') }}" alt="ultrasound" style="max-width: 100px;" /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>


                                    <!-------->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/record.js') }}"></script>
    @endsection
