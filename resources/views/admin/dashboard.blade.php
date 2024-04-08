@extends('layouts.sidebar')
@section('title', 'Welcome')
@section('contents')

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box pd-20 height-100-p mb-30">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="vendors/images/banner-img.png" alt="" />
                    </div>
                    <div class="col-md-8">
                        <h4 class="font-20 weight-500 mb-10 text-capitalize">
                            Welcome back
                            <div class="weight-600 font-30 text-blue"> @if (Auth::user()->usertype == 2)Dr. @endif{{ Auth::user()->firstname }}
                                {{ Auth::user()->lastname }}</div>
                            @if (Auth::user()->usertype == 3)
                                <h5>{{ Auth::user()->id }}</h5>
                                <p class="font-12 max-width-600">Patient ID </p>
                                <a href="{{ asset('qr_image/' . Auth::user()->qr_name) }}" download>
                                    <img src="{{ asset('qr_image/' . Auth::user()->qr_name) }}" alt="QR Code"
                                        style="float: right; margin-right:90px;margin-bottom:3%; margin-top:-10%; max-width: 150px;">
                                </a>
                            @endif
                        </h4>
                        <p class="font-18 max-width-600">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde
                            hic non repellendus debitis iure, doloremque assumenda. Autem
                            modi, corrupti, nobis ea iure fugiat, veniam non quaerat
                            mollitia animi error corporis.
                        </p>
                    </div>
                </div>
            </div>

            @if (Auth::user()->usertype == 3)
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">My Recent Appointments</h4>
                </div>
                <div class="card-box pb-10">
                    <table class="data-table table nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doctor Name</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $appointment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>Dr. {{ $appointment->doctor->lastname }}</td>
                                    <td>{{ $appointment->service->name }}</td>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ $appointment->start_time }}</td>
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

                                                @if ($appointment->status == 1 || $appointment->status == 2)
                                                    <form action="{{ route('appointments.cancel', $appointment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="dropdown-item delete-btn">
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
                                                <p><strong>Doctor Name:</strong> Dr. {{ $appointment->doctor->firstname }} {{ $appointment->doctor->lastname }}
                                                </p>
                                                <p><strong>Service:</strong> {{ $appointment->service->name }}</p>
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
        document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                console.log('Show button clicked');
                const modalId = this.getAttribute('data-bs-target');
                console.log('Modal ID:', modalId);
                const modal = document.querySelector(modalId);
                console.log('Modal Element:', modal);
            });
        });
    </script>
    @endif
@endsection
