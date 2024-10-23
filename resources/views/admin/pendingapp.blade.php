@extends('layouts.sidebar')
@section('title', 'Pending Appointments')
@section('contents')
    <style>
        .modal {
            z-index: 1050 !important;
            /* Ensure modal is above other content */
        }

        .modal-backdrop {
            z-index: 1040 !important;
            /* Ensure backdrop is below the modal */
        }

        .modal-content {
            pointer-events: auto;
        }
    </style>
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Appointments</h4>
                </div>

                <div class="card-box pb-10">
                    <table class="data-table table nowrap" id="appointmentsTable">
                        <thead>
                            <tr>
                                <!--   <th>#</th>-->
                                <th>DATE</th>
                                <th>PATIENT NAME</th>
                                <th>DOCTOR NAME</th>
                                <th>SERVICE</th>

                                <th>TIME</th>
                                <th>DAY</th>
                                <!--    <th class="text-center">MODE OF APPOINTMENT</th> -->
                                <th>STATUS</th>

                                <th>ACTION</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $appointment)
                                <tr>
                                    <!--    <td>{{ $key + 1 }}</td> -->
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ ucfirst($appointment->patient->firstname) }}
                                        {{ ucfirst($appointment->patient->lastname) }}</td>
                                    <td>
                                        @if ($appointment->doctor && $appointment->doctor->lastname)
                                            Dr. {{ ucfirst($appointment->doctor->lastname) }}
                                        @else
                                            <span style="color:red">Doctor Not Found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($appointment->services->isNotEmpty())
                                            @foreach ($appointment->services as $service)
                                                {{ $service->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @else
                                            <span style="color:red">Service Not Found</span>
                                        @endif
                                    </td>


                                    <td>
                                        @if ($appointment->start_time)
                                            {{ date('h:i A', strtotime($appointment->start_time)) }}
                                        @else
                                            Not Set
                                        @endif
                                    </td>

                                    <td>{{ $appointment->day }}</td>
                                    <!--   <td class="text-center">{{ $appointment->remarks }}</td> -->
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
                                                    $badgeClass = 'badge badge-info';
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
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#showModal{{ $appointment->id }}">
                                                    <i class="dw dw-eye"></i> Show
                                                </button>
                                                @if ($appointment->status == 1)
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#approveModal"
                                                        data-appointment-id="{{ $appointment->id }}"
                                                        data-doctor-id="{{ $appointment->doctor_id }}"
                                                        data-date="{{ $appointment->date }}">
                                                        <i class="dw dw-check"></i> Approve
                                                    </button>
                                                @endif

                                                @if ($appointment->status == 1)
                                                    <form action="{{ route('appointments.disapprove', $appointment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="dw dw-cancel"></i> Disapprove
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($appointment->status == 2)
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

                                <!-- Modal for appointment details -->
                                <div class="modal fade" id="showModal{{ $appointment->id }}" tabindex="-1"
                                    aria-labelledby="showModalLabel{{ $appointment->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="text-center">Appointment Information</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Doctor Name:</strong>
                                                    @if ($appointment->doctor && $appointment->doctor->firstname && $appointment->doctor->lastname)
                                                        Dr. {{ $appointment->doctor->firstname }}
                                                        {{ ucfirst($appointment->doctor->lastname) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>

                                                <p><strong>Patient Name:</strong>
                                                    {{ $appointment->patient->firstname }}
                                                    {{ $appointment->patient->lastname }}
                                                </p>
                                                <p><strong>Service:</strong>
                                                    @if ($appointment->services->isNotEmpty())
                                                        @foreach ($appointment->services as $service)
                                                            {{ $service->name }}@if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span style="color:red">Service Not Found</span>
                                                    @endif
                                                </p>

                                                <p><strong>Date:</strong> {{ $appointment->date }}</p>
                                                <p><strong>Time:</strong> {{ $appointment->start_time }}</p>
                                                <p><strong>Status:</strong>
                                                    @php
                                                        switch ($appointment->status) {
                                                            case 1:
                                                                echo '<span class="badge badge-warning">Pending</span>';
                                                                break;
                                                            case 2:
                                                                echo '<span class="badge badge-success">Approved</span>';
                                                                break;
                                                            case 3:
                                                                echo '<span class="badge badge-primary">Completed</span>';
                                                                break;
                                                            case 4:
                                                                echo '<span class="badge badge-danger">Cancelled</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge badge-secondary">Unknown</span>';
                                                                break;
                                                        }
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for approving appointment -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Set Appointment Time</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approveForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="appointment_id" id="appointment_id">
                        <input type="hidden" name="doctor_id" id="doctor_id">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <select class="form-control form-control-sm" id="start_time" name="start_time" required>
                                <!-- Options will be dynamically loaded based on selected doctor -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <select class="form-control form-control-sm" id="end_time" name="end_time" required>
                                <!-- Options will be dynamically loaded based on selected doctor -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </div>
                </form>

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
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-appointment-id');
                const form = document.getElementById('approveForm');
                const actionUrl =
                    `/appointments/${appointmentId}/approve`; // Adjust this URL to match your route
                form.action = actionUrl;
                document.getElementById('appointment_id').value = appointmentId;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.getAttribute('data-appointment-id');
                    const doctorId = this.getAttribute('data-doctor-id');
                    const selectedDate = this.getAttribute('data-date');

                    const form = document.getElementById('approveForm');
                    const actionUrl =
                    `/appointments/${appointmentId}/approve`; // Adjust this URL to match your route
                    form.action = actionUrl;
                    document.getElementById('appointment_id').value = appointmentId;
                    document.getElementById('doctor_id').value = doctorId;

                    // Update available times based on selected doctor and date
                    const availabilities =
                    @json($groupedAvailabilities); // Pass availabilities as JSON
                    const existingAppointments =
                    @json($existingAppointments); // Pass existing appointments as JSON

                    const startTimeSelect = document.getElementById('start_time');
                    const endTimeSelect = document.getElementById('end_time');

                    // Clear previous selections and reset values
                    startTimeSelect.innerHTML = '';
                    endTimeSelect.innerHTML = '';
                    startTimeSelect.value = '';
                    endTimeSelect.value = '';

                    // Remove old event listeners from start time dropdown
                    let newStartTimeSelect = startTimeSelect.cloneNode(true);
                    startTimeSelect.parentNode.replaceChild(newStartTimeSelect, startTimeSelect);

                    // Convert selected date to day name
                    const dayName = new Date(selectedDate).toLocaleDateString('en-US', {
                        weekday: 'long'
                    }).toLowerCase();

                    const doctorAvailabilities = availabilities[doctorId];
                    const doctorAppointments = existingAppointments[doctorId] || [];

                    const bookedSlots = doctorAppointments.map(app => ({
                        start: new Date(`1970-01-01T${app.start_time}`),
                        end: new Date(`1970-01-01T${app.end_time}`)
                    }));

                    if (doctorAvailabilities && doctorAvailabilities[dayName]) {
                        const timesForDay = doctorAvailabilities[dayName];
                        const timeSlots = [];

                        timesForDay.forEach(avail => {
                            const startTime = new Date(`1970-01-01T${avail.start_time}`);
                            const endTime = new Date(`1970-01-01T${avail.end_time}`);

                            // Generate 30-minute intervals
                            for (let time = startTime; time < endTime; time.setMinutes(time
                                    .getMinutes() + 30)) {
                                const isBooked = bookedSlots.some(slot => time >= slot
                                    .start && time < slot.end);
                                if (!isBooked) {
                                    timeSlots.push(new Date(time));
                                }
                            }
                        });

                        timeSlots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.toTimeString().slice(0, 5);
                            option.textContent = slot.toTimeString().slice(0, 5);
                            newStartTimeSelect.appendChild(option);
                        });

                        // Add change event listener to start time dropdown
                        newStartTimeSelect.addEventListener('change', function() {
                            endTimeSelect.innerHTML = ''; // Clear end time dropdown
                            const selectedStartTime = new Date(
                                `1970-01-01T${this.value}:00`);
                            timeSlots.forEach(slot => {
                                if (slot > selectedStartTime) {
                                    const option = document.createElement('option');
                                    option.value = slot.toTimeString().slice(0, 5);
                                    option.textContent = slot.toTimeString().slice(
                                        0, 5);
                                    endTimeSelect.appendChild(option);
                                }
                            });
                        });
                    } else {
                        const option = document.createElement('option');
                        option.textContent = 'No available times';
                        newStartTimeSelect.appendChild(option);
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event listeners to all buttons that trigger the modal
            document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    // Get relevant data from the clicked button
                    const appointmentId = this.getAttribute('data-appointment-id');
                    const doctorId = this.getAttribute('data-doctor-id');
                    const selectedDate = this.getAttribute('data-date');

                    const form = document.getElementById('approveForm');
                    const actionUrl =
                    `/appointments/${appointmentId}/approve`; // Adjust this URL to match your route
                    form.action = actionUrl;
                    document.getElementById('appointment_id').value = appointmentId;
                    document.getElementById('doctor_id').value = doctorId;

                    // Update available times based on selected doctor and date
                    const availabilities =
                    @json($groupedAvailabilities); // Pass availabilities as JSON from backend
                    const existingAppointments =
                    @json($existingAppointments); // Pass existing appointments as JSON from backend

                    const startTimeSelect = document.getElementById('start_time');
                    const endTimeSelect = document.getElementById('end_time');

                    // Clear previous selections and reset values completely
                    startTimeSelect.innerHTML = '';
                    endTimeSelect.innerHTML = '';
                    startTimeSelect.value = '';
                    endTimeSelect.value = '';

                    // Remove all event listeners from the start_time dropdown to avoid duplicates
                    let newStartTimeSelect = startTimeSelect.cloneNode(true);
                    startTimeSelect.parentNode.replaceChild(newStartTimeSelect, startTimeSelect);

                    // Convert selected date to day name (e.g., 'Monday')
                    const dayName = new Date(selectedDate).toLocaleDateString('en-US', {
                        weekday: 'long'
                    }).toLowerCase();

                    // Get the availabilities for the doctor on the selected day
                    const doctorAvailabilities = availabilities[doctorId] || {};
                    const doctorAppointments = existingAppointments[doctorId] || [];

                    // Filter appointments for the selected date only
                    const appointmentsForDay = doctorAppointments.filter(app => {
                        const appDate = new Date(app.date)
                    .toDateString(); // Assumes app.date holds the appointment date
                        return appDate === new Date(selectedDate).toDateString();
                    });

                    // Map the booked slots for the selected day
                    const bookedSlots = appointmentsForDay.map(app => ({
                        start: new Date(`1970-01-01T${app.start_time}`),
                        end: new Date(`1970-01-01T${app.end_time}`)
                    }));

                    if (doctorAvailabilities[dayName]) {
                        const timesForDay = doctorAvailabilities[dayName];
                        const availableSlots = [];

                        // Generate 30-minute intervals and check for booked slots for the selected date
                        timesForDay.forEach(avail => {
                            const startTime = new Date(`1970-01-01T${avail.start_time}`);
                            const endTime = new Date(`1970-01-01T${avail.end_time}`);

                            for (let time = new Date(startTime); time < endTime; time
                                .setMinutes(time.getMinutes() + 30)) {
                                const isBooked = bookedSlots.some(slot => time >= slot
                                    .start && time < slot.end);
                                if (!isBooked) {
                                    availableSlots.push(new Date(time));
                                }
                            }
                        });

                        // Populate start time dropdown with available slots
                        availableSlots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.toTimeString().slice(0, 5);
                            option.textContent = slot.toTimeString().slice(0, 5);
                            newStartTimeSelect.appendChild(option);
                        });

                        // Add event listener to update end time when a start time is selected
                        newStartTimeSelect.addEventListener('change', function() {
                            endTimeSelect.innerHTML = ''; // Clear the end time dropdown
                            const selectedStartTime = new Date(
                                `1970-01-01T${this.value}:00`);

                            // Populate end time dropdown with slots after the selected start time
                            availableSlots.forEach(slot => {
                                if (slot > selectedStartTime) {
                                    const option = document.createElement('option');
                                    option.value = slot.toTimeString().slice(0, 5);
                                    option.textContent = slot.toTimeString().slice(
                                        0, 5);
                                    endTimeSelect.appendChild(option);
                                }
                            });
                        });
                    } else {
                        // If no availabilities, display "No available times"
                        const option = document.createElement('option');
                        option.textContent = 'No available times';
                        newStartTimeSelect.appendChild(option);
                    }
                });
            });
        });
    </script>
@endsection
