@extends ('layouts.sidebar')
@section('title', 'Manage Patients')
@section('contents')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Patient Informations</h4>

                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="table-plus">PATIENT ID</th>
                                    <th class="table-plus">FULLNAME</th>
                                    <th>CONTACT NUMBER</th>
                                    <th style="text-align: center">ADDRESS</th>
                                    <th>AGE</th>
                                    <th>QR CODE</th>
                                    <th>MEDICAL ACTION</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1 @endphp
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td class="table-plus">
                                            <div class="name-avatar d-flex align-items-center">
                                                <div class="txt">
                                                    <div class="weight-000"><b>{{ $patient->user_id }}</b></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="table-plus">
                                            <div class="name-avatar d-flex align-items-center">
                                                <div class="txt">
                                                    <div class="">{{ $patient->firstname }} {{ $patient->lastname }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $patient->contact_number }}</td>
                                        <td>{{ $patient->province }}, {{ $patient->city }}, {{ $patient->barangay }}</td>
                                        <td>{{ $patient->age }}</td>
                                        <td>
                                            <img src="{{ asset('qr_image/' . $patient->qr_name) }}" alt="QR Code"
                                                style="max-width: 100px;">

                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <!--
                                                            <button type="button" class="dropdown-item add-attachment-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                                <i class="dw dw-add"></i> Add Attachment
                                                            </button>
                                                            
                                                            <button type="button" class="dropdown-item add-delivery-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                                <i class="dw dw-add"></i> Add Delivery Record
                                                            </button>

                                                            <button type="button" class="dropdown-item add-labor-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                                <i class="dw dw-add"></i> Add Labor Monitoring
                                                            </button>
                                                            -->
                                                    <button type="button" class="dropdown-item add-laboratory-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add Laboratory Result
                                                    </button>
                                                    <!--
                                                            <button type="button" class="dropdown-item add-medication-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                                <i class="dw dw-add"></i> Add Medication
                                                            </button>
                                                        -->
                                                    <!--
                                                            <button type="button" class="dropdown-item add-newborn-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}"
                                                                data-patient-lastname="{{ $patient->lastname }}"
                                                                data-patient-firstname="{{ $patient->firstname }}">
                                                                <i class="dw dw-add"></i> Add Newborn Record
                                                            </button>

                                                            <button type="button" class="dropdown-item add-postpartum-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                                <i class="dw dw-add"></i> Add Postpartum Monitoring
                                                            </button>

                                                            <button type="button" class="dropdown-item add-physician-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}"
                                                                data-patient-age="{{ $patient->age }}"
                                                                data-patient-address="{{ $patient->barangay }} {{ $patient->city }} {{ $patient->province }}">
                                                                <i class="dw dw-add"></i> Add Physician's Order
                                                            </button>
                                                        -->
                                                    <button type="button" class="dropdown-item add-record-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add PNCU Record
                                                    </button>
                                                    <!--
                                                            <button type="button" class="dropdown-item add-staff-btn"
                                                                data-patient-id="{{ $patient->user_id }}"
                                                                data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}"
                                                                data-patient-age="{{ $patient->age }}"
                                                                data-patient-sex="{{ $patient->sex }}"
                                                                data-patient-civil="{{ $patient->civil }}">
                                                                <i class="dw dw-add"></i> Add Staff Notes
                                                            </button>
                                                        -->
                                                    <button type="button" class="dropdown-item add-ultrasound-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add Ultrasound Result
                                                    </button>

                                                </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <!--
                                                            <a class="dropdown-item"
                                                                href="{{ route('patients.show', ['userId' => $patient->user_id]) }}">
                                                                <i class="dw dw-eye"></i> View
                                                            </a>
                                                            -->
                                                    <a class="dropdown-item"
                                                        href="{{ route('patient.edit', ['userId' => $patient->user_id]) }}">
                                                        <i class="dw dw-edit2"></i> Edit
                                                    </a>
                                                    <form action="{{ route('patient.destroy', $patient->id) }}"
                                                        method="POST" style="display: inline;"
                                                        id="deleteForm{{ $patient->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item delete-btn"
                                                            data-user-id="{{ $patient->id }}">
                                                            <i class="dw dw-delete-3"></i> Delete
                                                            <!-- Example using Bootstrap Icons -->
                                                        </button>
                                                    </form>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--ADD PNCU RECORD-->
                    <div class="modal fade" id="addRecordModal" tabindex="-1" role="dialog"
                        aria-labelledby="addRecordModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add PNC Record</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modalContent" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('record.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="record_patient_name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_id" class="form-control"
                                                        id="record_patient_id" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Date of Visit</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                                <label>Blood Pressure</label>
                                                <div class="form-group">
                                                    <input type="text" name="blood_pressure" class="form-control">
                                                </div>
                                                <label>Cardiac Rate</label>
                                                <div class="form-group">
                                                    <input type="text" name="cardiac" class="form-control">
                                                </div>
                                                <label>FHT</label>
                                                <div class="form-group">
                                                    <input type="text" name="fht" class="form-control">
                                                </div>
                                                <label>Follow up Checkup</label>
                                                <div class="form-group">
                                                    <input type="text" name="follow_up" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>AOG in Weeks</label>
                                                <div class="form-group">
                                                    <input type="text" name="aog" class="form-control">
                                                </div>
                                                <label>Weight</label>
                                                <div class="form-group">
                                                    <input type="text" name="weight" class="form-control">
                                                </div>
                                                <label>Respiratory Rate</label>
                                                <div class="form-group">
                                                    <input type="text" name="respiratory" class="form-control">
                                                </div>
                                                <label>IE</label>
                                                <div class="form-group">
                                                    <input type="text" name="ie" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Chief Complaint</label>
                                                <div class="form-group">
                                                    <input type="text" name="chief" class="form-control">
                                                </div>
                                                <label>Temperature</label>
                                                <div class="form-group">
                                                    <input type="text" name="temperature" class="form-control">
                                                </div>
                                                <label>Fundic Height</label>
                                                <div class="form-group">
                                                    <input type="text" name="fundic" class="form-control">
                                                </div>
                                                <label>Diagnosis</label>
                                                <div class="form-group">
                                                    <input type="text" name="diagnosis" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Plan</label>
                                            <div class="form-group plan-container">
                                                <a href="javascript:void(0)" class="text-success font-13 add-plan"
                                                    title="Add">
                                                    <i class="fa fa-plus"></i> Add another plan
                                                </a>
                                                <input type="text" name="plans[0][plans]" value=""
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                onclick="printPNCU()">Print Form</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Laboratory Modal -->
                    <div class="modal fade" id="addLaboratoryModal" tabindex="-1" role="dialog"
                        aria-labelledby="addLaboratoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Laboratory Result</h3>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modalContent" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('laboratory.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="laboratory_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="laboratory_patient_id" readonly>
                                                </div>

                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>

                                                <label>Urinalysis</label>
                                                <div class="form-group">
                                                    <input type="text" name="urinalysis" class="form-control">
                                                </div>
                                                <label>CBC</label>
                                                <div class="form-group">
                                                    <input type="text" name="cbc" class="form-control">
                                                </div>
                                                <label>Blood Type</label>
                                                <div class="form-group">
                                                    <input type="text" name="blood_type" class="form-control">
                                                </div>
                                                <label>HBSAG</label>
                                                <div class="form-group">
                                                    <input type="text" name="hbsag" class="form-control">
                                                </div>
                                                <label>VDRL</label>
                                                <div class="form-group">
                                                    <input type="text" name="vdrl" class="form-control">
                                                </div>
                                                <label>FBS/75G/OGTT/HgbA1C</label>
                                                <div class="form-group">
                                                    <input type="text" name="fbs" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Submit</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="printModalContent()">Print Form</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add Ultrasound Modal -->
                    <div class="modal fade" id="addUltrasoundModal" tabindex="-1" role="dialog"
                        aria-labelledby="addUltrasoundModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Ultrasound Result</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="multiStepForm" method="POST" action="{{ route('ultrasound.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="ultrasound_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_id" class="form-control"
                                                        id="ultrasound_patient_id" readonly>
                                                </div>

                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>

                                                <label>Result</label>
                                                <div class="form-group">
                                                    <input type="text" name="result" class="form-control">
                                                </div>
                                                <label>Attachment <i>(If any)</i></label>
                                                <div class="form-group">
                                                    <input type="file" name="attachment" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                            onclick="printUltrasound()">Print Form</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Medication Modal -->
                    <div class="modal fade" id="addMedicationModal" tabindex="-1" role="dialog"
                        aria-labelledby="addMedicationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Medication</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="multiStepForm" method="POST" action="{{ route('medication.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="medication_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_id" class="form-control"
                                                        id="medication_patient_id" readonly>
                                                </div>

                                                <label>Appointment Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Bed</label>
                                                        <div class="form-group">
                                                            <input type="text" name="bed" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Room</label>
                                                        <div class="form-group">
                                                            <input type="text" name="room" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Medication/Treatment</label>
                                                    <div class="form-group medications-container">
                                                        <a href="javascript:void(0)"
                                                            class="text-success font-18 add-medication" title="Add">
                                                            <i class="fa fa-plus"></i> Add another medication
                                                        </a>
                                                        <input type="text" name="medications[0][medications]"
                                                            value="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Delivery Modal -->
                    <div class="modal fade" id="addDeliveryModal" tabindex="-1" role="dialog"
                        aria-labelledby="addDeliveryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Delivery Record</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('delivery.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="delivery_patient_name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="delivery_patient_id" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Name of Baby</label>
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                <label>Sex</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="sex">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <label>HC</label>
                                                <div class="form-group">
                                                    <input type="text" name="hc" class="form-control">
                                                </div>
                                                <label>AC</label>
                                                <div class="form-group">
                                                    <input type="text" name="ac" class="form-control">
                                                </div>
                                                <label>BCG</label>
                                                <div class="form-group">
                                                    <input type="text" name="bcg" class="form-control">
                                                </div>
                                                <label>Handle</label>
                                                <div class="form-group">
                                                    <input type="text" name="handle" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Date of Birth</label>
                                                <div class="form-group">
                                                    <input type="date" name="birthday" class="form-control">
                                                </div>

                                                <label>Weight (kgs)</label>
                                                <div class="form-group">
                                                    <input type="number" name="weight" class="form-control">
                                                </div>
                                                <label>CC</label>
                                                <div class="form-group">
                                                    <input type="text" name="cc" class="form-control">
                                                </div>
                                                <label>AOG</label>
                                                <div class="form-group">
                                                    <input type="text" name="aog" class="form-control">
                                                </div>
                                                <label>NBS</label>
                                                <div class="form-group">
                                                    <input type="text" name="nbs" class="form-control">
                                                </div>
                                                <label>Assist</label>
                                                <div class="form-group">
                                                    <input type="text" name="assist" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Time of Birth</label>
                                                <div class="form-group">
                                                    <input type="time" name="birthtime" class="form-control">
                                                </div>
                                                <label>Birth Order</label>
                                                <div class="form-group">
                                                    <input type="text" name="birth_order" class="form-control">
                                                </div>
                                                <label>BL</label>
                                                <div class="form-group">
                                                    <input type="text" name="bl" class="form-control">
                                                </div>
                                                <label>HEPA B1</label>
                                                <div class="form-group">
                                                    <input type="text" name="hepa" class="form-control">
                                                </div>
                                                <label>Hearing Test</label>
                                                <div class="form-group">
                                                    <input type="text" name="hearing" class="form-control">
                                                </div>
                                                <label>Referral</label>
                                                <div class="form-group">
                                                    <input type="text" name="referral" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Newborn Modal -->
                    <div class="modal fade" id="addNewbornModal" tabindex="-1" role="dialog"
                        aria-labelledby="addNewbornModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Newborn Record</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('newborn.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="newborn_patient_name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="newborn_patient_id" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Filter Card Number</label>
                                                <div class="form-group">
                                                    <input type="number" name="card" class="form-control"
                                                        id="card">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Baby's Last Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="baby_lastname" class="form-control">
                                                </div>
                                                <label>Sex</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="sex">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <label>Date of Collection</label>
                                                <div class="form-group">
                                                    <input type="date" name="date_collection" class="form-control">
                                                </div>
                                                <label>Baby's Weight (kgs)</label>
                                                <div class="form-group">
                                                    <input type="number" name="weight" class="form-control">
                                                </div>
                                                <label>Place of Birth</label>
                                                <div class="form-group">
                                                    <input type="text" name="birthplace" class="form-control">
                                                </div>
                                                <label>Address</label>
                                                <div class="form-group">
                                                    <input type="text" name="address" class="form-control">
                                                </div>
                                                <label>Date Result Received</label>
                                                <div class="form-group">
                                                    <input type="date" name="result_received" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Mother's Fist Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="mother_firstname" id="mother_firstname"
                                                        class="form-control" readonly>
                                                </div>

                                                <label>Date of Birth</label>
                                                <div class="form-group">
                                                    <input type="date" name="birthday" class="form-control">
                                                </div>
                                                <label>Time of Collection</label>
                                                <div class="form-group">
                                                    <input type="time" name="time_collection" class="form-control">
                                                </div>
                                                <label>AOG</label>
                                                <div class="form-group">
                                                    <input type="text" name="aog" class="form-control">
                                                </div>
                                                <label>Concact Number</label>
                                                <div class="form-group">
                                                    <input type="text" name="contact" class="form-control">
                                                </div>
                                                <label>Name of Blood Collector</label>
                                                <div class="form-group">
                                                    <input type="text" name="blood_collector" class="form-control">
                                                </div>
                                                <label>Date Claimed</label>
                                                <div class="form-group">
                                                    <input type="date" name="date_claimed" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Mother's Last Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="mother_lastname" id="mother_lastname"
                                                        class="form-control" readonly>
                                                </div>
                                                <label>Time of Birth</label>
                                                <div class="form-group">
                                                    <input type="text" name="birthtime" class="form-control">
                                                </div>
                                                <label>Feeding</label>
                                                <div class="form-group">
                                                    <input type="text" name="feeding" class="form-control">
                                                </div>
                                                <label>Baby's Status</label>
                                                <div class="form-group">
                                                    <input type="text" name="status" class="form-control">
                                                </div>
                                                <label><small>Name of Staff who fill out the form</small></label>
                                                <div class="form-group">
                                                    <input type="text" name="staff" class="form-control">
                                                </div>
                                                <label>Result</label>
                                                <div class="form-group">
                                                    <input type="text" name="result" class="form-control">
                                                </div>
                                                <label>Claimed by</label>
                                                <div class="form-group">
                                                    <input type="text" name="claimed_by" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Postpartum Modal -->
                    <div class="modal fade" id="addPostpartumModal" tabindex="-1" role="dialog"
                        aria-labelledby="addPostpartumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Postpartum</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="multiStepForm" method="POST" action="{{ route('postpartum.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="postpartum_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="postpartum_patient_id" readonly>
                                                </div>

                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Time</label>
                                                        <div class="form-group">
                                                            <input type="time" name="time" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Temperature</label>
                                                        <div class="form-group">
                                                            <input type="text" name="temperature" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>PR</label>
                                                        <div class="form-group">
                                                            <input type="text" name="pr" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>RR</label>
                                                        <div class="form-group">
                                                            <input type="text" name="rr" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>BP</label>
                                                        <div class="form-group">
                                                            <input type="text" name="bp" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>U</label>
                                                        <div class="form-group">
                                                            <input type="text" name="u" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>S</label>
                                                        <div class="form-group">
                                                            <input type="text" name="s" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Labor Modal -->
                    <div class="modal fade" id="addLaborModal" tabindex="-1" role="dialog"
                        aria-labelledby="addLaborModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Labor Monitoring</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="multiStepForm" method="POST" action="{{ route('labor.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="labor_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="labor_patient_id" readonly>
                                                </div>

                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Time</label>
                                                        <div class="form-group">
                                                            <input type="time" name="time" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Temperature</label>
                                                        <div class="form-group">
                                                            <input type="text" name="temperature" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>PR</label>
                                                        <div class="form-group">
                                                            <input type="text" name="pr" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>RR</label>
                                                        <div class="form-group">
                                                            <input type="text" name="rr" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>BP</label>
                                                        <div class="form-group">
                                                            <input type="text" name="bp" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>FMT</label>
                                                        <div class="form-group">
                                                            <input type="text" name="fmt" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Intensity</label>
                                                        <div class="form-group">
                                                            <input type="text" name="intensity" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Interval</label>
                                                        <div class="form-group">
                                                            <input type="text" name="interval" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Frequency</label>
                                                        <div class="form-group">
                                                            <input type="text" name="frequency" value=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Add Staff Modal -->
                    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog"
                        aria-labelledby="addStaffModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Staff Notes</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('staffnotes.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="staff_patient_name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="staff_patient_id" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Patient Age</label>
                                                <div class="form-group">
                                                    <input type="text" name="age" class="form-control"
                                                        id="staff_patient_age" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Patient Civil Status</label>
                                                <div class="form-group">
                                                    <input type="text" name="civil" class="form-control"
                                                        id="staff_patient_civil" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Bed Number</label>
                                                <div class="form-group">
                                                    <input type="number" name="bed" class="form-control" required>
                                                </div>
                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control" required>
                                                </div>
                                                <label>Time</label>
                                                <div class="form-group">
                                                    <input type="time" name="time" class="form-control" required>
                                                </div>
                                                <label>Remarks</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="remarks" required></textarea>
                                                </div>
                                            </div>

                                        </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Submit</span>
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add Physician's Order -->
                    <div class="modal fade" id="addPhysicianModal" tabindex="-1" role="dialog"
                        aria-labelledby="addPhysicianModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Physician Order</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                    <form id="multiStepForm" method="POST" action="{{ route('physician.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="physician_patient_name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="user_id" class="form-control"
                                                        id="physician_patient_id" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Patient Age</label>
                                                <div class="form-group">
                                                    <input type="text" name="age" class="form-control"
                                                        id="physician_patient_age" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Patient Address</label>
                                                <div class="form-group">
                                                    <input type="text" name="address" class="form-control"
                                                        id="physician_patient_address" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Bed Number</label>
                                                <div class="form-group">
                                                    <input type="number" name="bed" class="form-control" required>
                                                </div>
                                                <label>Attending Physician</label>
                                                <div class="form-group">
                                                    <input type="text" name="physician" class="form-control"
                                                        required>
                                                </div>
                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control"
                                                        required>
                                                </div>
                                                <label>Time</label>
                                                <div class="form-group">
                                                    <input type="time" name="time" class="form-control"
                                                        required>
                                                </div>
                                                <label>Order</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="order" required></textarea>
                                                </div>
                                                <label>Time Noted</label>
                                                <div class="form-group">
                                                    <input type="time" name="time_noted" class="form-control"
                                                        required>
                                                </div>
                                            </div>

                                        </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Submit</span>
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Add Attachment Modal -->
                    <div class="modal fade" id="addAttachmentModal" tabindex="-1" role="dialog"
                        aria-labelledby="addAttachmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Attachment</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="multiStepForm" method="POST" action="{{ route('attachment.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Patient Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_name" class="form-control"
                                                        id="attachment_patient_name" readonly>
                                                </div>
                                                <label>Patient ID</label>
                                                <div class="form-group">
                                                    <input type="text" name="patient_id" class="form-control"
                                                        id="attachment_patient_id" readonly>
                                                </div>

                                                <label>Date</label>
                                                <div class="form-group">
                                                    <input type="date" name="date" class="form-control">
                                                </div>
                                                <label>Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                <label>Description</label>
                                                <div class="form-group">
                                                    <input type="text" name="description" class="form-control">
                                                </div>
                                                <label>Attachment</label>
                                                <div class="form-group">
                                                    <input type="file" name="attachment" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-danger">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1"
                                                data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <script src=" {{ asset('src/scripts/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Show Add Record Modal
            $('.add-record-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#record_patient_name').val(patientName);
                $('#record_patient_id').val(patientId);
                $('#addRecordModal').modal('show');
            });

            // Show Add Ultrasound Modal
            $('.add-ultrasound-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#ultrasound_patient_name').val(patientName);
                $('#ultrasound_patient_id').val(patientId);
                $('#addUltrasoundModal').modal('show');
            });

            // Show Add Laboratory Modal
            $('.add-laboratory-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#laboratory_patient_name').val(patientName);
                $('#laboratory_patient_id').val(patientId);
                $('#addLaboratoryModal').modal('show');
            });

            //Show Add  Medication Modal
            $('.add-medication-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#medication_patient_name').val(patientName);
                $('#medication_patient_id').val(patientId);
                $('#addMedicationModal').modal('show');
            });

            //Show Add  Delivery Modal
            $('.add-delivery-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#delivery_patient_name').val(patientName);
                $('#delivery_patient_id').val(patientId);
                $('#addDeliveryModal').modal('show');
            });

            //Show Add Newborn Modal
            $('.add-newborn-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                var patientLastName = $(this).data('patient-lastname');
                var patientFirstName = $(this).data('patient-firstname');
                $('#newborn_patient_name').val(patientName);
                $('#newborn_patient_id').val(patientId);
                $('#mother_lastname').val(patientLastName);
                $('#mother_firstname').val(patientFirstName);
                $('#addNewbornModal').modal('show');
            });

            //Show Add Postpartum Modal
            $('.add-postpartum-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#postpartum_patient_name').val(patientName);
                $('#postpartum_patient_id').val(patientId);
                $('#addPostpartumModal').modal('show');
            });
            //Show Add Labor Modal
            $('.add-labor-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#labor_patient_name').val(patientName);
                $('#labor_patient_id').val(patientId);
                $('#addLaborModal').modal('show');
            });

            //Show Add Labor Modal
            $('.add-staff-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                var patientAge = $(this).data('patient-age');
                var patientSex = $(this).data('patient-sex');
                var patientCivil = $(this).data('patient-civil');
                $('#staff_patient_name').val(patientName);
                $('#staff_patient_id').val(patientId);
                $('#staff_patient_sex').val(patientSex);
                $('#staff_patient_age').val(patientAge);
                $('#staff_patient_civil').val(patientCivil);
                $('#addStaffModal').modal('show');
            });

            //Show Add Physician Order Modal
            $('.add-physician-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                var patientAge = $(this).data('patient-age');
                var patientAddress = $(this).data('patient-address');
                $('#physician_patient_name').val(patientName);
                $('#physician_patient_id').val(patientId);
                $('#physician_patient_address').val(patientAddress);
                $('#physician_patient_age').val(patientAge);
                $('#addPhysicianModal').modal('show');
            });

            // Show Add Attachment Modal
            $('.add-attachment-btn').click(function() {
                var patientId = $(this).data('patient-id');
                var patientName = $(this).data('patient-name');
                $('#attachment_patient_name').val(patientName);
                $('#attachment_patient_id').val(patientId);
                $('#addAttachmentModal').modal('show');
            });

            $('.modal .close').click(function() {
                $(this).closest('.modal').modal('hide');
            });

        });


        document.querySelectorAll('.add-plan').forEach(button => {
            button.addEventListener("click", function() {
                var container = this.parentElement;
                var input = container.querySelector("input[name^='plans']");
                var clone = input.cloneNode(true);
                var newIndex = container.querySelectorAll("input[name^='plans']").length;
                clone.name = "plans[" + newIndex + "][plans]";
                container.appendChild(clone);

                var removeBtn = document.createElement('button');
                removeBtn.innerHTML = 'Remove';
                removeBtn.className = 'btn btn-danger btn-sm remove-plan';
                removeBtn.addEventListener('click', function() {
                    container.removeChild(clone); // Remove the associated input field
                    container.removeChild(removeBtn); // Remove the remove button
                });
                container.appendChild(removeBtn);
            });
        });

        document.querySelectorAll('.add-medication').forEach(button => {
            button.addEventListener("click", function() {
                var container = this.parentElement;
                var input = container.querySelector("input[name^='medications']");
                var clone = input.cloneNode(true);
                var newIndex = container.querySelectorAll("input[name^='medications']").length;
                clone.name = "medications[" + newIndex + "][medications]";
                container.appendChild(clone);

                var removeBtn = document.createElement('button');
                removeBtn.innerHTML = 'Remove';
                removeBtn.className = 'btn btn-danger btn-sm remove-medication';
                removeBtn.addEventListener('click', function() {
                    container.removeChild(clone); // Remove the associated input field
                    container.removeChild(removeBtn); // Remove the remove button
                });
                container.appendChild(removeBtn);
            });
        });

        function printModalContent() {
        var modalContent = document.getElementById('modalContent');
            // Print the form fields in a more readable layout
            var printWindow = window.open();
            printWindow.document.write('<div class="print-section"><h1 style="text-align:center">LABORATORY RESULT</h1></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Patient Name:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Patient ID:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Date:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Urinalysis:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>CBC:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Blood Type:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>HBSAG:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>VDRL:</label></div>');
            printWindow.document.write('<br>'); 
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>FBS/75G/OGTT/HgbA1C:</div>');
                            
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        } 

        function printPNCU() {
        var modalContent = document.getElementById('modalContent');
    
            var printWindow = window.open();
            printWindow.document.write('<div class="print-section"><h1 style="text-align:center">PNCU RECORD</h1></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Patient Name:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Patient ID:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Date of Visit:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Blood Pressure:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Cardiac Rate:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>FHT:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Follow-up Checkup:</label>        </div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>AOG in Weeks:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Weight:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Respiratory Rate:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>IE:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Chief Complaint:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Temperature:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Fundic Height:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Diagnosis:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section"><label>Plans:</label></div>');

            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        } 
        function printUltrasound() {
        var modalContent = document.getElementById('modalContent');
            // Print the form fields in a more readable layout
            var printWindow = window.open();
            printWindow.document.write('<div class="print-section"><h1 style="text-align:center">ULTRASOUND RESULT</h1></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Patient Name:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Patient ID:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Date:</label></div>');
            printWindow.document.write('<br>');
            printWindow.document.write('<div class="print-section" style="font-size:1.6rem"><label>Result:</label></div>');
                            
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        } 
    </script>
@endsection
