@extends ('layouts.sidebar')
@section ('contents')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Patient Informations</h4>
                    
                </div>
                <div class="card-box pb-10">
                    <table class="data-table table nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="table-plus">Patient ID</th>
                                <th class="table-plus">Fullname</th>
                                <th>Contact Number</th>
                                <th style="text-align: center">Address</th>
                                <th>Age</th>
                                <th>QR Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1 @endphp 
                            @foreach($patients as $patient)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="txt">
                                            <div class="weight-600" style="color:blue">{{ $patient->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="txt">
                                            <div class="weight-600">{{ $patient->firstname }} {{ $patient->lastname }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $patient->contact_number }}</td>
                                <td>{{ $patient->province }}, {{ $patient->city }}, {{ $patient->barangay }}</td>
                                <td>{{ $patient->age }}</td>
                                <td>
                                    <img src="{{ asset('qr_image/' . $patient->qr_name) }}" alt="QR Code" style="max-width: 100px;">

                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
@endsection
<script src=" {{ asset('src/scripts/jquery.min.js')}}"></script>
