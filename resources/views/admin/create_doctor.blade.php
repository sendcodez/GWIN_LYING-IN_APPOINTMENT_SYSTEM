@extends ('layouts.sidebar')
@section ('contents')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Doctors</h4>
                    
                </div>
                <div class="card-box pb-10">
					<table class="data-table table nowrap">
						<thead>
							<tr>
								<th class="table-plus">Name</th>
								<th>Contact Number</th>
								<th>Expertise</th>
								<th>Day Availability</th>
								<th>Time Availability</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										
										<div class="txt">
											<div class="weight-600">Juan Dela Cruz</div>
										</div>
									</div>
								</td>
								<td>0909099090</td>
								<td>Obgyne</td>
								<td>Monday</td>
								<td>2:00pm - 5:00pm</td>
                                <td>
                                    <div class="dropdown">
                                        <a
                                            class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                            href="#"
                                            role="button"
                                            data-toggle="dropdown"
                                        >
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div
                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
                                        >
                                            <a class="dropdown-item" href="#"
                                                ><i class="dw dw-eye"></i> View</a
                                            >
                                            <a class="dropdown-item" href="#"
                                                ><i class="dw dw-edit2"></i> Edit</a
                                            >
                                            <a class="dropdown-item" href="#"
                                                ><i class="dw dw-delete-3"></i> Delete</a
                                            >
                                        </div>
                                    </div>
                                </td>
							
							</tr>
							
						</tbody>
					</table>
				</div>  
@endsection
<script src=" {{ asset('src/scripts/jquery.min.js')}}"></script>
