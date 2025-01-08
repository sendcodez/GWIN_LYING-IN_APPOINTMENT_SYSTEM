@extends('layouts.sidebar')
@section('title', 'Pending Appointments')
@section('contents')

    <style>
        .modal-content {
            width: 100%;
            /* Ensure modal takes full width */
            max-width: 500px;
            /* Set a max width to prevent stretching */
        }
    </style>
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Appointments</h4>
                </div>

                <div class="card-box pb-10">
                    <div class="table-responsive">
                    <table class="table table-striped" id="appointmentsTable">
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

                                    <td>{{ ucfirst($appointment->day) }}</td>
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
    </div>
    <!-- Modal for approving appointment -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                            <select class="form-control" id="start_time" name="start_time" required>
                                <option value="" disabled selected>-- Select Start Time --</option>
                                <!-- Options will be dynamically loaded based on selected doctor -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <select class="form-control" id="end_time" name="end_time" required>
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
    // Close modal handlers
    $('#addUserModal .close, .modal .close').click(function() {
        $(this).closest('.modal').modal('hide');
    });

    // Filter appointments based on selected status
    $('#statusFilter').change(function() {
        var status = $(this).val();
        $('#appointmentsTable tbody tr').show(); // Show all rows
        if (status) {
            $('#appointmentsTable tbody tr').not(':contains(' + status + ')').hide(); // Hide non-matching rows
        }
    });

    // Handle dropdown item clicks for modals
    document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');
            const doctorId = this.getAttribute('data-doctor-id');
            const selectedDate = this.getAttribute('data-date');

            // Set form action and input values
            const form = document.getElementById('approveForm');
            form.action = `/appointments/${appointmentId}/approve`;
            document.getElementById('appointment_id').value = appointmentId;
            document.getElementById('doctor_id').value = doctorId;

            // Update available times based on selected doctor and date
            const availabilities = @json($groupedAvailabilities);
            const existingAppointments = @json($existingAppointments);

            // Populate time slots
            populateTimeSlots(doctorId, selectedDate, availabilities, existingAppointments);
        });
    });
});

// Function to populate time slots
function populateTimeSlots(doctorId, selectedDate, availabilities, existingAppointments) {
    const startTimeSelect = document.getElementById('start_time');
    const endTimeSelect = document.getElementById('end_time');

    // Clear previous selections
    startTimeSelect.innerHTML = '';
    endTimeSelect.innerHTML = '';

    // Add the default option for start time
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = '-- Select Start Time --';
    startTimeSelect.appendChild(defaultOption);

    // Convert selected date to day name
    const dayName = new Date(selectedDate).toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();

    // Get availabilities for the doctor on the selected day
    const doctorAvailabilities = availabilities[doctorId] || {};
    const appointmentsForDay = existingAppointments[doctorId] || [];
    const bookedSlots = appointmentsForDay.filter(app => app.date === selectedDate).map(app => ({
            start: new Date(`1970-01-01T${app.start_time}`),        
            end: new Date(`1970-01-01T${app.end_time}`)
        }));

        console.log('Doctor ID:', doctorId);
        console.log('Selected Date:', selectedDate);
        console.log('Doctor Availabilities:', doctorAvailabilities);
        console.log('Booked Slots:', bookedSlots);

        // Populate available time slots
        if (doctorAvailabilities[dayName]) {
            const timesForDay = doctorAvailabilities[dayName];
            const availableSlots = [];

            // Generate 30-minute intervals and check for booked slots
            timesForDay.forEach(avail => {
                const startTime = new Date(`1970-01-01T${avail.start_time}`);
                const endTime = new Date(`1970-01-01T${avail.end_time}`);
                for (let time = new Date(startTime); time < endTime; time.setMinutes(time.getMinutes() + 30)) {
                    const isBooked = bookedSlots.some(slot => time >= slot.start && time < slot.end);
                    if (!isBooked) {
                        availableSlots.push(new Date(time));
                    }
                }
            });

            console.log('Available Slots:', availableSlots); // Debugging available slots

            // Populate start time dropdown with available slots
            availableSlots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.toTimeString().slice(0, 5);
                option.textContent = slot.toTimeString().slice(0, 5);
                startTimeSelect.appendChild(option);
            });

            // Event delegation for start time selection
            $(document).on('change', '#start_time', function() {
                endTimeSelect.innerHTML = ''; // Clear end time dropdown
                const selectedStartTime = new Date(`1970-01-01T${this.value}:00`);
                
                // Automatically set end time to the next available 30-minute increment
                const endTime = new Date(selectedStartTime);
                endTime.setMinutes(selectedStartTime.getMinutes() + 30);

                // Check for available end times
                availableSlots.forEach(slot => {
                    if (slot > selectedStartTime) {
                        const option = document.createElement('option');
                        option.value = slot.toTimeString().slice(0, 5);
                        option.textContent = slot.toTimeString().slice(0, 5);
                        endTimeSelect.appendChild(option);
                    }
                });

                // If end time is still empty, set it to the next available hour (e.g., 18:00 if 17:30 is selected)
                if (endTimeSelect.innerHTML === '') {
                    const nextAvailableHour = new Date(selectedStartTime);
                    nextAvailableHour.setHours(selectedStartTime.getHours() + 1);
                    nextAvailableHour.setMinutes(0);
                    
                    const option = document.createElement('option');
                    option.value = nextAvailableHour.toTimeString().slice(0, 5);
                    option.textContent = nextAvailableHour.toTimeString().slice(0, 5);
                    endTimeSelect.appendChild(option);
                }
            });
        } else {
            // If no availabilities, display "No available times"
            const option = document.createElement('option');
            option.textContent = 'No available times';
            startTimeSelect.appendChild(option);
        }
    }


        $(document).ready(function() {
        $('#appointmentsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
        });
    });
        </script>
@endsection
