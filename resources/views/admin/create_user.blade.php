@extends ('layouts.sidebar')
@section('title', 'Add Users')
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
                            ADD USER
                        </button>
                        <h4 class="text-blue h4">USERS</h4>
                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table nowrap">
                            <thead> 
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Usertype</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if($user->usertype == 1)
                                            <span>Admin</span>
                                        @elseif($user->usertype == 2)
                                            <span>Doctor</span>
                                        @elseif($user->usertype == 3)
                                            <span>Patient</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('update-user-status', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $user->status == 1 ? 0 : 1 }}">
                                            <button type="submit" class="btn btn-link" style="text-decoration: none;">
                                                @if($user->status == 1)
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
                                               
                                                <form action="{{ route('user.destroy', $user->id) }}"
                                                    method="POST" style="display: inline;"
                                                    id="deleteForm{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                <button type="button" class="dropdown-item delete-btn">
                                                    <i class="dw dw-trash"></i>Delete
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
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>


    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center">User Information</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="multiStepForm" method="POST" action="{{route('user.store')}}"  enctype="multipart/form-data">
                        @csrf
                        <div id="step1">

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Firstname</label>
                                    <div class="form-group">
                                        <input type="text" name="firstname" class="form-control" required>
                                    </div>
                                    <label>Middlename</label>
                                    <div class="form-group">
                                        <input type="text" name="middlename" class="form-control">
                                    </div> 
                                    <label>Lastname</label>
                                    <div class="form-group">
                                        <input type="text" name="lastname" class="form-control">
                                    </div> 
                                    <label>Email</label>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control">
                                    </div> 
                                    <label>Password</label>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <label>User type</label>
                                    <select name="usertype" class="form-control" required>
                                        @if (Auth::user()->usertype == '0')
                                        <option value="1" selected>Admin</option>
                                        @endif
                                    <!-- <option value="2">Doctor</option> -->
                                       
                                    </select>
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
@endsection

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
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('type');
        const hiddenInput = document.querySelector('input[name="type"][type="hidden"]');

        checkbox.addEventListener('change', function () {
            hiddenInput.value = this.checked ? 1 : 0;
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const statusCells = document.querySelectorAll('.user-status');

        statusCells.forEach(cell => {
            cell.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                const newStatus = this.textContent.trim() === 'Active' ? 0 : 1;

                // Send AJAX request to update status
                fetch(`/update-user-status/${userId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Failed to update status');
                })
                .then(data => {
                    // Update UI based on response
                    const badge = data.status === 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    this.innerHTML = badge;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
</script>
