@extends ('layouts.sidebar')
@section('title', 'Add Doctor')
@section('contents')



    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="card-box mb-30">

                    <div class="pd-20">
                        @if (Auth::user()->usertype == '0')
                            <button type="button" class="btn btn-success float-right" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                ADD DOCTOR
                            </button>
                        @endif
                        <h4 class="text-blue h4">Doctors</h4>
                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>CONTACT NUMBER</th>
                                    <th>SERVICE OFFERED</th>
                                    <th>EMAIL</th>
                                    @if (Auth::user()->usertype == '0')
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="table-plus">
                                            <div class="name-avatar d-flex align-items-center">
                                                <div class="avatar mr-2 flex-shrink-0">
                                                    <img src="{{ asset('doc_image/' . $doctor->image) }}"
                                                        class="border-radius-100 shadow" width="40" height="40"
                                                        alt="{{ $doctor->firstname }} {{ $doctor->lastname }}">
                                                </div>
                                                <div class="txt">
                                                    <div class="weight-600">{{ $doctor->firstname }} {{ $doctor->lastname }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $doctor->contact_no }}</td>
                                        <td>
                                            @foreach ($doctor->services as $service)
                                                {{ $service->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                            @if ($doctor->services->isEmpty())
                                                <span style="color:red">Service Not Found</span>
                                            @endif

                                        </td>
                                        <td>{{ $doctor->email }}</td>
                                        @if (Auth::user()->usertype == '0')
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('update-doctor-status', ['id' => $doctor->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status"
                                                        value="{{ $doctor->status == 1 ? 0 : 1 }}">
                                                    <button type="submit" class="btn btn-link"
                                                        style="text-decoration: none;">
                                                        @if ($doctor->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item"
                                                            href="{{ route('doctor.show', ['doctor' => $doctor->id]) }}"><i
                                                                class="dw dw-eye"></i> View</a>
                                                        <!--
                                                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                                                    data-bs-target="#editUserModal{{ $doctor->id }}">
                                                                                    <i class="dw dw-edit2"></i>Edit
                                                                                </button>
                                                                                -->
                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#editAvailabilityModal{{ $doctor->id }}">
                                                            <i class="dw dw-edit2"></i> Edit Availability
                                                        </button>

                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#addRestDayModal{{ $doctor->id }}">
                                                            <i class="dw dw-calendar-1"></i> Add Rest Day
                                                        </button>

                                                        <form action="{{ route('doctor.destroy', $doctor->id) }}"
                                                            method="POST" style="display: inline;"
                                                            id="deleteForm{{ $doctor->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="dropdown-item delete-btn"
                                                                data-user-id="{{ $doctor->id }}">
                                                                <i class="dw dw-delete-3"></i> Delete
                                                                <!-- Example using Bootstrap Icons -->
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    <!-- EDIT AVAILABILITY MODAL -->
                                    <div class="modal fade" id="editAvailabilityModal{{ $doctor->id }}" tabindex="-1"
                                        aria-labelledby="editAvailabilityModalLabel{{ $doctor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="text-center">Edit Availability for Dr.
                                                        {{ $doctor->firstname }} {{ $doctor->lastname }}</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editAvailabilityForm{{ $doctor->id }}" method="POST"
                                                        action="{{ route('doctor.updateAvailability', ['id' => $doctor->id]) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        @foreach ($doctor->availability as $availability)
                                                            <div class="form-group">
                                                                <label for="editDaySelect{{ $availability->id }}">Select
                                                                    Day:</label>
                                                                <select id="editDaySelect{{ $availability->id }}"
                                                                    class="form-control" name="day[]" required>
                                                                    <option value="monday"
                                                                        {{ $availability->day == 'monday' ? 'selected' : '' }}>
                                                                        Monday</option>
                                                                    <option value="tuesday"
                                                                        {{ $availability->day == 'tuesday' ? 'selected' : '' }}>
                                                                        Tuesday</option>
                                                                    <option value="wednesday"
                                                                        {{ $availability->day == 'wednesday' ? 'selected' : '' }}>
                                                                        Wednesday</option>
                                                                    <option value="thursday"
                                                                        {{ $availability->day == 'thursday' ? 'selected' : '' }}>
                                                                        Thursday</option>
                                                                    <option value="friday"
                                                                        {{ $availability->day == 'friday' ? 'selected' : '' }}>
                                                                        Friday</option>
                                                                    <option value="saturday"
                                                                        {{ $availability->day == 'saturday' ? 'selected' : '' }}>
                                                                        Saturday</option>
                                                                    <option value="sunday"
                                                                        {{ $availability->day == 'sunday' ? 'selected' : '' }}>
                                                                        Sunday</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editStartTime{{ $availability->id }}">Start
                                                                    Time:</label>
                                                                <input type="time"
                                                                    id="editStartTime{{ $availability->id }}"
                                                                    name="start_time[]" class="form-control"
                                                                    value="{{ $availability->start_time }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editEndTime{{ $availability->id }}">End
                                                                    Time:</label>
                                                                <input type="time"
                                                                    id="editEndTime{{ $availability->id }}"
                                                                    name="end_time[]" class="form-control"
                                                                    value="{{ $availability->end_time }}" required>
                                                            </div>
                                                        @endforeach

                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- ADD RESTDAY MODAL -->
                                    <div class="modal fade" id="addRestDayModal{{ $doctor->id }}" tabindex="-1"
                                        aria-labelledby="addRestDayModalLabel{{ $doctor->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="text-center">Add Rest Day for Dr. {{ $doctor->firstname }}
                                                        {{ $doctor->lastname }}</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="addRestDayForm{{ $doctor->id }}" method="POST"
                                                        action="{{ route('doctor.addRestDay', ['id' => $doctor->id]) }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="restDay">Select Rest Day:</label>
                                                            <input type="date" name="rest_day" class="form-control"
                                                                required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
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


        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-center">Doctor Information</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="multiStepForm" method="POST" action="{{ route('doctor.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="step1">
                                <!-- Step 1: Personal Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                        <div class="form-group">
                                            <input type="text" name="firstname" class="form-control" required>
                                        </div>
                                        <label>Middle Name</label>
                                        <div class="form-group">
                                            <input type="text" name="middlename" class="form-control">
                                        </div>
                                        <label>Last Name</label>
                                        <div class="form-group">
                                            <input type="text" name="lastname" class="form-control" required>
                                        </div>
                                        <label>Contact number</label>
                                        <div class="form-group">
                                            <input type="text" name="contact_number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control" required>
                                        </div>
                                    
                                        <label>Service Offered</label>
                                        <div class="form-group">
                                            <select name="expertise" class="selectpicker form-control" data-size="5"
                                                data-style="btn-outline-secondary" required>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <label>Email</label>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <label>Password</label>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="description">Short Description</label>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>

                                    <label>Image</label>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary next float-right">Next</button>
                            </div>

                            <div id="step2" style="display: none;">
                                <!-- Step 2: Time Availability -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Day Availability</label>
                                            <select id="daySelect" class="selectpicker form-control" data-size="5"
                                                data-style="btn-outline-secondary" multiple data-actions-box="true"
                                                data-selected-text-format="text" name="day[]" required>
                                                <optgroup label="Days">
                                                    <option value="monday">Monday</option>
                                                    <option value="tuesday">Tuesday</option>
                                                    <option value="wednesday">Wednesday</option>
                                                    <option value="thursday">Thursday</option>
                                                    <option value="friday">Friday</option>
                                                    <option value="saturday">Saturday</option>
                                                    <option value="sunday">Sunday</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="timeInputs" class="col-md-12"></div>

                                    <div id="timeInputsPlaceholder" style="display:none;">
                                        <label>From:</label>
                                        <div class="form-group">
                                            <input type="time" name="sched_in" placeholder="From"
                                                class="form-control">
                                        </div>
                                        <label>To:</label>
                                        <div class="form-group">
                                            <input type="time" name="sched_out" placeholder="To"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary prev">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Previous</span>
                                    </button>
                                    <button type="submit" id="submitButton" class="btn btn-primary ml-1">
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
    @endsection

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#daySelect').on('change', function() {
                $('#timeInputs').empty(); // Clear previously appended time inputs
                $(this).find('option:selected').each(function() {
                    var day = $(this).text();
                    var label = $('<label style="color:green">').text(day + ' Schedule');
                    var fromLabel = $('<br><label style="color:blue">').text('From:');
                    var toLabel = $('<label style="color:red">').text('To:');
                    var inputStart = $('<input>').attr({
                        type: 'time',
                        class: 'form-control',
                        name: 'start_time[]'
                    });
                    var inputEnd = $('<br><input>').attr({
                        type: 'time',
                        class: 'form-control',
                        name: 'end_time[]'
                    });
                    $('#timeInputs').append(label).append(fromLabel).append(inputStart).append(
                        toLabel).append(inputEnd);
                });
            });
        });


        $(document).ready(function() {
            // Event listener for "Next" button
            $('.next').on('click', function() {
                $(this).closest('.modal-body').find('#step1').hide();
                $(this).closest('.modal-body').find('#step2').show();
            });

            // Event listener for "Previous" button
            $('.prev').on('click', function() {
                $(this).closest('.modal-body').find('#step2').hide();
                $(this).closest('.modal-body').find('#step1').show();
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
        document.addEventListener('DOMContentLoaded', function() {
            const statusCells = document.querySelectorAll('.service-status');

            statusCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    const newStatus = this.textContent.trim() === 'Active' ? 0 : 1;

                    // Send AJAX request to update status
                    fetch(`/update-doctor-status/${serviceId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            }
                            throw new Error('Failed to update status');
                        })
                        .then(data => {
                            // Update UI based on response
                            const badge = data.status === 1 ?
                                '<span class="badge badge-success">Active</span>' :
                                '<span class="badge badge-danger">Inactive</span>';
                            this.innerHTML = badge;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
        $(document).ready(function() {
            // Prevent modal from closing on form submission
            $('#submitButton').click(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Trigger form validation
                if ($('#multiStepForm')[0].checkValidity()) {
                    // If form is valid, submit the form
                    $('#multiStepForm').submit();
                } else {
                    // If form is invalid, add validation styling
                    $('#multiStepForm').addClass('was-validated');
                }
            });
        });
    </script>
