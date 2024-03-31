@extends('layouts.sidebar')
@section('contents')
@section('title', 'Manage Website')
<div class="main-container">
	<div class="pd-ltr-20 xs-pd-20-10">
		<div class="min-height-200px">
			
			<!-- horizontal Basic Forms Start -->
			<div class="pd-20 card-box mb-30">
				<div class="clearfix">
					<div class="pull-left">
						<h2 class="text-blue h2">Manage Website</h2>
						
					</div>
					
				</div>
				<form method="POST" action="{{ route('website.update') }}" enctype="multipart/form-data">
					@csrf
					
					<div class="form-group">
						<label>Current Logo</label>
						<div>
							@if($websiteData->logo)
								<img src="{{ asset('website_images/' . $websiteData->logo) }}" alt="Website Logo" style="max-width: 200px;">
							@else
								<p>No logo uploaded</p>
							@endif
						</div>
					</div>
					
					<div class="form-group">
						<label>Upload New Logo</label>
						<input type="file" class="form-control-file form-control height-auto" name="logo" accept="image/*">
					</div>
					
				
					<div class="form-group">
						<label>Business Name</label>
						<input
							class="form-control"
							type="text"
							name="business_name"
							required
							value="{{ $websiteData->business_name }}"
					
						/>
					</div>
					<div class="form-group">
						<label>Tagline</label>
						<input
							class="form-control"
							type="text"
							name="tagline"
							required
							value="{{ $websiteData->tagline }}"
						/>
					</div>
					<div class="form-group">
						<label>Tagline 2 <i>(Optional)</i></label>
						<input
							class="form-control"
							type="text"
							name="tagline2"
							value="{{ $websiteData->tagline_2 }}"
							
						/>
					</div>


					<div class="form-group">
						<label>Email</label>
						<input
							class="form-control"
							value="{{ $websiteData->email }}"
							type="email"
							name="email"
							required
						/>
					</div>
					<div class="form-group">
						<label>Contact Number</label>
						<input
							class="form-control"
							type="text"
							name="contact_no"
							value="{{ $websiteData->contact_no }}"
							required
						/>
					</div>
					<div class="form-group">
						<label>Address</label>
						<input
							class="form-control"
							type="text"
							name="address"
							value="{{ $websiteData->address }}"
							required
						/>
					</div>
					
					<div class="form-group">
						<label>About Us</label>
						<textarea class="form-control" name="about_us" required>{{ $websiteData->about_us }}</textarea> 
					</div>
					

					<div class="col-12 d-flex justify-content-end">
						<button type="submit" class="btn btn-primary">
							<i class="bx bx-check d-block d-sm-none"></i>
							<span class="d-none d-sm-block">Update</span>
						</button>&nbsp
						
					</div>
				</form>
				

@endsection

