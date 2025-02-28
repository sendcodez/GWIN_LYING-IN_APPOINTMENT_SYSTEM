@extends ('layouts.sidebar')
@section('title', 'Add Services')
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
                            ADD SERVICE
                        </button>
                        <h4 class="text-blue h4">Services</h4>
                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table nowrap">
                            <thead> 
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>PRICE</th>
                                    <th>DESCRIPTION</th>
                                    <th>PACKAGE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->price}}</td>
                                    <td>{{$service->description}}</td>
                                    <td>
                                        @if($service->type == 1)
                                            <span>Yes</span>
                                        @else
                                            <span>No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('update-service-status', ['id' => $service->id]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $service->status == 1 ? 0 : 1 }}">
                                            <button type="submit" class="btn btn-link" style="text-decoration: none;">
                                                @if($service->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                                                  
                                    
                                    <td class="text-center">
                                        <form action="{{ route('service.destroy', $service->id) }}" method="POST" id="deleteForm{{ $service->id }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" title="Delete">
                                                <i class="dw dw-trash"></i> Delete
                                            </button>
                                        </form>
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
                    <h3 class="text-center">Service Information</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="multiStepForm" method="POST" action="{{ route('service.store') }}"  enctype="multipart/form-data">
                        @csrf
                        <div id="step1">

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Service Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                            
                                    <label>Price</label>
                                    <div class="form-group">
                                        <input type="number" name="price" class="form-control">
                                    </div> 
                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="type" id="type" value="1">
                                                <label class="form-check-label" for="type">Package</label>
                                                <input type="hidden" name="type" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="referral" id="referral" value="1">
                                                <label class="form-check-label" for="referral">Referral</label>
                                                <input type="hidden" name="referral" value="0">
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="form-group mt-3">
                                        <label>Short Description</label>
                                        <textarea class="form-control" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-block">Reset</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-block">Submit</span>
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
        const statusCells = document.querySelectorAll('.service-status');

        statusCells.forEach(cell => {
            cell.addEventListener('click', function () {
                const serviceId = this.getAttribute('data-service-id');
                const newStatus = this.textContent.trim() === 'Active' ? 0 : 1;

                // Send AJAX request to update status
                fetch(`/update-service-status/${serviceId}`, {
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
