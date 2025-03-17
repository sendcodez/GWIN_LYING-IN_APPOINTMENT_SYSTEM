@extends('layouts.sidebar')
@section('title', 'Pending Appointments')
@section('contents')

    <style>
       /* Updated CSS to center the modal properly */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    display: none; /* Hidden by default */
}

.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1051;
}

.custom-modal-content {
    position: absolute;
    width: 100%;
    max-width: 500px;
    background-color: #fff;
    border-radius: 0.3rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    z-index: 1052;
    animation: modalFadeIn 0.3s ease-out;
    
    /* Center positioning */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        top: 45%;
    }
    to {
        opacity: 1;
        top: 50%;
    }
}

.custom-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.custom-modal-title {
    margin: 0;
    font-size: 1.25rem;
}

.custom-close-btn {
    background: transparent;
    border: 0;
    font-size: 1.5rem;
    font-weight: 700;
    cursor: pointer;
    padding: 0 0.5rem;
}

.custom-modal-body {
    padding: 1rem;
}

.custom-modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #dee2e6;
    gap: 0.5rem;
}

/* Prevent body scrolling when modal is open */
body.modal-open {
    overflow: hidden;
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

                                    <th class="text-center">ACTION</th>

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
                                                $statusWord = match ($appointment->status) {
                                                    1 => 'Pending',
                                                    2 => 'Approved',
                                                    3 => 'Completed',
                                                    4 => 'Cancelled',
                                                    5 => 'Disapproved',
                                                    default => 'Unknown',
                                                };
                                            @endphp
                                            <span class="badge"
                                                style="background-color: yellow; color: black;font-size:1rem;font-weight:100;width:100px;">{{ $statusWord }}</span>
                                        </td>


                                        <td class="text-center" style="white-space: nowrap; width: 350px;">
                                            <div class="d-flex justify-content-between">
                                                <!-- Show Button -->
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#showModal{{ $appointment->id }}">
                                                    <i class="dw dw-eye"></i> Show
                                                </button>

                                                @if ($appointment->status == 1)
                                                    <!-- Approve Button -->
                                                    <!-- Replace your existing approve button code with this -->
                                                    <button type="button" class="btn btn-success btn-sm" data-approve-btn
                                                        data-appointment-id="{{ $appointment->id }}"
                                                        data-doctor-id="{{ $appointment->doctor_id }}"
                                                        data-date="{{ $appointment->date }}">
                                                        <i class="dw dw-check"></i> Approve
                                                    </button>

                                                    <!-- Disapprove Button -->
                                                    <form action="{{ route('appointments.disapprove', $appointment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-warning btn-sm">
                                                            <i class="dw dw-cancel"></i> Disapprove
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($appointment->status == 2)
                                                    <!-- Cancel Button -->
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger btn-sm cancel-btn">
                                                            <i class="dw dw-trash"></i> Cancel
                                                        </button>
                                                    </form>
                                                @endif
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
    
    <!-- Replace the Bootstrap modal with this custom modal -->
    <div id="customApproveModal" class="custom-modal" style="display: none;">
        <div class="custom-modal-overlay"></div>
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Set Appointment Time</h5>
                <button type="button" class="custom-close-btn" id="closeModalBtn">&times;</button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                @method('PUT')
                <div class="custom-modal-body">
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <input type="hidden" name="doctor_id" id="doctor_id">
                    <div class="form-group mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <select class="form-control" id="start_time" name="start_time" required>
                            <option value="" disabled selected>-- Select Start Time --</option>
                            <!-- Options will be dynamically loaded based on selected doctor -->
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <select class="form-control" id="end_time" name="end_time" required>
                            <!-- Options will be dynamically loaded based on selected doctor -->
                        </select>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelModalBtn">Close</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function () {
        $('#appointmentsTable').DataTable({
            "paging": true,  // Enable pagination
            "ordering": true, // Enable sorting
            "info": true,    // Show table info
           
            "searching": true, // Enable search box
            "lengthMenu": [10, 25, 50, 100], // Customize page length
            "language": {
                "emptyTable": "No data available",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
            }
        });
    });
        // Add this to your script section or JS file
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('customApproveModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const overlay = document.querySelector('.custom-modal-overlay');

            // Store the element that had focus before opening the modal
            let previouslyFocusedElement = null;

            // Function to open the modal
            function openModal() {
                // Store currently focused element
                previouslyFocusedElement = document.activeElement;

                // Show the modal
                modal.style.display = 'block';
                document.body.classList.add('modal-open');

                // Focus the first interactive element in the modal (usually the close button)
                closeBtn.focus();

                // Trap focus inside the modal
                modal.addEventListener('keydown', trapFocus);
            }

            // Function to close the modal
            function closeModal() {
                // Hide the modal
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');

                // Restore focus to the element that had focus before modal was opened
                if (previouslyFocusedElement) {
                    previouslyFocusedElement.focus();
                }

                // Remove the focus trap
                modal.removeEventListener('keydown', trapFocus);
            }

            // Function to trap focus inside the modal
            function trapFocus(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    return;
                }

                if (e.key !== 'Tab') return;

                // Get all focusable elements inside the modal
                const focusableElements = modal.querySelectorAll(
                    'button, select, input:not([type="hidden"]), textarea, [tabindex]:not([tabindex="-1"])');
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                // If shift+tab and focus is on first element, move to last element
                if (e.shiftKey && document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
                // If tab and focus is on last element, move to first element
                else if (!e.shiftKey && document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }

            // Set up event listeners
            document.querySelectorAll('.btn-success[data-approve-btn]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const appointmentId = this.getAttribute('data-appointment-id');
                    const doctorId = this.getAttribute('data-doctor-id');
                    const selectedDate = this.getAttribute('data-date');

                    // Set form action and input values
                    const form = document.getElementById('approveForm');
                    form.action = `/appointments/${appointmentId}/approve`;
                    document.getElementById('appointment_id').value = appointmentId;
                    document.getElementById('doctor_id').value = doctorId;

                    // Populate time slots
                    populateTimeSlots(doctorId, selectedDate, window.availabilities, window
                        .existingAppointments);

                    // Open the modal
                    openModal();
                });
            });

            // Close button event
            closeBtn.addEventListener('click', closeModal);

            // Cancel button event
            cancelBtn.addEventListener('click', closeModal);

            // Close when clicking on overlay
            overlay.addEventListener('click', closeModal);

            // Close when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });
        });

        // Make availabilities and appointments available to the modal script
        window.availabilities = @json($groupedAvailabilities);
        window.existingAppointments = @json($existingAppointments);

        // Keep your existing populateTimeSlots function
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
            const dayName = new Date(selectedDate).toLocaleDateString('en-US', {
                weekday: 'long'
            }).toLowerCase();

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

                console.log('Available Slots:', availableSlots);

                // Populate start time dropdown with available slots
                availableSlots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.toTimeString().slice(0, 5);
                    option.textContent = slot.toTimeString().slice(0, 5);
                    startTimeSelect.appendChild(option);
                });

                // Event for start time selection
                startTimeSelect.addEventListener('change', function() {
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

                    // If end time is still empty, set it to the next available hour
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
    </script>
@endsection
