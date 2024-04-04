@extends ('layouts.sidebar')
@section('title', 'Appointment')
@section('contents')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

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
                                        <span class="event-icon weight-400 mr-3"></span><span class="event-title"></span>
                                    </h4>
                                    <div class="event-body"></div>
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
                                <form id="add-event">
                                    <div class="modal-body">
                                        <h4 class="text-blue h4 mb-10">Add Appointment Detail</h4>
                                        <div class="form-group">
                                            <label>Patient Name</label>
                                            <input type="text"
                                                value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                                                class="form-control" name="name" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label>Patient ID</label>
                                            <input type="text" class="datetimepicker form-control" name="edate"
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
                                            <select id="timeSelect" name="time" class="form-control" required>
                                                <option value="">Select time</option>
                                            </select>
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
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var serviceSelect = document.getElementById('serviceSelect');
                var doctorSelect = document.getElementById('doctorSelect');

                serviceSelect.addEventListener('change', function() {
                    console.log('Select element changed');

                    var serviceId = this.value;

                    // Clear existing options
                    doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

                    // Fetch doctors based on the selected service
                    axios.get('/doctors/' + serviceId)
                        .then(function(response) {
                            var doctors = response.data;

                            // Populate doctor select dropdown
                            doctors.forEach(function(doctor) {
                                var option = document.createElement('option');
                                option.value = doctor.id;
                                option.text = doctor.firstname + ' ' + doctor.lastname;
                                doctorSelect.appendChild(option);
                            });
                        })
                        .catch(function(error) {
                            console.error('Error fetching doctors: ' + error);
                        });

                });

                doctorSelect.addEventListener('change', function() {
                    var doctorId = this.value;
                    console.log('Selected doctor ID:', doctorId);

                    // Fetch doctor's availability based on the selected doctor ID
                    axios.get('/doctor-availability/' + doctorId)
                        .then(function(response) {
                            var availability = response.data;
                            console.log('Doctor availability:', availability);
                            // Generate time intervals with one-hour increments
                            var start = new Date('2024-01-01 ' + availability.start_time);
                            var end = new Date('2024-01-01 ' + availability.end_time);
                            var interval = 60 * 60 * 1000; // 1 hour in milliseconds
                            var options = '';

                            for (var time = start.getTime(); time < end.getTime(); time += interval) {
                                var hour = new Date(time).getHours();
                                var minute = new Date(time).getMinutes();
                                var formattedHour = ('0' + hour).slice(-2);
                                var formattedMinute = ('0' + minute).slice(-2);
                                var timeString = formattedHour + ':' + formattedMinute;
                                options += '<option value="' + timeString + '">' + timeString + '</option>';
                            }

                            // Populate time select dropdown with generated time intervals
                            document.getElementById('timeSelect').innerHTML = options;
                        })
                        .catch(function(error) {
                            console.error('Error fetching doctor availability: ' + error);
                        });
                });
            });
        </script>
