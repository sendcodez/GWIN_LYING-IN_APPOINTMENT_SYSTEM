@extends ('layouts.sidebar')
@section('title', 'Appointment')
@section('contents')
    <script>
        var allAppointments = @json($allAppointments);
        var doctorAvailabilities = {!! json_encode($doctorAvailabilities) !!};
        var appointments = {!! json_encode($appointments) !!};
        var restDays = @json($restDays);
        var allRestDays = {!! json_encode($rd) !!};
        console.log("Rest Days for selected doctor:", restDays);
        console.log("All Rest Days:", allRestDays);

        // Log doctor and their rest days in the frontend as well
        allRestDays.forEach(function(restDayEntry) {
            console.log("Doctor: " + restDayEntry.doctor_id + ", Rest Days: " + restDayEntry.rest_day);
        });
    </script>

    <script src="{{ asset('vendors/scripts/calendar-setting.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @media (max-width: 768px) {
            .custom-bordered-table {
                font-size: 14px;
            }


            .table-responsive {
                overflow-x: auto;
            }

            th,
            td {
                position: relative;
                /* Position cells relative for absolute children */
                overflow: hidden;
                /* Prevent overflow */
            }

            /* Style for not-available text */
            .not-available {
                font-weight: bold;
                position: absolute;
                /* Change to absolute positioning */
                z-index: 2;
                /* Ensure it stays on top */
                top: 50%;
                /* Center vertically */
                left: 50%;
                /* Center horizontally */
                transform: translate(-50%, -50%);
                /* Move to the middle of the cell */
                color: white;
                /* Text color */

                padding: 2px 5px;
                /* Optional: padding around the text */
                border-radius: 3px;
                /* Optional: rounded corners */
                pointer-events: none;
                /* Prevent mouse interactions */
                white-space: nowrap;
                /* Prevent text wrapping */
                max-width: 100%;
                /* Prevent overflow beyond the cell */

            }
        }

        .red-day {
            background-color: #ff7b7b !important;
            /* Change background color to red */
            color: white;
            /* Change text color to white */
        }

        .past-date {
            background-color: #d3d3d3 !important;
            /* Light grey background */
            color: #666666;
            /* Dark grey text color */
            transform: scale(.9);
            /* Shrinks the size of the cell to 80% of its original size */
            transition: transform 0.12s ease;
            /* Smooth transition for visual appeal */
            opacity: 1;
            /* Make the past date less prominent */
            pointer-events: none;
        }

        .unclick {
            pointer-events: none;
        }


        .date {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            /* Optional: Add margin for spacing */
        }

        /* Adjust spacing between input fields */
        .form-group input[type="date"] {
            margin-right: 10px;
            /* Optional: Add margin to separate the input fields */

        }
    </style>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="pd-20 card-box mb-30">
                    <div class="row">
                        <!-- Calendar Section -->
                        <div class="calendar-wrap col-md-6 col-sm-6 custom-bordered-table">
                            <select id="serviceFilter" onchange="filterTable(); refreshCalendar();" class="form-control mb-3">
                                @foreach ($doctors as $doctor)
                                    @php
                                        $service = $doctor->services->first()->name; // Assuming each doctor has only one service
                                    @endphp
                                    <option value="{{ $doctor->id }}">
                                        Dr. {{ $doctor->lastname }} ( {{ $doctor->gender }} ) | Service Offered:
                                        {{ $service }}
                                    </option>
                                @endforeach
                            </select>
                            <!--
                                    <p>Please Click the Calendar Cell to Book an Appointment</p>
                                    <p>Please refer to the availability of doctors and services before scheduling</p>
                                    <b> SCHEDULE POLICIES</b>
                                    <p style="text-align:justify;font-size:.9rem;">

                                        1.<b> Appointment Booking</b>
                                        <br>
                                        Appointments can be booked online or through our office during business hours.
                                        <br>
                                        2. <b>Late Arrival</b>
                                        <br>
                                        Patients are requested to arrive at least 10 minutes before their scheduled appointment
                                        time. Late arrivals may result in a shortened appointment or rescheduling, depending on
                                        availability.
                                        <br>
                                        3. <b>Policy Changes</b>
                                        <br>
                                        The schedule policy is subject to change. Any changes will be communicated to patients
                                        through email or posted on our website.
                                        <br>
                                        4. <b>Contact Information</b>
                                        <br>
                                        For any questions regarding this policy or to make changes to your appointment, please
                                        contact our office at gwinlying@gmail.com.
                                    </p>
                                     -->
                            <div id="calendar" style="font-size:.8rem;"></div>
                        </div>

                        <!-- Table Section -->

                        <div class="table-wrap col-md-6 col-sm-6">

                            <div class="table-responsive">
                                <table class="table custom-bordered-table">
                                    <thead>
                                        <center>
                                            <h3 class="custom-bordered-table">DOCTORS SCHEDULE</h3>
                                        </center>
                                        <!--
                                                <select id="serviceFilter" onchange="filterTable(); refreshCalendar();" class="form-control mb-3">
                                                    @foreach ($doctors as $doctor)
    @php
        $service = $doctor->services->first()->name; // Assuming each doctor has only one service
    @endphp
                                                        <option value="{{ $doctor->id }}">
                                                            Dr. {{ $doctor->lastname }} | Service Offered: {{ $service }}
                                                        </option>
    @endforeach
                                                </select>
                                            -->
                                        <tr>
                                            <th>DAY AVAILABILITY</th>
                                            <th>TIME AVAILABILITY</th>
                                            <th class="text-center">REST DAY</th>
                                        </tr>
                                    </thead>
                                    <tbody id="doctorScheduleTable">
                                        @foreach ($doctorAvailabilities as $index => $availability)
                                            @php
                                                $doctor = $availability->doctor;
                                                $service = $doctor ? $doctor->services->first()->name : 'No service'; // Single service per doctor

                                                $currentDate = now();
                                                $nextRestDay = $rd
                                                    ->where('doctor_id', $doctor->id)
                                                    ->filter(function ($restDay) use ($currentDate) {
                                                        return $restDay->rest_day > $currentDate;
                                                    })
                                                    ->sortBy('rest_day')
                                                    ->first();
                                            @endphp
                                            @if ($doctor && ($index == 0 || $doctor->id != $doctorAvailabilities[$index - 1]->doctor_id))
                                                <tr data-filter="{{ $doctor->id }}">
                                                    <td>{{ ucfirst($availability->day) }}</td>
                                                    <td>
                                                        {{ date('h:i A', strtotime($availability->start_time)) }} -
                                                        {{ date('h:i A', strtotime($availability->end_time)) }}
                                                    </td>
                                                    <td class="rest-day"
                                                        rowspan="{{ $doctorAvailabilities->where('doctor_id', $doctor->id)->count() }}">
                                                        @if ($nextRestDay)
                                                            {{ is_string($nextRestDay) ? $nextRestDay : $nextRestDay->rest_day->format('M d, Y') }}
                                                        @else
                                                            No upcoming rest days
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                <tr data-filter="{{ $doctor->id }}">
                                                    <td>{{ ucfirst($availability->day) }}</td>
                                                    <td>
                                                        {{ date('h:i A', strtotime($availability->start_time)) }} -
                                                        {{ date('h:i A', strtotime($availability->end_time)) }}
                                                    </td>
                                                    <!-- Empty rest day cell to avoid repetition -->
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>



                            <br>
                            <hr>
                            <vr> 
                        </div>
                    </div>

                    <!-- calendar modal -->
                    <div id="modal-view-event" class="modal modal-top fade calendar-modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4 class="h4">
                                        <span class="event-title"></span>
                                    </h4>
                                    <p><strong>Doctor:</strong> <span class="doctor-name"></span></p>
                                    <p><strong>Service:</strong> <span class="service"></span></p>
                                    <p><strong>Date:</strong> <span class="date"></span></p>
                                    <p><strong>Time:</strong> <span class="time"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="add-event" action="{{ route('appointments.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <h4 class="text-blue h4 mb-10">Add Appointment Detail</h4>
                                        <label>Date&nbsp</label>
                                        <div class="form-group date">

                                            <input type="date" class="form-control" name="selected_date"
                                                id="selected_date" value="" readonly />
                                            <!-- Place "Selected Day" input field here -->
                                            <input type="text" class="form-control" name="selected_day" id="selected_day"
                                                value="" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="patient_id">Patient ID</label>
                                            <input type="text" class="form-control" name="patient_id" id="patient_id" value="" />
                                        </div>
                                        <div class="form-group">
                                            <label>Patient Name</label>
                                            <input type="text" value="" class="form-control" name="name" id="patient_name" readonly />
                                        </div>

                                        <!-- <label>Select Service</label>
                                                        <div class="form-group">
                                                            <select id="serviceSelect" name="service[]" class="selectpicker form-control"
                                                                data-size="5" data-style="btn-outline-secondary" multiple
                                                                data-max-options="3" required>

                                                                @foreach ($services as $service)
    <option value="{{ $service->id }}">{{ $service->name }}</option>
    @endforeach
                                                            </select>
                                                        </div>
                                                    -->
                                        <div class="form-group">
                                            <label>Service</label>
                                            <input type="text" class="form-control" name="service_name"
                                                id="serviceText" readonly />
                                            <input type="hidden" name="service" id="serviceValue" />
                                        </div>

                                        <!-- Replace the doctor dropdown with text field -->
                                        <div class="form-group">
                                            <label>Doctor</label>
                                            <input type="text" class="form-control" name="doctor_name"
                                                id="doctorText" readonly />
                                            <input type="hidden" name="doctor" id="doctorValue" />
                                        </div>

                                        <!--   <label>Select Time</label>
                                                                            <div class="form-group">
                                                                                <select id="timeSelect" name="time" id="time" class="form-control"
                                                                                    required>
                                                                                    <option value="">Select time</option>
                                                                                </select>
                                                                                <input type="hidden" class="form-control" name="end_time" id="end_time"
                                                                                    value="" readonly />
                                                                            </div>
                                                                        -->
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="remarks" id="remarks"
                                                value="Online" readonly />
                                        </div>

                                        <div class="form-group" id="referralCheckboxContainer" style="display: none;">
                                            <input type="checkbox" id="referralCheckbox" name="referral_used">
                                            <label for="referralCheckbox">Referral</label>
                                        </div>
                                         
                                        <div class="form-group">
                                            <input type="checkbox" id="policyCheckbox">
                                            <label for="policyCheckbox">I agree to the <a href="#"
                                                    data-toggle="modal" data-target="#modal-schedule-policy"><span
                                                        style="color:blue">schedule
                                                        policy</span></a></label>
                                        </div>
                                 

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="saveButton">
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Schedule Policy -->
            <div id="modal-schedule-policy" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Schedule Policy</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Your policy content goes here -->


                            <p>

                                1.<b> Appointment Booking</b>
                                <br>
                                Appointments can be booked online or through our office during business hours.
                                <br>
                                2. <b>Late Arrival</b>
                                <br>
                                Patients are requested to arrive at least 10 minutes before their scheduled appointment
                                time. Late arrivals may result in a shortened appointment or rescheduling, depending on
                                availability.
                                <br>
                                3. <b>Policy Changes</b>
                                <br>
                                The schedule policy is subject to change. Any changes will be communicated to patients
                                through email or posted on our website.
                                <br>
                                4. <b>Contact Information</b>
                                <br>
                                For any questions regarding this policy or to make changes to your appointment, please
                                contact our office at gwinlying@gmail.com.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            // Function to filter the doctor schedule table based on selected services
            function filterTable() {
                const select = document.getElementById("serviceFilter");
                const filter = select.value.toLowerCase(); // Convert to lowercase for case-insensitive matching
                const table = document.getElementById("doctorScheduleTable");
                const rows = table.getElementsByTagName("tr");

                // Filter rows based on the selected doctor
                Array.from(rows).forEach(row => {
                    const dataFilter = row.getAttribute("data-filter").toLowerCase();
                    if (filter === "all" || dataFilter.includes(filter)) {
                        row.style.display = ""; // Show the row
                    } else {
                        row.style.display = "none"; // Hide the row
                    }
                });

                // Refresh the calendar when the filter is applied
                refreshCalendar();
            }


            // Function to fetch doctors based on selected services and date
            function fetchDoctors() {
                const serviceSelect = document.getElementById('serviceSelect');
                const doctorSelect = document.getElementById('doctorSelect');
                const selectedDateInput = document.getElementById('selected_date');
                const selectedDayInput = document.getElementById('selected_day');

                const selectedServices = Array.from(serviceSelect.selectedOptions).map(option => option.value);
                const selectedDate = selectedDateInput.value;
                const selectedDay = moment(selectedDate).format('dddd').toLowerCase();

                selectedDayInput.value = selectedDay;

                axios.get('/doctors', {
                        params: {
                            services: selectedServices,
                            selected_day: selectedDay,
                            selected_date: selectedDate
                        }
                    })
                    .then(response => {
                        const doctors = response.data;
                        doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
                        if (Array.isArray(doctors)) {
                            doctors.forEach(doctor => {
                                const option = document.createElement('option');
                                option.value = doctor.id;
                                option.text = `${doctor.firstname} ${doctor.lastname}`;
                                doctorSelect.appendChild(option);
                            });
                        } else {
                            console.log('No doctors available.');
                        }
                    })
                    .catch(error => console.error('Error fetching doctors:', error));
            }

            // Function to fetch doctor availability based on selected doctor and date
            function fetchDoctorAvailability() {
                const doctorSelect = document.getElementById('doctorSelect');
                const selectedDate = document.getElementById('selected_date').value;
                const selectedDay = moment(selectedDate).format('dddd').toLowerCase();

                const doctorId = doctorSelect.value;

                axios.get(`/doctor-availability/${doctorId}`, {
                        params: {
                            day: selectedDay,
                            selected_date: selectedDate
                        }
                    })
                    .then(response => {
                        const availability = response.data;

                        if (availability) {
                            const start = new Date(`2024-01-01 ${availability.start_time}`);
                            const end = new Date(`2024-01-01 ${availability.end_time}`);
                            const interval = 30 * 60 * 1000; // 30 minutes in milliseconds
                            let options = '';

                            for (let time = start.getTime(); time < end.getTime(); time += interval) {
                                const date = new Date(time);
                                const hour = date.getHours();
                                const minute = date.getMinutes();
                                const formattedHour = hour % 12 || 12;
                                const period = hour < 12 ? 'AM' : 'PM';
                                const formattedMinute = (`0${minute}`).slice(-2);
                                const timeString = `${formattedHour}:${formattedMinute} ${period}`;
                                const optionValue = (`0${hour}`).slice(-2) + ':' + formattedMinute;

                                if (!availability.booked_times.includes(optionValue)) {
                                    options += `<option value="${optionValue}">${timeString}</option>`;
                                }
                            }

                            const timeSelect = document.getElementById('timeSelect');
                            const endTimeInput = document.getElementById('end_time');
                            if (options === '') {
                                selectedDateInput.classList.add('unavailable');
                                timeSelect.innerHTML = '<option value="">No available times</option>';
                                endTimeInput.value = '';
                            } else {
                                selectedDateInput.classList.remove('unavailable');
                                timeSelect.innerHTML = options;
                                updateEndTime();
                            }
                        } else {
                            console.error('Doctor availability not found');
                        }
                    })
                    .catch(error => console.error('Error fetching doctor availability:', error));
            }

            // Function to update end time based on selected start time
            function updateEndTime() {
                const timeSelect = document.getElementById('timeSelect');
                const endTimeInput = document.getElementById('end_time');
                const selectedStartTime = timeSelect.value;

                if (selectedStartTime) {
                    const selectedEndTime = moment(selectedStartTime, 'HH:mm').add(1, 'hour').format('HH:mm');
                    endTimeInput.value = selectedEndTime;
                } else {
                    endTimeInput.value = '';
                }
            }

            // Event listeners
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('serviceSelect').addEventListener('change', fetchDoctors);
                document.getElementById('doctorSelect').addEventListener('change', fetchDoctorAvailability);
                document.getElementById('timeSelect').addEventListener('change', updateEndTime);

                // Modal handling
                $(document).ready(function() {
                    $('#addUserModal .close, .modal .close').click(function() {
                        $(this).closest('.modal').modal('hide');
                    });
                });

                // Dropdown item modal trigger
                document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const modalId = this.getAttribute('data-bs-target');
                        const modal = document.querySelector(modalId);
                    });
                });

                // Status filter
                $('#statusFilter').change(function() {
                    const status = $(this).val();
                    const rows = $('#appointmentsTable tbody tr');
                    rows.show();
                    if (status) {
                        rows.not(':contains(' + status + ')').hide();
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const restDayCells = document.querySelectorAll('.rest-day');
                restDayCells.forEach(cell => {
                    cell.classList.add('red-day');
                });
            });
            /*
            document.addEventListener('DOMContentLoaded', (event) => {
                const policyCheckbox = document.getElementById('policyCheckbox');
                const saveButton = document.getElementById('saveButton');

                policyCheckbox.addEventListener('change', () => {
                    saveButton.disabled = !policyCheckbox.checked;
                });
            });
            */
            $(document).ready(function() {
                $('#appointmentsTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                });
            });


            // Add this code to your page, either in a <script> tag at the bottom 
            // or by modifying your calendar-setting.js file

            document.addEventListener('DOMContentLoaded', function() {
                // Function to populate form fields from the selected filter
                function populateFormFromFilter() {
                    // Get the selected doctor from the filter
                    const serviceFilterSelect = document.getElementById('serviceFilter');
                    if (!serviceFilterSelect) {
                        console.error('Service filter select not found');
                        return;
                    }

                    const selectedDoctorId = serviceFilterSelect.value;
                    const selectedOption = serviceFilterSelect.options[serviceFilterSelect.selectedIndex];
                    const optionText = selectedOption ? selectedOption.text : '';

                    // Extract doctor name and service from the option text
                    // Format is typically: "Dr. LastName ( Gender ) | Service Offered: ServiceName"
                    const doctorMatch = optionText.match(/Dr\. ([^\(]+)/);
                    const serviceMatch = optionText.match(/Service Offered: (.*?)(?:\)|$)/);

                    const doctorName = doctorMatch ? doctorMatch[1].trim() : '';
                    const serviceName = serviceMatch ? serviceMatch[1].trim() : '';

                    console.log('Extracted - Doctor:', doctorName, 'Service:', serviceName);

                    // Get references to the text fields
                    const serviceText = document.getElementById('serviceText');
                    const serviceValue = document.getElementById('serviceValue');
                    const doctorText = document.getElementById('doctorText');
                    const doctorValue = document.getElementById('doctorValue');
                    const referralCheckboxContainer = document.getElementById('referralCheckboxContainer');

                    // Set the visible text fields
                    if (serviceText) serviceText.value = serviceName;
                    if (doctorText) doctorText.value = 'Dr.' + ' ' + doctorName;

                    // Set the hidden value fields
                    if (serviceValue && services) {
                        // Find the service ID by name from your services data
                        const service = services.find(s => s.name === serviceName);
                        serviceValue.value = service ? service.id : '';

                        // Check if the service has referral and show/hide the checkbox
                        if (service && referralCheckboxContainer) {
                            // Find if the doctor offers this service with referral
                            const hasReferral = doctors.some(doctor =>
                                doctor.id == selectedDoctorId &&
                                doctor.services.some(s =>
                                    s.id == service.id && s.referral
                                )
                            );

                            // Show/hide the referral checkbox based on whether referral is available
                            referralCheckboxContainer.style.display = hasReferral ? 'block' : 'none';

                            // You can also set a hidden field for referral status if needed
                            const hasReferralField = document.getElementById('hasReferral');
                            if (hasReferralField) {
                                hasReferralField.value = hasReferral ? '1' : '0';
                            }
                        }
                    }

                    if (doctorValue) doctorValue.value = selectedDoctorId;
                }

                // When the modal is opened, populate the form fields
                $('#modal-view-event-add').on('show.bs.modal', function() {
                    populateFormFromFilter();
                });

                // When the service filter changes, update the form if modal is open
                const serviceFilterSelect = document.getElementById('serviceFilter');
                if (serviceFilterSelect) {
                    serviceFilterSelect.addEventListener('change', function() {
                        if ($('#modal-view-event-add').is(':visible')) {
                            populateFormFromFilter();
                        }
                    });
                }

                // Make the service and doctor variables available globally
                // You'll need to add this to your Blade template where you define other variables
                var services = @json($services);
                var doctors = @json($doctors);
            });
            document.addEventListener("DOMContentLoaded", function() {
    const policyCheckbox = document.getElementById("policyCheckbox");
    const saveButton = document.getElementById("saveButton");
    const referralCheckbox = document.getElementById("referralCheckbox");
    const referralCheckboxContainer = document.getElementById("referralCheckboxContainer");

    if (policyCheckbox && saveButton) {
        // Initially disable the Save button
        saveButton.disabled = true;

        // Function to check if the save button should be enabled
        function updateSaveButtonState() {
            // Policy checkbox must always be checked
            let shouldEnable = policyCheckbox.checked;
            
            // If referral is visible, it must also be checked
            if (referralCheckboxContainer && 
                referralCheckbox && 
                referralCheckboxContainer.style.display !== 'none') {
                shouldEnable = shouldEnable && referralCheckbox.checked;
            }
            
            // Update button state
            saveButton.disabled = !shouldEnable;
        }

        // Add event listeners to both checkboxes
        policyCheckbox.addEventListener("change", updateSaveButtonState);
        
        if (referralCheckbox) {
            referralCheckbox.addEventListener("change", updateSaveButtonState);
        }
        
        // Also check when the referral container visibility changes
        // Create a mutation observer to monitor changes to the referral container display style
        if (referralCheckboxContainer) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "style") {
                        updateSaveButtonState();
                    }
                });
            });
            
            observer.observe(referralCheckboxContainer, { attributes: true });
        }
        
        // Initial check
        updateSaveButtonState();
    }
});
$(document).ready(function() {
    $('#patient_id').on('input', function() {
        var userId = $(this).val(); // Use userId to search
        if (userId) {
            $.ajax({
                url: '/get-patient/' + userId,
                type: 'GET',
                success: function(response) {
                    if (response.name) {
                        $('#patient_name').val(response.name);
                    } else {
                        $('#patient_name').val('Patient not found');
                    }
                },
                error: function() {
                    $('#patient_name').val('Patient not found');
                }
            });
        } else {
            $('#patient_name').val('');
        }
    });
});
        </script>
