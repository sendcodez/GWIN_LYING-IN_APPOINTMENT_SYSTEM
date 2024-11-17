@extends('layouts.sidebar')
@section('title', 'Reports')
@section('contents')
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Appointments</h4>
                </div>

                <div class="card-box pb-10">
                    <div class="col-md-6 col-sm-6">
                        <form method="POST" action="{{ route('reports.filter') }}">
                            @csrf
                            <div class="form-group">
                                <label for="statusFilter">Filter by Date:</label>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="startDate">Start Date:</label>
                                            <input type="date" id="startDate" name="startDate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="endDate">End Date:</label>
                                            <input type="date" id="endDate" name="endDate" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="button" class="btn btn-success" onclick="printTable()">Print</button>
                            </div>

                        </form>
                    </div>
                    <table class="data-table table nowrap" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>PATIENT NAME</th>
                                <th>DOCTOR NAME</th>
                                <th>SERVICE</th>
                              
                                <th>TIME</th>
                                <th class="text-center">MODE OF APPOINTMENT</th>
                                <th>STATUS</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key => $appointment)
                                <tr>
                                   <!-- <td>{{ $key + 1 }}</td> -->
                                   <td>{{ $appointment->date }}</td>
                                    <td>{{ ucfirst($appointment->patient->firstname) }}
                                        {{ ucfirst($appointment->patient->lastname) }}</td>
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
                                   
                                    <td>{{ date('h:i A', strtotime($appointment->start_time)) }}</td>
                                    <td class="text-center"> {{ $appointment->remarks }} </td>
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
                                  
                                </tr>
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
        function printTable() {
            var fromDate = document.getElementById('startDate').value;
            var toDate = document.getElementById('endDate').value;

            console.log('From Date:', fromDate);
            console.log('To Date:', toDate);
            var totalAppointments = "{{ count($appointments) }}";
            var content = document.getElementById('appointmentsTable').outerHTML;
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write(
                '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">'
            );
            printWindow.document.write('<style>');
            printWindow.document.write('@media print { body { font-size: 14px; } img { width: 8in; height: 5in; } }');
            printWindow.document.write('.data-table { border-collapse: collapse; width: 100%; }');
            printWindow.document.write('.data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; }');
            printWindow.document.write('.data-table th { background-color: #f2f2f2; }');
            printWindow.document.write('.data-table tr:nth-child(even) { background-color: #f2f2f2; }');
            printWindow.document.write('.data-table tr:hover { background-color: #ddd; }');
            printWindow.document.write(
                '.data-table th { padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #1731F5; color: white; }'
            );
            printWindow.document.write('</style></head><body onload="window.print()">');
            printWindow.document.write('<h1 class="text-center">GWIN LYING IN</h1>');
            printWindow.document.write('<p>Total Appointment: ' + totalAppointments + '</p>');
            printWindow.document.write(content.replace(/<span class="badge[^>]+>(.*?)<\/span>/gi,
                '$1')); // Removing badge classes
            printWindow.document.write('</body></html>');
            printWindow.document.close();
        }
    </script>
@endsection
