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
                                    <th class="table-plus">Patient ID</th>
                                    <th class="table-plus">Fullname</th>
                                    <th>Contact Number</th>
                                    <th style="text-align: center">Address</th>
                                    <th>Age</th>
                                    <th>QR Code</th>
                                    <th>Medical Action</th>
                                    <th>Action</th>
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

                                                    <button type="button" class="dropdown-item add-record-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add Record
                                                    </button>

                                                    <button type="button" class="dropdown-item add-ultrasound-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add Ultrasound Result
                                                    </button>

                                                    <button type="button" class="dropdown-item add-laboratory-btn"
                                                        data-patient-id="{{ $patient->user_id }}"
                                                        data-patient-name="{{ $patient->firstname }} {{ $patient->lastname }}">
                                                        <i class="dw dw-add"></i> Add Laboratory Result
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
                    <!--ADD RECORD-->
                    <div class="modal fade" id="addRecordModal" tabindex="-1" role="dialog"
                        aria-labelledby="addRecordModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Add Record</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
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
                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
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
    </script>
@endsection
