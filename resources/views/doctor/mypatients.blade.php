@extends('layouts.sidebar')
@section('title', 'Welcome')
@section('contents')

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">My Patients</h4>
                </div>
                <div class="card-box pb-10">
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label for="statusFilter">Filter by Status:</label>
                            <select id="statusFilter" class="selectpicker form-control">
                                <option value="">All</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <table class="data-table table nowrap" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $appointment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $appointment->patient->firstname }} {{ $appointment->patient->lastname }}</td>
                                    <td>{{ $appointment->service->name }}</td>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ date('h:i A', strtotime($appointment->start_time)) }}</td>
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
                                                default:
                                                    $statusWord = 'Unknown';
                                                    $badgeClass = 'badge badge-secondary';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $statusWord }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item"
                                                    href="{{ route('mypatient.show', ['userId' => $appointment->user_id]) }}">
                                                    <i class="dw dw-eye"></i> View
                                                </a>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#showModal{{ $appointment->id }}">
                                                    <i class="dw dw-add"></i> Add Medication
                                                </button>

                                                @if ($appointment->status == 2)
                                                    <form action="{{ route('appointments.complete', $appointment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="dropdown-item \">
                                                            <i class="dw
                                                            dw-tick"></i> Complete
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($appointment->status == 1 || $appointment->status == 2)
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="dropdown-item cancel-btn">
                                                            <i class="dw dw-trash"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach ($appointments as $key => $appointment)
        <div class="modal fade" id="showModal{{ $appointment->id }}" tabindex="-1"
            aria-labelledby="showModalLabel{{ $appointment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-center">Medication Information</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="multiStepForm" method="POST" action="{{ route('medication.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Patient Name</label>
                                    <div class="form-group">
                                        <input type="text" name="patient_name" class="form-control"
                                            value="{{ $appointment->patient->firstname }} {{ $appointment->patient->lastname }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Patient ID</label>
                                    <div class="form-group">
                                        <input type="text" name="patient_id" value="{{ $appointment->patient->id }}"
                                            class="form-control" readonly>
                                        <input type="hidden" name="service_id" value="{{ $appointment->service->id }}"
                                            class="form-control" readonly>
                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- Second Row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Date</label>
                                    <div class="form-group">
                                        <input type="text" name="date"
                                            value="{{ $appointment->created_at->format('Y-m-d') }}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Bed</label>
                                    <div class="form-group">
                                        <input type="text" name="bed" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Room</label>
                                    <div class="form-group">
                                        <input type="text" name="room" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Medication/Treatment</label>
                                    <div class="form-group medications-container">
                                        <a href="javascript:void(0)" class="text-success font-18 add-medication"
                                            title="Add">
                                            <i class="fa fa-plus"></i> Add another medication
                                        </a>
                                        <input type="text" name="medications[0][medications]" value=""
                                            class="form-control">
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
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    @endforeach
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
        document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                console.log('Show button clicked');
                const modalId = this.getAttribute('data-bs-target');
                console.log('Modal ID:', modalId);
                const modal = document.querySelector(modalId);
                console.log('Modal Element:', modal);
            });
        });
        $('#statusFilter').change(function() {
            var status = $(this).val();
            $('#appointmentsTable tbody tr').show(); // Show all rows
            if (status) {
                $('#appointmentsTable tbody tr').not(':contains(' + status + ')')
                    .hide(); // Hide rows not matching selected status
            }
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
    </script>
@endsection
