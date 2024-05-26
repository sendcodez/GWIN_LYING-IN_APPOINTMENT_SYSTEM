@extends('layouts.sidebar')
@section('title', 'Show Patient')
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
            <a href="{{route('patient.index')}}" class="btn btn-danger btn-sm scroll-click" ><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        
                        <h1 class="text-center h1 mb-0">{{ $patient->firstname }} {{ $patient->middlename }} {{ $patient->lastname }}</h1>
                        <p class="text-center text-muted font-20">
                        </strong> {{ $patient->user_id }}</p>
                        </p>
                        <div class="profile-info">
                            <h5 class="mb-20 h5 text-green">Patient Informations</h5>
                            <ul>
                                <li>
                                    <span>Email Address:</span>
                                    {{ $patient->user->email }}
                                </li>
                                <li>
                                    <span>Phone Number:</span>
                                    {{ $patient->contact_number }}
                                </li>
                                <li>
                                    <span>Birthplace:</span>
                                    {{ $patient->birthplace }}
                                </li>
                                <li>
                                    <span>Birthday:</span>
                                    {{ $patient->birthday }}
                                </li>
                                <li>
                                    <span>Age:</span>
                                    {{ $patient->age }}
                                </li>
                                <li>
                                    <span>Civil Status:</span>
                                    {{ $patient->civil }}
                                </li>
                                <li>
                                    <span>Religion:</span>
                                    {{ $patient->religion }}
                                </li>
                                <li>
                                    <span>Occupation:</span>
                                    {{ $patient->occupation }}
                                </li>
                                <li>
                                    <span>Nationality:</span>
                                    {{ $patient->nationality }}
                                </li>
                            </ul>
                        </div>
                        <div class="profile-info">
                            <h5 class="mb-20 h5 text-green">Spouse Informations</h5>
                            <ul>
                                <li>
                                    <span>Full name:</span>
                                    {{ $patient->husband_firstname }} {{ $patient->husband_middlename }} {{ $patient->husband_lastname }}
                                </li>
                                <li>
                                    <span>Occupation:</span>
                                    {{ $patient->husband_occupation }}
                                </li>
                                <li>
                                    <span>Contact number:</span>
                                    {{ $patient->husband_contact_number }}
                                </li>
                                <li>
                                    <span>Age:</span>
                                    {{ $patient->husband_age }}
                                </li>
                                <li>
                                    <span>Religion:</span>
                                    {{ $patient->husband_religion }}
                                </li>
                                <li>
                                    <span>Address:</span>
                                    {{ $patient->barangay }}, {{ $patient->city }}, {{ $patient->province }}
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
                                        <a
                                            class="nav-link active"
                                            data-toggle="tab"
                                            href="#timeline"
                                            role="tab"
                                            >Pregnancy History</a
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#tasks"
                                            role="tab"
                                            >Medical History</a
                                        >
                                    </li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <!-- Timeline Tab start -->
                                    <div
                                        class="tab-pane fade show active"
                                        id="timeline"
                                        role="tabpanel"
                                    >
                                        <div class="pd-20">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="table-info">
                                                        <th class="table-plus">Gravida</th>
                                                        <th class="table-plus">Para</th>
                                                        <th>T</th>
                                                        <th style="text-align: center">P</th>
                                                        <th>A</th>
                                                        <th>L</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patient->pregnancyTerms as $term)
                                                    <tr class="table-light">
                                                        <td class="table-plus">
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="txt">
                                                                    <div class="" style="c">{{ $term->gravida }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                        
                                                        <td class="table-plus">
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="txt">
                                                                    <div class="weight-600">{{ $term->para }} </div>
                                                                </div>  
                                                            </div>
                                                        </td>
                                                        <td>{{ $term->t }}</td>
                                                        <td>{{ $term->p }}</td>
                                                        <td>{{ $term->a }}</td>
                                                        <td>{{ $term->l }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="table-success">
                                                        <th class="table-plus">Pregnancy number</th>
                                                        <th class="table-plus">Pregnancy Date</th>
                                                        <th>AOG</th>
                                                        <th>Manner</th>
                                                        <th>BW</th>
                                                        <th>Sex</th>
                                                        <th>Present Status</th>
                                                        <th>Complications</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patient->pregnancyHistories as $history)
                                                    <tr>
                                                        <td class="table-plus">
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="txt">
                                                                    <div class="weight-600" >{{ $history->pregnancy }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                        
                                                        <td class="table-plus">
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="txt">
                                                                    <div class="weight-600">{{ $history->pregnancy_date }} </div>
                                                                </div>  
                                                            </div>
                                                        </td>
                                                        <td>{{ $history->aog }}</td>
                                                        <td>{{ $history->manner }}</td>
                                                        <td>{{ $history->bw }}</td>
                                                        <td>{{ $history->sex }}</td>
                                                        <td>{{ $history->present_status}}</td>
                                                        <td>{{ $history->complications }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                
                                </div>
                                    <!-- Timeline Tab End -->
                                    <!-- Tasks Tab start -->
                                    <div class="tab-pane fade" id="tasks" role="tabpanel">
                                        <div class="pd-20 profile-task-wrap">
                                            <div class="container pd-0">
                                                @foreach ($patient->medicalHistories as $history)
                                                <div class="profile-task-list pb-30">
                                                    <br>
                                                    <ul>
                                                        <li>
                                                            <span>Hypertension: &nbsp</span>
                                                            <span style="{{ $history->hypertension ? 'color: red;' : 'color: blue;' }}">{{ $history->hypertension ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Heart Disease: &nbsp</span>
                                                            <span style="{{ $history->heartdisease ? 'color: red;' : 'color: blue;' }}">{{ $history->heartdisease ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Asthma: &nbsp</span>
                                                            <span style="{{ $history->asthma ? 'color: red;' : 'color: blue;' }}">{{ $history->asthma ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Tuberculosis: &nbsp</span>
                                                            <span style="{{ $history->tuberculosis ? 'color: red;' : 'color: blue;' }}">{{ $history->tuberculosis ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Diabetes: &nbsp</span>
                                                            <span style="{{ $history->diabetes ? 'color: red;' : 'color: blue;' }}">{{ $history->diabetes ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Goiter: &nbsp</span>
                                                            <span style="{{ $history->goiter ? 'color: red;' : 'color: blue;' }}">{{ $history->goiter ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Epilepsy: &nbsp</span>
                                                            <span style="{{ $history->epilepsy ? 'color: red;' : 'color: blue;' }}">{{ $history->epilepsy ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Allergy: &nbsp</span>
                                                            <span style="{{ $history->allergy ? 'color: red;' : 'color: blue;' }}">{{ $history->allergy ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Hepatitis: &nbsp</span>
                                                            <span style="{{ $history->hepatitis ? 'color: red;' : 'color: blue;' }}">{{ $history->hepatitis ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>VDRL: &nbsp</span>
                                                            <span style="{{ $history->vdrl ? 'color: red;' : 'color: blue;' }}">{{ $history->vdrl ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Bleeding: &nbsp</span>
                                                            <span style="{{ $history->bleeding ? 'color: red;' : 'color: blue;' }}">{{ $history->bleeding ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Operation: &nbsp</span>
                                                            <span style="{{ $history->operation ? 'color: red;' : 'color: blue;' }}">{{ $history->operation ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                        <li>
                                                            <span>Others:</span>
                                                            <span style="{{ $history->others !== null ? 'color: red;' : 'color: blue;' }}">{{ $history->others !== null ? 'Yes' : 'No' }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Tasks Tab End -->
                                    <!-- Setting Tab start -->
                                    <div
                                        class="tab-pane fade height-100-p"
                                        id="setting"
                                        role="tabpanel"
                                    >
                                        <div class="profile-setting">
                                            <form>
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-6">
                                                        <h4 class="text-blue h5 mb-20">
                                                            Edit Your Personal Setting
                                                        </h4>
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="email"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date of birth</label>
                                                            <input
                                                                class="form-control form-control-lg date-picker"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <div class="d-flex">
                                                                <div
                                                                    class="custom-control custom-radio mb-5 mr-20"
                                                                >
                                                                    <input
                                                                        type="radio"
                                                                        id="customRadio4"
                                                                        name="customRadio"
                                                                        class="custom-control-input"
                                                                    />
                                                                    <label
                                                                        class="custom-control-label weight-400"
                                                                        for="customRadio4"
                                                                        >Male</label
                                                                    >
                                                                </div>
                                                                <div
                                                                    class="custom-control custom-radio mb-5"
                                                                >
                                                                    <input
                                                                        type="radio"
                                                                        id="customRadio5"
                                                                        name="customRadio"
                                                                        class="custom-control-input"
                                                                    />
                                                                    <label
                                                                        class="custom-control-label weight-400"
                                                                        for="customRadio5"
                                                                        >Female</label
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <select
                                                                class="selectpicker form-control form-control-lg"
                                                                data-style="btn-outline-secondary btn-lg"
                                                                title="Not Chosen"
                                                            >
                                                                <option>United States</option>
                                                                <option>India</option>
                                                                <option>United Kingdom</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>State/Province/Region</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Postal Code</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <textarea class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Visa Card Number</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Paypal ID</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <div
                                                                class="custom-control custom-checkbox mb-5"
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    id="customCheck1-1"
                                                                />
                                                                <label
                                                                    class="custom-control-label weight-400"
                                                                    for="customCheck1-1"
                                                                    >I agree to receive notification
                                                                    emails</label
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <input
                                                                type="submit"
                                                                class="btn btn-primary"
                                                                value="Update Information"
                                                            />
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <h4 class="text-blue h5 mb-20">
                                                            Edit Social Media links
                                                        </h4>
                                                        <div class="form-group">
                                                            <label>Facebook URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Twitter URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Linkedin URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Instagram URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dribbble URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dropbox URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Google-plus URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pinterest URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Skype URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Vine URL:</label>
                                                            <input
                                                                class="form-control form-control-lg"
                                                                type="text"
                                                                placeholder="Paste your link here"
                                                            />
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <input
                                                                type="submit"
                                                                class="btn btn-primary"
                                                                value="Save & Update"
                                                            />
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Setting Tab End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
