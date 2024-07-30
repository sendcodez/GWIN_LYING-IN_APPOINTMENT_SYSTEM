@extends ('layouts.sidebar')
@section('title', 'Appointment')
@section('contents')
    <script>
        var allAppointments = @json($allAppointments);
        var doctorAvailabilities = {!! json_encode($doctorAvailabilities) !!};
        var appointments = {!! json_encode($appointments) !!};
    </script>
    <script src="{{ asset('vendors/scripts/calendar-setting.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .red-day {
            background-color: #ff7b7b !important;
            /* Change background color to red */
            color: white;

            /* Change text color to white */
        }

        .unclick {
            pointer-events: none
        }

        .not-available {
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
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
                        <div class="calendar-wrap col-md-6 col-sm-6">
                            <p>Please Click the Calendar Cell to Book an Appointment</p>
                            <div id="calendar"></div>
                        </div>
                        <!-- Table Section -->
                        <div class="table-wrap col-md-6 col-sm-6">
                            <table class="table table-striped custom-bordered-table">
                                <thead>
                                    <center>
                                        <h3 class="custom-bordered-table">DOCTORS SCHEDULE</h3>
                                    </center>
                                    <select id="serviceFilter" onchange="filterTable()" class="form-control">
                                        <option value="all">All Services</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->name }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>

                                    <tr>
                                        <th>NAME</th>
                                        <th>SERVICE</th>
                                        <th>DAY AVAILABILITY</th>
                                        <th>TIME AVAILABILITY</th>
                                    </tr>
                                </thead>
                                <tbody id="doctorScheduleTable">
                                    @foreach($doctorAvailabilities as $availability)
                                    <tr data-services="@foreach($availability->doctor->services as $service){{ $service->name }}@if(!$loop->last), @endif @endforeach">
                                        <td>{{ $availability->doctor->firstname }} {{ $availability->doctor->lastname }}</td>
                                        <td>
                                            @foreach($availability->doctor->services as $service)
                                                {{ $service->name }}
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $availability->day }}</td>
                                        <td>{{ $availability->start_time }} - {{ $availability->end_time }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
                                <form id="add-event" action="{{ route('calendar.store') }}" method="POST">
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
                                            <label>Patient Name</label>
                                            <input type="text"
                                                value=""
                                                class="form-control" name="name"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="patient_id">Patient ID</label>
                                            <input type="text" class="form-control" name="patient_id" id="patient_id"
                                                value="" />
                                        </div>


                                        <label>Select Service</label>
                                        <div class="form-group">
                                            <select id="serviceSelect" name="service" class="form-control" required>
                                                <option value="">Select Service</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label>Select Doctor</label>
                                        <div class="form-group">
                                            <select id="doctorSelect" name="doctor" class="form-control" required>
                                                <option value="">Select Doctor</option>
                                            </select>
                                        </div>

                                        <label>Select Time</label>
                                        <div class="form-group">
                                            <select id="timeSelect" name="time" id="time" class="form-control"
                                                required>
                                                <option value="">Select time</option>
                                            </select>
                                            <input type="hidden" class="form-control" name="end_time" id="end_time"
                                                value="" readonly />
                                        </div>
                                       
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="remarks" id="remarks"
                                            value="Walk in" readonly />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="status" id="status"
                                            value="2" readonly />
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
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
        @endsection
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            function filterTable() {
                var select = document.getElementById("serviceFilter");
                var filter = select.value;
                var table = document.getElementById("doctorScheduleTable");
                var rows = table.getElementsByTagName("tr");

                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    var services = row.getAttribute("data-services");

                    if (filter === "all" || services.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            }  
            document.addEventListener('DOMContentLoaded', function() {
                var serviceSelect = document.getElementById('serviceSelect');
                var doctorSelect = document.getElementById('doctorSelect');

                serviceSelect.addEventListener('change', function() {
                    var serviceId = this.value;

                    doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

                    // Assuming you have an input field with the ID 'selected_day'
                    var selectedDay = document.getElementById('selected_day').value;

                    axios.get('/doctors/' + serviceId, {
                            params: {
                                selected_day: selectedDay
                            }
                        })
                        .then(function(response) {
                            var doctors = response.data;
                            console.log('Response Data:', doctors);

                            if (Array.isArray(doctors)) {
                                doctors.forEach(function(doctor) {
                                    var option = document.createElement('option');
                                    option.value = doctor.id;
                                    option.text = doctor.firstname + ' ' + doctor.lastname;
                                    doctorSelect.appendChild(option);
                                });
                            } else if (typeof doctors === 'object' && Object.keys(doctors).length > 0) {
                                // Handle object with numeric keys
                                Object.values(doctors).forEach(function(doctor) {
                                    var option = document.createElement('option');
                                    option.value = doctor.id;
                                    option.text = doctor.firstname + ' ' + doctor.lastname;
                                    doctorSelect.appendChild(option);
                                });
                            } else {
                                console.log('No doctors available.');
                            }
                        })
                        .catch(function(error) {
                            console.error('Error fetching doctors: ' + error);
                        });

                });

                doctorSelect.addEventListener('change', function() {
                    var doctorId = this.value;
                    var selectedDate = document.getElementById('selected_date').value;
                    var selectedDay = moment(selectedDate).format('dddd').toLowerCase();

                    axios.get('/doctor-availability/' + doctorId, {
                            params: {
                                day: selectedDay,
                                selected_date: selectedDate // Pass the selected date to the backend
                            }
                        })
                        .then(function(response) {
                            var availability = response.data;

                            // Check if availability data exists
                            if (availability) {
                                var start = new Date('2024-01-01 ' + availability.start_time);
                                var end = new Date('2024-01-01 ' + availability.end_time);
                                var interval = 30 * 60 * 1000; // 30 minutes in milliseconds
                                var options = '';

                                for (var time = start.getTime(); time < end.getTime(); time += interval) {
                                    var hour = new Date(time).getHours();
                                    var minute = new Date(time).getMinutes();
                                    var formattedHour = hour % 12 ||
                                    12; // Convert 24-hour to 12-hour format
                                    var period = hour < 12 ? 'AM' : 'PM'; // Determine AM or PM
                                    var formattedMinute = ('0' + minute).slice(-2);
                                    var timeString = formattedHour + ':' + formattedMinute + ' ' +
                                    period; // Concatenate with AM/PM
                                    var optionValue = ('0' + hour).slice(-2) + ':' +
                                    formattedMinute; // Option value in 24-hour format

                                    // Check if the option value exists in booked or cancelled appointments, if not, add the option
                                    if (!availability.booked_times.includes(optionValue)) {
                                        options += '<option value="' + optionValue + '">' + timeString +
                                            '</option>';
                                    }
                                }
                                if (options === '') {
                                    document.getElementById('selected_date').classList.add('unavailable');
                                    document.getElementById('timeSelect').innerHTML =
                                        '<option value="">No available times</option>';
                                    document.getElementById('end_time').value = ''; // Clear end time field
                                } else {
                                    document.getElementById('selected_date').classList.remove(
                                    'unavailable');
                                    document.getElementById('timeSelect').innerHTML = options;
                                    // Calculate and set the initial end time based on the selected start time
                                    var selectedStartTime = document.getElementById('timeSelect').value;
                                    var selectedEndTime = moment(selectedStartTime, 'HH:mm').add(1, 'hour')
                                        .format('HH:mm');
                                    document.getElementById('end_time').value = selectedEndTime;
                                }
                            } else {
                                console.error('Doctor availability not found');
                            }
                        })
                        .catch(function(error) {
                            console.error('Error fetching doctor availability: ' + error);
                        });
                });


                // Event listener for timeSelect dropdown
                document.getElementById('timeSelect').addEventListener('change', function() {
                    var selectedStartTime = this.value;
                    if (selectedStartTime) {
                        // Calculate the end time to be 1 hour after the selected start time
                        var selectedEndTime = moment(selectedStartTime, 'HH:mm').add(1, 'hour').format('HH:mm');
                        // Set the value of the end time field to the calculated end time
                        document.getElementById('end_time').value = selectedEndTime;
                    } else {
                        // If no time is selected, clear the end time field
                        document.getElementById('end_time').value = '';
                    }
                });
            });

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
        $(document).ready(function() {
            // Prevent modal from closing on form submission
            $('#submitButton').click(function(event) {
                // Prevent default form submission
                event.preventDefault();

            });
        });
        </script>
