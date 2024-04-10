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
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h3>Please Click the Calendar Cell to Book an Appointment</h3>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="calendar-wrap">
                        <div id="calendar"></div>
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
                                            <label>Patient Name</label>
                                            <input type="text"
                                                value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                                                class="form-control" name="name" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="patient_id">Patient ID</label>
                                            <input type="text" class="form-control" name="patient_id" id="patient_id"
                                                value="{{ Auth::user()->id }}" readonly />
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
                                var interval = 60 * 60 * 1000; // 1 hour in milliseconds
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
        </script>
