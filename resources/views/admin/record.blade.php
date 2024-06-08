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
                                            <a class="nav-link" data-toggle="tab" href="#attachment" role="tab">
                                               Attachments</a>
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
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#medication"
                                                role="tab">Medications</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#delivery"
                                                role="tab">Delivery Record</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#newborn"
                                                role="tab">Newborn Record</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#postpartum"
                                                role="tab">Postpartum Monitoring</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#records"
                                                role="tab">PNCU Record</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#labor"
                                                role="tab">Labor Monitoring</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#staffnotes"
                                                role="tab">Staff Notes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#physician"
                                                role="tab">Physician's Order</a>
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
                                                                        <span style="font-weight:700">Full Name:</span>
                                                                        <span id="fullname" style="color: black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Phone Number:</span>
                                                                        <span id="contact_number" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Birthplace:</span>
                                                                        <span id="birthplace" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Birthday:</span>
                                                                        <span id="birthday" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Age:</span>
                                                                        <span id="age" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Civil Status:</span>
                                                                        <span id="civil" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Religion:</span>
                                                                        <span id="religion" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Occupation:</span>
                                                                        <span id="occupation" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Nationality:</span>
                                                                        <span id="nationality" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Address:</span>
                                                                        <span id="address" style="color:black"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="pd-20 card-box height-100-p">
                                                            <div class="profile-info">
                                                                <h5 class="mb-20 h5 text-green">Spouse Informations</h5>
                                                                <ul>
                                                                    <li>
                                                                        <span style="font-weight:700">Full Name:</span>
                                                                        <span id="husband_fullname" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Contact Number:</span>
                                                                        <span id="husband_contact_number" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Birthday:</span>
                                                                        <span id="husband_birthday" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Age:</span>
                                                                        <span id="husband_age" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Occupation:</span>
                                                                        <span id="husband_occupation" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Religion:</span>
                                                                        <span id="husband_religion" style="color:black"></span>
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight:700">Address:</span>
                                                                        <span id="husband_address" style="color:black"></span>
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
                                                <table class="table table-striped table-bordered">
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
                                                <table class="table table-striped table-bordered">
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
                                                <table class="table table-striped table-bordered" id="pregnancy_histories">
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
                                                <table class="table table-striped table-bordered">
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
                                                <table class="table table-striped table-bordered">
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
                                                <table class="table table-striped table-bordered" id="laboratory">
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
                                                <table class="table table-striped table-bordered" id="ultrasound">
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

                                         <!-- MEDICATION -->
                                         <div class="tab-pane fade " id="medication" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th>Medications</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="med_date"></td>
                                                            <td id="medications"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        

                                        <!-- DELIVERY -->
                                          <div class="tab-pane fade " id="delivery" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered" id="delivery1">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="">Name of Baby</th>
                                                            <th class="">Date of Birth</th>
                                                            <th style="">Time of Birth</th>
                                                            <th>Sex</th>
                                                            <th>Weight</th>
                                                            <th>Birth Order</th>
                                                            <th>AOG</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="name"></td>
                                                            <td id="birthday"></td>
                                                            <td id="birthtime"></td>
                                                            <td id="sex"></td>
                                                            <td id="weight"></td>
                                                            <td id="birth_order"></td>
                                                            <td id="aog"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-bordered" id="delivery2">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">HC</th>
                                                            <th class="table-plus">CC</th>
                                                            <th style="text-align: center">AC</th>
                                                            <th>BL</th>
                                                            <th>HEPA B1</th>
                                                            <th>BCG</th>
                                                            <th>NBS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="hc"></td>
                                                            <td id="cc"></td>
                                                            <td id="ac"></td>
                                                            <td id="bl"></td>
                                                            <td id="hepa"></td>
                                                            <td id="bcg"></td>
                                                            <td id="nbs"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-bordered" id="delivery3">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Hearing</th>
                                                            <th class="table-plus">Handle</th>
                                                            <th style="text-align: center">Assist</th>
                                                            <th>Referral</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="hearing"></td>
                                                            <td id="handle"></td>
                                                            <td id="assist"></td>
                                                            <td id="referral"></td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                           <!-- NEWBORN -->
                                           <div class="tab-pane fade " id="newborn" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered" id="newborn1">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="">Filter Card Number</th>
                                                            <th class="">Baby's Last Name</th>
                                                            <th class="">Mother's Last Name</th>
                                                            <th style="">Mothers' First Name</th>
                                                            <th>Date of Birth</th>
                                                            <th>Time of Birth</th>
                                                            <th>Date of Collection</th>
                                                            <th>Time of Collection</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="card"></td>
                                                            <td id="bln"></td>
                                                            <td id="mln"></td>
                                                            <td id="mfn"></td>
                                                            <td id="dob"></td>
                                                            <td id="dot"></td>
                                                            <td id="doc"></td>
                                                            <td id="toc"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-bordered" id="newborn2">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Baby's Weight</th>
                                                            <th class="table-plus">Sex</th>
                                                            <th style="text-align: center">AOG</th>
                                                            <th>Feeding</th>
                                                            <th>Status</th>
                                                            <th>Birthplace</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="baby_weight"></td>
                                                            <td id="baby_sex"></td>
                                                            <td id="baby_aog"></td>
                                                            <td id="baby_feeding"></td>
                                                            <td id="baby_status"></td>
                                                            <td id="baby_birthplace"></td>
                                                            <td id="baby_address"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-bordered" id="newborn3">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Contact Number</th>
                                                            <th class="table-plus">Name of Blood Collector</th>
                                                            <th style="">Name of Staff who will fill out the form</th>
                                                            <th>Date Result Received</th>
                                                            <th>Result</th>
                                                            <th>Date Claimed</th>
                                                            <th>Claimed By</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="baby_contact"></td>
                                                            <td id="baby_blood"></td>
                                                            <td id="baby_staff"></td>
                                                            <td id="drr"></td>
                                                            <td id="baby_result"></td>
                                                            <td id="dc"></td>
                                                            <td id="cb"></td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                         <!-- POSTPARTUM -->
                                         <div class="tab-pane fade " id="postpartum" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th>Time</th>
                                                            <th>Temperature</th>
                                                            <th>PR</th>
                                                            <th>RR</th>
                                                            <th>BP</th>
                                                            <th>U</th>
                                                            <th>S</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="post_date"></td>
                                                            <td id="post_time"></td>
                                                            <td id="post_temp"></td>
                                                            <td id="pr"></td>
                                                            <td id="rr"></td>
                                                            <td id="bp"></td>
                                                            <td id="u"></td>
                                                            <td id="s"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                          <!-- LABOR -->
                                          <div class="tab-pane fade " id="labor" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th>Time</th>
                                                            <th>Temperature</th>
                                                            <th>PR</th>
                                                            <th>RR</th>
                                                            <th>BP</th>
                                                            <th>FMT</th>
                                                            <th>Intensity</th>
                                                            <th>Interval</th>
                                                            <th>Frequency</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="labor_date"></td>
                                                            <td id="labor_time"></td>
                                                            <td id="labor_temp"></td>
                                                            <td id="labor_pr"></td>
                                                            <td id="labor_rr"></td>
                                                            <td id="labor_bp"></td>
                                                            <td id="fmt"></td>
                                                            <td id="intensity"></td>
                                                            <td id="interval"></td>
                                                            <td id="frequency"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                         <!-- STAFF NOTES -->
                                         <div class="tab-pane fade" id="staffnotes" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th>Time</th>
                                                            <th>Bed</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="staff_date"></td>
                                                            <td id="staff_time"></td>
                                                            <td id="staff_bed"></td>
                                                            <td id="staff_remarks"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- PHYSICIAN ORDER -->
                                        <div class="tab-pane fade" id="physician" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Date</th>
                                                            <th>Time</th>
                                                            <th>Bed</th>
                                                            <th>Attending Physician</th>
                                                            <th>Order</th>
                                                            <th>Time Noted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="physician_date"></td>
                                                            <td id="physician_time"></td>
                                                            <td id="physician_bed"></td>
                                                            <td id="physician_physician"></td>
                                                            <td id="physician_order"></td>
                                                            <td id="physician_time_noted"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                         <!-- PNCU -->
                                         <div class="tab-pane fade " id="records" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped table-bordered" id="records1">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="">Date</th>
                                                            <th class="">AOG</th>
                                                            <th class="">Chief Complaint</th>
                                                            <th style="">Blood Pressure</th>
                                                            <th>Weight</th>
                                                            <th>Temperature</th>
                                                            <th>Cardiac Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="records_date"></td>
                                                            <td id="records_aog"></td>
                                                            <td id="records_chief"></td>
                                                            <td id="records_blood_pressure"></td>
                                                            <td id="records_weight"></td>
                                                            <td id="records_temperature"></td>
                                                            <td id="records_cardiac"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-bordered" id="records2">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>Respiratory Rate</th>
                                                            <th class="table-plus">Fundic Height</th>
                                                            <th class="table-plus">FHT</th>
                                                            <th style="text-align: center">IE</th>
                                                            <th>Diagnosis</th>
                                                            <th>Plan</th>
                                                            <th>Follow Up Check</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="records_respiratory"></td>
                                                            <td id="records_fundic"></td>
                                                            <td id="records_fht"></td>
                                                            <td id="records_ie"></td>
                                                            <td id="records_diagnosis"></td>
                                                            <td id="records_plan"></td>
                                                            <td id="records_follow_up"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                            <!-- ATTACHMENT -->

                                            <div class="tab-pane fade " id="attachment" role="tabpanel">
                                                <div class="pd-20">
                                                    <table class="table table-striped table-bordered" id="attachment">
                                                        <thead>
                                                            <tr class="table-info">
                                                                <th class="table-plus">Date</th>
                                                                <th class="table-plus">Name</th>
                                                                <th class="table-plus">Description</th>
                                                                <th style="text-align: center">Attachment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td id="attachment_date"></td>
                                                                <td id="attachment_name"></td>
                                                                <td id="attachment_description"></td>
                                                                <td class="text-center" id="attachment_file"> <img src="{{ asset('') }}" style="max-width: 100px;" /></td>
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
