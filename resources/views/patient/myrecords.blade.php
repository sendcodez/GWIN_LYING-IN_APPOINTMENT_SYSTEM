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
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#personal"
                                                role="tab">Personal Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#appointment"
                                                role="tab">Completed Appointments</a>
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
                                        <!--
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#medication"
                                                    role="tab">Medications</a>
                                            </li>
                                        -->
                                    </ul>
                                    <div class="tab-content">

                                        <!-- PERSONAL -->
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                            <div class="pd-20 profile-task-wrap">
                                                @if ($patient->isNotEmpty())
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="pd-20 card-box height-100-p">
                                                                <div class="profile-info">
                                                                    <h5 class="mb-20 h5 text-green">Patient Informations
                                                                    </h5>

                                                                    <ul>
                                                                        <li>
                                                                            <span>Full Name:</span>
                                                                            {{ $patient->first()->firstname }}
                                                                            {{ $patient->first()->lastname }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Phone Number:</span>
                                                                            {{ $patient->first()->contact_number }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Birthplace:</span>
                                                                            {{ $patient->first()->birthplace }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Birthday:</span>
                                                                            {{ $patient->first()->birthday }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Age:</span>
                                                                            {{ $patient->first()->age }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Civil Status:</span>
                                                                            {{ $patient->first()->civil }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Religion:</span>
                                                                            {{ $patient->first()->religion }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Occupation:</span>
                                                                            {{ $patient->first()->occupation }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Nationality:</span>
                                                                            {{ $patient->first()->nationality }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="pd-20 card-box height-100-p">
                                                                <div class="profile-info">
                                                                    <h5 class="mb-20 h5 text-green">Husband Informations
                                                                    </h5>
                                                                    <ul>
                                                                        <li>
                                                                            <span>Full Name:</span>
                                                                            {{ $patient->first()->husband_firstname }}
                                                                            {{ $patient->first()->husband_lastname }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Contact Number:</span>
                                                                            {{ $patient->first()->husband_contact_number }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Birthday:</span>
                                                                            {{ $patient->first()->husband_birthday }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Age:</span>
                                                                            {{ $patient->first()->husband_age }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Occupation:</span>
                                                                            {{ $patient->first()->husband_occupation }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Religion:</span>
                                                                            {{ $patient->first()->husband_religion }}
                                                                        </li>
                                                                        <li>
                                                                            <span>Address:</span>
                                                                            Barangay {{ $patient->first()->barangay }},
                                                                            {{ $patient->first()->city }},
                                                                            {{ $patient->first()->province }}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <center>No Data Available</center>
                                                @endif
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
                                                        @if ($pregterm->isNotEmpty())
                                                            <tr>
                                                                <td id="gravida">{{ $pregterm->first()->gravida }}</td>
                                                                <td id="para">{{ $pregterm->first()->para }}</td>
                                                                <td id="t">{{ $pregterm->first()->t }}</td>
                                                                <td id="p">{{ $pregterm->first()->p }}</td>
                                                                <td id="a">{{ $pregterm->first()->a }}</td>
                                                                <td id="l">{{ $pregterm->first()->l }}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="6" class="text-center">No data available
                                                                </td>
                                                            </tr>
                                                        @endif
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
                                                        @forelse ($preghis as $history)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $history->pregnancy_date }}</td>
                                                                <td>{{ $history->aog }}</td>
                                                                <td>{{ $history->manner }}</td>
                                                                <td>{{ $history->bw }}</td>
                                                                <td>{{ $history->sex }}</td>
                                                                <td>{{ $history->present_status }}</td>
                                                                <td>{{ $history->complications }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" style="text-align: center">No data
                                                                    available</td>
                                                            </tr>
                                                        @endforelse
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
                                                        @if ($medical->isNotEmpty())
                                                            <tr>
                                                                <td id="hypertension" class="text-center">
                                                                    {{ $medical->first()->hypertension ? 'Yes' : 'No' }}
                                                                </td>
                                                                <td id="heartdisease" class="text-center">
                                                                    {{ $medical->first()->heart_disease ? 'Yes' : 'No' }}
                                                                </td>
                                                                <td id="asthma" class="text-center">
                                                                    {{ $medical->first()->asthma ? 'Yes' : 'No' }}</td>
                                                                <td id="tuberculosis" class="text-center">
                                                                    {{ $medical->first()->tuberculosis ? 'Yes' : 'No' }}
                                                                </td>
                                                                <td id="diabetes" class="text-center">
                                                                    {{ $medical->first()->diabetes ? 'Yes' : 'No' }}</td>
                                                                <td id="goiter" class="text-center">
                                                                    {{ $medical->first()->goiter ? 'Yes' : 'No' }}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="6" class="text-center">No data available
                                                                </td>
                                                            </tr>
                                                        @endif
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
                                                        @if ($medical->isNotEmpty())
                                                            <tr>
                                                                <td id="hypertension" class="text-center">
                                                                    {{ $medical->first()->epilepsy ? 'Yes' : 'No' }}</td>
                                                                <td id="heartdisease" class="text-center">
                                                                    {{ $medical->first()->allergy ? 'Yes' : 'No' }}</td>
                                                                <td id="asthma" class="text-center">
                                                                    {{ $medical->first()->hepatitis ? 'Yes' : 'No' }}</td>
                                                                <td id="tuberculosis" class="text-center">
                                                                    {{ $medical->first()->vdrl ? 'Yes' : 'No' }}</td>
                                                                <td id="diabetes" class="text-center">
                                                                    {{ $medical->first()->bleeding ? 'Yes' : 'No' }}</td>
                                                                <td id="goiter" class="text-center">
                                                                    {{ $medical->first()->operation ? 'Yes' : 'No' }}</td>
                                                                <td id="others" class="text-center">
                                                                    {{ $medical->first()->others ?: 'No' }}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan="7" class="text-center">No data available
                                                                </td>
                                                            </tr>
                                                        @endif
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
                                                            <th>#</th>
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
                                                        @forelse ($lab as $laboratory)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $laboratory->date }}</td>
                                                                <td>{{ $laboratory->urinalysis }}</td>
                                                                <td>{{ $laboratory->cbc }}</td>
                                                                <td>{{ $laboratory->blood_type }}</td>
                                                                <td>{{ $laboratory->hbsag }}</td>
                                                                <td>{{ $laboratory->vdrl }}</td>
                                                                <td>{{ $laboratory->fbs }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" style="text-align: center">No data
                                                                    available</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- APPOINTMENT -->
                                        <div class="tab-pane fade " id="appointment" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped" id="appointment">
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
                                                        @forelse ($app as $appointment)
                                                            <tr>
                                                                <!--<td>{{ $loop->iteration }}</td>-->
                                                                <td>{{ $appointment->date }}</td>
                                                                <td>Dr. {{ $appointment->doctor->lastname }}</td>
                                                                <td>
                                                                    @if ($appointment->services && $appointment->services->count() > 0)
                                                                        @foreach ($appointment->services as $service)
                                                                            {{ $service->name }}<br>
                                                                        @endforeach
                                                                    @else
                                                                        <span style="color:red">Service Not Found</span>
                                                                    @endif
                                                                </td>

                                                                <td>{{ $appointment->start_time }}</td>
                                                                <td>
                                                                    @php
                                                                        $statusWord = '';
                                                                        $badgeClass = '';
                                                                        switch ($appointment->status) {
                                                                            case 1:
                                                                                $statusWord = 'Pending';
                                                                                $badgeClass = 'badge badge-warning';
                                                                                break;
                                                                            case 2:
                                                                                $statusWord = 'Approved';
                                                                                $badgeClass = 'badge badge-success';
                                                                                break;
                                                                            case 3:
                                                                                $statusWord = 'Completed';
                                                                                $badgeClass = 'badge badge-primary';
                                                                                break;
                                                                            case 4:
                                                                                $statusWord = 'Cancelled';
                                                                                $badgeClass = 'badge badge-danger';
                                                                                break;
                                                                            case 5:
                                                                                $statusWord = 'Disapproved';
                                                                                $badgeClass = 'badge badge-warning';
                                                                                break;
                                                                            default:
                                                                                $statusWord = 'Unknown';
                                                                                $badgeClass = 'badge badge-secondary';
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    <span
                                                                        class="{{ $badgeClass }}">{{ $statusWord }}</span>
                                                                </td>
                                                            </tr>
                                                            <div class="modal fade" id="showModal{{ $appointment->id }}"
                                                                tabindex="-1"
                                                                aria-labelledby="showModal{{ $appointment->id }}Label"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 class="text-center">Appointment Information
                                                                            </h3>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p><strong>Doctor Name:</strong> Dr.
                                                                                {{ $appointment->doctor->firstname }}
                                                                                {{ $appointment->doctor->lastname }}
                                                                            </p>
                                                                            <p><strong>Patient Name:</strong>
                                                                                {{ $appointment->patient->firstname }}
                                                                                {{ $appointment->patient->lastname }}
                                                                            </p>
                                                                            @foreach ($appointment->medications as $medication)
                                                                                <p><strong>Bed:</strong>
                                                                                    {{ $medication->bed }}</p>
                                                                                <p><strong>Room:</strong>
                                                                                    {{ $medication->room }}</p>
                                                                                <p><strong>Date:</strong>
                                                                                    {{ $medication->date }}</p>
                                                                                <p><strong>Medications:</strong>
                                                                                    {{ implode(', ', json_decode($medication->medications)) }}
                                                                                </p>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" style="text-align: center">No data
                                                                    available</td>
                                                            </tr>
                                                        @endforelse
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
                                                            <th>#</th>
                                                            <th class="table-plus" style="text-align: center">Date</th>
                                                            <th class="table-plus" style="text-align: center">Result</th>
                                                            <th style="text-align: center">Attachment <i
                                                                    style="color:red"><small>(Click image to
                                                                        download)</small> </i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($ultra as $ultrasound)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td style="text-align: center">{{ $ultrasound->date }}
                                                                </td>
                                                                <td style="text-align: center">{{ $ultrasound->result }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <a href="{{ asset('ultrasound_image/' . $ultrasound->attachment) }}"
                                                                        download="{{ $ultrasound->attachment }}">
                                                                        <img src="{{ asset('ultrasound_image/' . $ultrasound->attachment) }}"
                                                                            alt="Ultrasound Image"
                                                                            style="max-width: 100px;">
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" style="text-align: center">No data
                                                                    available</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- MEDICATION -->
                                        <div class="tab-pane fade " id="medication" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped" id="medication">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>#</th>
                                                            <th class="table-plus">Date</th>
                                                            <th class="table-plus">Medications</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($medication as $medication)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $medication->created_at->format('Y-m-d') }}</td>
                                                                <td>
                                                                    @php
                                                                        $medications = json_decode(
                                                                            $medication->medications,
                                                                        );
                                                                        if ($medications) {
                                                                            // If decoding is successful
                                                                            echo implode(', ', $medications); // Display medications separated by comma
                                                                        } else {
                                                                            // If decoding fails or medications are empty
                                                                            echo 'No medications';
                                                                        }
                                                                    @endphp
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" style="text-align: center">No data
                                                                    available</td>
                                                            </tr>
                                                        @endforelse
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#addUserModal .close').click(function() {
                    $('#addUserModal').modal('hide');
                });
                $('.modal .close').click(function() {
                    $(this).closest('.modal').modal('hide');
                });
            });
        </script>
    @endsection
