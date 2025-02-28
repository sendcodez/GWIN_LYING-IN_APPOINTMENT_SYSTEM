@extends('layouts.sidebar')
@section('title', 'Disapproved Appointments')
@section('contents')
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Appointments</h4>
                </div>
                
                <div class="card-box pb-10">
                    <table class="data-table table nowrap" id="appointmentsTable">
                        <thead>
                            <tr>
                               <!-- <th>#</th>-->
                               <th>DATE</th>
                                <th>PATIENT NAME</th>
                                <th>DOCTOR NAME</th>
                                <th>SERVICE</th>
                               
                                <th>TIME</th>
                               <!--  <th class="text-center">MODE OF APPOINTMENT</th> -->
                                <th>STATUS</th>
                                <th>ACTION</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $appointment)
                                <tr>
                                   <!-- <td>{{ $key + 1 }}</td>-->
                                   <td>{{ $appointment->date }}</td>
                                    <td>{{ ucfirst($appointment->patient->firstname) }} {{ ucfirst($appointment->patient->lastname) }}</td>
                                    <td>
                                        @if($appointment->doctor && $appointment->doctor->lastname)
                                            Dr. {{ ucfirst($appointment->doctor->lastname) }}
                                        @else
                                            <span style="color:red">Doctor Not Found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->services->isNotEmpty())
                                            @foreach($appointment->services as $service)
                                                {{ $service->name }}@if(!$loop->last), @endif
                                            @endforeach
                                        @else
                                            <span style="color:red">Service Not Found</span>
                                        @endif
                                    </td>
                              
                                    <td>{{ date('h:i A', strtotime($appointment->start_time)) }}</td>
                                   <!-- <td class="text-center">{{ $appointment->remarks }}</td> -->
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
                                    <span class="badge" style="background-color: red; color: white;">{{ $statusWord }}</span>
                                </td>
                                
                                   
                                    <td class="text-center" style="white-space: nowrap;">
                                        <!-- Show Button -->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showModal{{ $appointment->id }}" title="Show">
                                            <i class="dw dw-eye"></i> Show
                                        </button>
                                    
                                        @if ($appointment->status == 1)
                                            <!-- Approve Button -->
                                            <form action="{{ route('appointments.approve', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                    <i class="dw dw-check"></i> Approve
                                                </button>
                                            </form>
                                        @endif
                                    
                                        @if ($appointment->status == 2)
                                            <!-- Cancel Button -->
                                            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm cancel-btn" title="Cancel">
                                                    <i class="dw dw-trash"></i> Cancel
                                                </button>
                                            </form>
                                        @endif
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
                                                    @if($appointment->doctor && $appointment->doctor->firstname && $appointment->doctor->lastname)
                                                        Dr. {{ $appointment->doctor->firstname }} {{ ucfirst($appointment->doctor->lastname) }}
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
                                                            case 5:
                                                                echo '<span class="badge badge-warning">Disapproved</span>';
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
        $('#statusFilter').change(function() {
        var status = $(this).val();
        $('#appointmentsTable tbody tr').show(); // Show all rows
        if (status) {
            $('#appointmentsTable tbody tr').not(':contains(' + status + ')').hide(); // Hide rows not matching selected status
        }
    });
    </script>
@endsection
