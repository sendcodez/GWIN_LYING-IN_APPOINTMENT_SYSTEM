@extends ('layouts.sidebar')
@section('title', 'Dashboard')
@section('contents')

    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="title pb-20">
                <h2 class="h3 mb-0">Clinic Overview</h2>
            </div>

            <div class="row pb-10">
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $totalAppointments }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Appointments
                                </div>
                            </div>
                            <div class="widget-icon" style="background-color:#B0EBB4">
                                <div class="icon" data-color="#00eccf">
                                    <i class="icon-copy dw dw-calendar1" style="color:black" ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $totalPatients }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Profiled Patient
                                </div>
                            </div>
                            <div class="widget-icon" style="background-color:#B0EBB4">
                                <div class="icon" data-color="#ff5b5b">
                                    <span class="icon-copy ti-heart" style="color:black"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $totalDoctors }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Doctors
                                </div>
                            </div>
                            <div class="widget-icon" style="background-color:#B0EBB4">
                                <div class="icon">
                                    <i class="icon-copy fa fa-stethoscope" aria-hidden="true" style="color:black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">P {{ $totalEarnings }}</div>
                                <div class="font-14 text-secondary weight-500">Earning</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#09cc06">
                                    <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            -->
            </div>
            <div class="card-box pb-10">
                <div class="h5 pd-20 mb-0">Recent Patient</div>
                <table class="data-table table nowrap">
                    <thead>
                        <tr>
                            
                            <th>PATIENT NAME</th>
                            <th>DOCTOR ASSIGNED</th>
                            <th>SERVICE</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completedAppointments as $key => $appointment)
                            <tr>
                               
                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="txt">
                                            <div class="weight-600">{{ $appointment->patient->firstname }}
                                                {{ $appointment->patient->lastname }}</div>
                                            <span class="text-muted">User ID: {{ $appointment->patient->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($appointment->doctor && $appointment->doctor->lastname)
                                        Dr. {{ ucfirst($appointment->doctor->lastname) }}
                                    @else
                                        <span style="color:red">Doctor Not Found</span>
                                    @endif
                                </td>

                                <td>
                                    @if($appointment->services && $appointment->services->count() > 0)
                                        @foreach($appointment->services as $service)
                                            {{ $service->name }}<br>
                                        @endforeach
                                    @else
                                        <span style="color:red">Service Not Found</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->date }}</td>
                               
                                <td>
                                    <span class="badge badge-primary">Completed</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endsection
