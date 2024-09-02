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
                        <h4 class="text-blue h4">Activity Log</h4>
                    </div>
                    <div class="card-box pb-10">
                        <table class="data-table table nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th>DATE</th>
                                    <th>TIME</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activityLogs as $key => $log)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->toDateString() }}</td>
                                    <td>{{ $log->created_at->format('h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
