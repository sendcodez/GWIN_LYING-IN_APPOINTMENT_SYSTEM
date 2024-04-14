<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}" />

<div
class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20"
>
<div class="pd-10">
    <div class="error-page-wrap text-center">
        <h1>NO RECORD FOUND</h1>
        <div class="pt-20 mx-auto max-width-200">
            <a href="{{route('mypatients.index')}}" class="btn btn-primary btn-block btn-lg"
                >Back To Home</a
            >
        </div>
    </div>
</div>
</div>
<script src="vendors/scripts/core.js"></script>