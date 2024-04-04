@extends('layouts.sidebar')
@section('title', 'Show Doctor')
@section('contents')
    <style>
        .Yes {
            color: red;
        }

        .No {
            color: blue;
        }
    </style>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <a href="{{route('doctor.create')}}" class="btn btn-danger btn-sm scroll-click" ><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-photo">
                                <img src="{{ asset('doc_image/' . $doctor->image) }}" alt="" class="avatar-photo" />
                            </div>
                            <h5 class="text-center h1 mb-0">{{ $doctor->firstname }} {{ $doctor->lastname }}</h5>
                            <p class="text-center text-muted font-20">
                                </strong>{{ $doctor->user_id }}</p>
                            </p>
                            <div class="profile-info">
                                <h1 class="mb-20 h3 text-green">Doctor Informations</h1>
                                <ul>
                                    <li style="font-size: 1.3rem">
                                        <span style="font-size: 1.1rem">Email Address:</span>
                                        {{ $doctor->email }}
                                    </li>
                                    <li style="font-size: 1.3rem">
                                        <span style="font-size: 1.1rem">Phone Number:</span>
                                        {{ $doctor->contact_no }}
                                    </li>
                                    <li style="font-size: 1.3rem">
                                        <span style="font-size: 1.1rem">Address:</span>
                                        {{ $doctor->address }}
                                    </li>
                                    <li style="font-size: 1.3rem">
                                        <span style="font-size: 1.1rem">Expertise:</span>
                                        @foreach ($doctor->services as $service)
                                                {{ $service->name }}@if (!$loop->last), @endif
                                            @endforeach
                                    </li>
                                    <li style="font-size: 1.3rem">
                                        <span style="font-size: 1.1rem">Description:</span>
                                        {{ $doctor->description }}
                                    </li>
                                </ul>
                            </div>

                            <div class="profile-skills">

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#timeline"
                                                role="tab">Schedule</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Timeline Tab start -->
                                        <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                                            <div class="pd-20">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th class="table-plus">Day</th>
                                                            <th class="table-plus">Start Time</th>
                                                            <th>End Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($doctor->availabilities as $availability)
                                                            <tr class="table-light">
                                                                <td>{{ ucfirst($availability->day) }}</td>
                                                                <td>{{ $availability->start_time }}</td>
                                                                <td>{{ $availability->end_time }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                <br>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
