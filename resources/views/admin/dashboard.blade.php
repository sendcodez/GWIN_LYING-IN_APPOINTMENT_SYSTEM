@extends ('layouts.sidebar')
@section('title', 'Welcome')
@section ('contents')
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
                        <div class="weight-600 font-30 text-blue">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
                        <a href="{{ asset('qr_image/' . Auth::user()->qr_name) }}" download>
                            <img src="{{ asset('qr_image/' . Auth::user()->qr_name) }}" alt="QR Code" style="float: right; margin-right:90px; max-width: 130px;">
                        </a>
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
@endsection