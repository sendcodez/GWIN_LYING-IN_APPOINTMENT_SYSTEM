@extends ('layouts.sidebar')
@section('title', 'Add Doctor')
@section('contents')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">

                    <div class="pd-20">
                        <button type="button" class="btn btn-success float-right" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            ADD DOCTOR
                        </button>
                        <h4 class="text-blue h4">Doctors</h4>
                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Expertise</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr>
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
                                        <td>{{ $doctor->expertise }}</td>
                                        <td>{{ $doctor->email }}</td>
                                        <td>{{ $doctor->status }}</td>
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

                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal{{ $doctor->id }}">
                                                        <i class="dw dw-edit2"></i>Edit
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal{{ $doctor->id }}" tabindex="-1"
                        aria-labelledby="editUserModalLabel{{ $doctor->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="text-center">Doctor Information</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit user form -->
                                    <form method="POST" action="{{ route('doctor.update', $doctor->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Form fields pre-filled with existing user data -->
                                        <div id="step1_edit">
                                            <!-- Step 1: Personal Information -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>First name</label>
                                                    <div class="form-group">
                                                        <input type="text" value="{{ $doctor->firstname }}"
                                                            name="firstname" class="form-control" required>
                                                    </div>
                                                    <label>Middle name</label>
                                                    <div class="form-group">
                                                        <input type="text" value="{{ $doctor->middlename }}"
                                                            name="middlename" class="form-control">
                                                    </div>
                                                    <label>Last name</label>
                                                    <div class="form-group">
                                                        <input type="text" name="lastname"
                                                            value="{{ $doctor->lastname }}" class="form-control" required>
                                                    </div>
                                                    <label>Contact number</label>
                                                    <div class="form-group">
                                                        <input type="text" name="contact_number"
                                                            value="{{ $doctor->contact_no }}" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Address</label>
                                                    <div class="form-group">
                                                        <input type="text" name="address" value="{{ $doctor->address }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label>Expertise</label>
                                                    <div class="form-group">
                                                        <input type="text" name="expertise"
                                                            value="{{ $doctor->expertise }}" class="form-control" required>
                                                    </div>
                                                    <label>Email</label>
                                                    <div class="form-group">
                                                        <input type="email" name="email" value="{{ $doctor->email }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label>Password</label>
                                                    <div class="form-group">
                                                        <input type="password" name="password"
                                                            value="{{ $doctor->password }}" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description">Short Description</label>
                                                <div class="form-group">
                                                    <textarea name="description" class="form-control" required>{{ $doctor->description }}</textarea>
                                                </div>

                                                <label>Current Image</label>
                                                <div class="form-group">
                                                    <img src="{{ asset('doc_image/' . $doctor->image) }}"
                                                        class="existing-image" width="100" height="100"
                                                        alt="Current Image">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Upload New Image</label>
                                                <div class="form-group">
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary next2 float-right">Next</button>
                                        </div>



                                        <div id="step2_edit" style="display: none;">
                                            <!-- Step 2: Time Availability -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Day Availability</label>
                                                        <select id="daySelect_edit" class="selectpicker form-control"
                                                            data-size="5" data-style="btn-outline-secondary" multiple
                                                            data-actions-box="true" data-selected-text-format="text"
                                                            name="day[]">
                                                            <optgroup label="Days">
                                                                @php
                                                                    $selectedDays = $doctor->availabilities
                                                                        ->pluck('day')
                                                                        ->toArray();
                                                                @endphp
                                                                <option value="monday"
                                                                    {{ in_array('monday', $selectedDays) ? 'selected' : '' }}>
                                                                    Monday</option>
                                                                <option value="tuesday"
                                                                    {{ in_array('tuesday', $selectedDays) ? 'selected' : '' }}>
                                                                    Tuesday</option>
                                                                <option value="wednesday"
                                                                    {{ in_array('wednesday', $selectedDays) ? 'selected' : '' }}>
                                                                    Wednesday</option>
                                                                <option value="thursday"
                                                                    {{ in_array('thursday', $selectedDays) ? 'selected' : '' }}>
                                                                    Thursday</option>
                                                                <option value="friday"
                                                                    {{ in_array('friday', $selectedDays) ? 'selected' : '' }}>
                                                                    Friday</option>
                                                                <option value="saturday"
                                                                    {{ in_array('saturday', $selectedDays) ? 'selected' : '' }}>
                                                                    Saturday</option>
                                                                <option value="sunday"
                                                                    {{ in_array('sunday', $selectedDays) ? 'selected' : '' }}>
                                                                    Sunday</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="timeInputs_edit" class="col-md-12">
                                                    @foreach ($doctor->availabilities as $availability)
                                                        <label>{{ $availability->day }} Schedule</label>
                                                        <div class="form-group">
                                                            <label>From:</label>
                                                            <input type="time" name="sched_in[]" placeholder="From"
                                                                class="form-control"
                                                                value="{{ $availability->start_time }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>To:</label>
                                                            <input type="time" name="sched_out[]" placeholder="To"
                                                                class="form-control"
                                                                value="{{ $availability->end_time }}">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div id="timeInputsPlaceholder_edit" style="display:none;">
                                                    <!-- This is the placeholder for dynamic time inputs -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary prev_edit float-right">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Previous</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-primary ml-1 float-right"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Submit</span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                </div>


                            </div>
                        </div>

                        </form>
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
                                        <label>First name</label>
                                        <div class="form-group">
                                            <input type="text" name="firstname" class="form-control" required>
                                        </div>
                                        <label>Middle name</label>
                                        <div class="form-group">
                                            <input type="text" name="middlename" class="form-control">
                                        </div>
                                        <label>Last name</label>
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
                                        <label>Expertise</label>
                                        <div class="form-group">
                                            <input type="text" name="expertise" class="form-control" required>
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
                                                data-selected-text-format="text" name="day[]">
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
            $('#daySelect_edit').on('change', function() {
                $('#timeInputs_edit').empty(); // Clear previously appended time inputs
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
                    $('#timeInputs_edit').append(label).append(fromLabel).append(inputStart).append(
                        toLabel).append(inputEnd);
                });
            });
        });


        $(document).ready(function() {
            const step1 = $('#step1');
            const step2 = $('#step2');
            const nextBtn = $('.next');
            const prevBtn = $('.prev');

            // Event listener for "Next" button
            nextBtn.on('click', function() {
                step1.hide();
                step2.show();
            });

            // Event listener for "Previous" button
            prevBtn.on('click', function() {
                step1.show();
                step2.hide();
            });
        });

        $(document).ready(function() {
            const step1_edit = $('#step1_edit');
            const step2_edit = $('#step2_edit');
            const nextBtn_edit = $('.next2');
            const prevBtn_edit = $('.prev_edit');

            // Event listener for "Next" button
            nextBtn_edit.on('click', function() {
                step1_edit.hide();
                step2_edit.show();
            });

            // Event listener for "Previous" button
            prevBtn_edit.on('click', function() {
                step1_edit.show();
                step2_edit.hide();
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
    </script>
    </script>
