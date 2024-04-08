@extends ('layouts.sidebar')
@section('title', 'Appointments')
@section('contents')

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="pd-20 card-box mb-30">
                    <div class="calendar-wrap">
                        <div id="calendar"></div>
                    </div>
<!-- calendar modal -->
<div id="modal-view-event" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="h4">
                    <span class="event-title"></span>
                </h4>
                <p><strong>Doctor:</strong> <span class="doctor-name"></span></p>
                <p><strong>Service:</strong> <span class="service"></span></p>
                <p><strong>Date:</strong> <span class="date"></span></p>
                <p><strong>Time:</strong> <span class="time"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>     
<script src="{{ asset('vendors/scripts/calendar-all-setting.js') }}"></script> 
        @endsection
        
     
