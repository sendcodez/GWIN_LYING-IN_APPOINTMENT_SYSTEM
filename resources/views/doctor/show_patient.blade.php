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
                @if ($patient)
                    <a href="{{ route('mypatients.index') }}" class="btn btn-danger btn-sm scroll-click"><i
                            class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                            <div class="pd-20 card-box height-100-p">

                                <h1 class="text-center h2 mb-0">{{ $patient->firstname }} {{ $patient->middlename }}
                                    {{ $patient->lastname }}</h1>
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
                                            {{ $patient->husband_firstname }} {{ $patient->husband_middlename }}
                                            {{ $patient->husband_lastname }}
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
                                                <a class="nav-link active" data-toggle="tab" href="#timeline"
                                                    role="tab">Pregnancy History</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tasks" role="tab">Medical
                                                    History</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#pncu" role="tab">PNCU</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#laboratory"
                                                    role="tab">Laboratory Result</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#ultrasound"
                                                    role="tab">Ultrasound Result</a>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <!-- Timeline Tab start -->
                                            <div class="tab-pane fade show active" id="timeline" role="tabpanel">
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
                                                                                <div class="" style="c">
                                                                                    {{ $term->gravida }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="table-plus">
                                                                        <div class="name-avatar d-flex align-items-center">
                                                                            <div class="txt">
                                                                                <div class="weight-600">{{ $term->para }}
                                                                                </div>
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
                                                                                <div class="weight-600">
                                                                                    {{ $history->pregnancy }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="table-plus">
                                                                        <div class="name-avatar d-flex align-items-center">
                                                                            <div class="txt">
                                                                                <div class="weight-600">
                                                                                    {{ $history->pregnancy_date }} </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $history->aog }}</td>
                                                                    <td>{{ $history->manner }}</td>
                                                                    <td>{{ $history->bw }}</td>
                                                                    <td>{{ $history->sex }}</td>
                                                                    <td>{{ $history->present_status }}</td>
                                                                    <td>{{ $history->complications }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="tasks" role="tabpanel">
                                                <div class="pd-20 profile-task-wrap">
                                                    <div class="container pd-0">
                                                        <div class="profile-task-list pb-30">
                                                            <table class="table table-striped table-bordered">
                                                                <tbody>
                                                                    @foreach ($patient->medicalHistories as $history)
                                                                        <tr>
                                                                            <td>Hypertension</td>
                                                                            <td
                                                                                style="color: {{ $history->hypertension ? 'red' : 'blue' }}">
                                                                                {{ $history->hypertension ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Heart Disease</td>
                                                                            <td
                                                                                style="color: {{ $history->heartdisease ? 'red' : 'blue' }}">
                                                                                {{ $history->heartdisease ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Asthma</td>
                                                                            <td
                                                                                style="color: {{ $history->asthma ? 'red' : 'blue' }}">
                                                                                {{ $history->asthma ? 'Yes' : 'No' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tuberculosis</td>
                                                                            <td
                                                                                style="color: {{ $history->tuberculosis ? 'red' : 'blue' }}">
                                                                                {{ $history->tuberculosis ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Diabetes</td>
                                                                            <td
                                                                                style="color: {{ $history->diabetes ? 'red' : 'blue' }}">
                                                                                {{ $history->diabetes ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Goiter</td>
                                                                            <td
                                                                                style="color: {{ $history->goiter ? 'red' : 'blue' }}">
                                                                                {{ $history->goiter ? 'Yes' : 'No' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Epilepsy</td>
                                                                            <td
                                                                                style="color: {{ $history->epilepsy ? 'red' : 'blue' }}">
                                                                                {{ $history->epilepsy ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Allergy</td>
                                                                            <td
                                                                                style="color: {{ $history->allergy ? 'red' : 'blue' }}">
                                                                                {{ $history->allergy ? 'Yes' : 'No' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Hepatitis</td>
                                                                            <td
                                                                                style="color: {{ $history->hepatitis ? 'red' : 'blue' }}">
                                                                                {{ $history->hepatitis ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>VDRL</td>
                                                                            <td
                                                                                style="color: {{ $history->vdrl ? 'red' : 'blue' }}">
                                                                                {{ $history->vdrl ? 'Yes' : 'No' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Bleeding</td>
                                                                            <td
                                                                                style="color: {{ $history->bleeding ? 'red' : 'blue' }}">
                                                                                {{ $history->bleeding ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Operation</td>
                                                                            <td
                                                                                style="color: {{ $history->operation ? 'red' : 'blue' }}">
                                                                                {{ $history->operation ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Others</td>
                                                                            <td
                                                                                style="color: {{ $history->others !== null ? 'red' : 'blue' }}">
                                                                                {{ $history->others !== null ? 'Yes' : 'No' }}
                                                                            </td>
                                                                        </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- PNCU -->
                                            <div class="tab-pane fade " id="pncu" role="tabpanel">
                                                <div class="pd-20">
                                                    <table class="table table-striped table-bordered" id="pncu1">
                                                        <thead>
                                                            <tr class="table-info">
                                                                <th class="">Date</th>
                                                                <th class="">AOG</th>
                                                                <th class="">Chief Complaint</th>
                                                                <th style="">Blood Pressure</th>
                                                                <th>Weight</th>
                                                                <th>Temperature</th>
                                                                <th>Cardiac Rate</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @foreach ($patient->records as $record)
                                                            <tr>
                                                                <td class="table-plus">
                                                                    <div class="name-avatar d-flex align-items-center">
                                                                        <div class="txt">
                                                                            <div class="weight-600">
                                                                                {{ $record->date }}</div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td class="table-plus">
                                                                    <div class="name-avatar d-flex align-items-center">
                                                                        <div class="txt">
                                                                            <div class="weight-600">
                                                                                {{ $record->aog }} </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $record->chief }}</td>
                                                                <td>{{ $record->blood_pressure }}</td>
                                                                <td>{{ $record->weight }}</td>
                                                                <td>{{ $record->temperature }}</td>
                                                                <td>{{ $record->cardiac }}</td>

                                                            </tr>
                @endforeach
                </tr>
                </tbody>
                </table>

                <table class="table table-striped table-bordered" id="records2">
                    <thead>
                        <tr class="table-info">
                            <th>Respiratory Rate</th>
                            <th class="table-plus">Fundic Height</th>
                            <th class="table-plus">FHT</th>
                            <th style="text-align: center">IE</th>
                            <th>Diagnosis</th>
                            <th>Plan</th>
                            <th>Follow Up Check</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $record->respiratory }}</td>
                            <td>{{ $record->fundic }}</td>
                            <td>{{ $record->fht }}</td>
                            <td>{{ $record->ie }}</td>
                            <td>{{ $record->diagnosis }}</td>
                            <td>{{ $record->plan }}</td>
                            <td>{{ $record->follow_up }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ULTRASOUND -->

        <div class="tab-pane fade " id="ultrasound" role="tabpanel">
            <div class="pd-20">
                <table class="table table-striped table-bordered" id="ultrasound">
                    <thead>
                        <tr class="table-info">
                            <th class="table-plus">Date</th>
                            <th class="table-plus">Result</th>
                            <th style="text-align: center">Attachment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($patient->ultrasounds as $ultra)
                     

                            <td>{{ $ultra->date }}</td>
                            <td>{{ $ultra->result }}</td>
                            <td style="text-align: center">
                                <a href="{{ asset('ultrasound_image/' . $ultra->attachment) }}"
                                    download="{{ $ultra->attachment }}">
                                    <img src="{{ asset('ultrasound_image/' . $ultra->attachment) }}"
                                        alt="Ultrasound Image" style="max-width: 100px;">
                                </a>
                            </td>

                      
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LABORATORY -->
        <div class="tab-pane fade " id="laboratory" role="tabpanel">
            <div class="pd-20">

                <table class="table table-striped table-bordered" id="laboratory">
                    <thead>
                        <tr class="table-info">
                            <th class="table-plus">Date</th>
                            <th class="table-plus">Urinalysis</th>
                            <th style="text-align: center">CBC</th>
                            <th>Blood Type</th>
                            <th>HBSAG</th>
                            <th>VDRL</th>
                            <th>FBS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($patient->laboratories as $lab)
                     

                            <td>{{ $lab->date }}</td>
                            <td>{{ $lab->urinalysis }}</td>
                            <td>{{ $lab->cbc }}</td>
                            <td>{{ $lab->blood_type }}</td>
                            <td>{{ $lab->hbsag }}</td>
                            <td>{{ $lab->vdrl }}</td>
                            <td>{{ $lab->fbs }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    @endforeach
@else
    @include('errors.record_not_found')
    @endif
    <!-- Tasks Tab End -->
    <!-- Setting Tab start -->
    <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
        <div class="profile-setting">
            <form>
                <ul class="profile-edit-list row">
                    <li class="weight-500 col-md-6">
                        <h4 class="text-blue h5 mb-20">
                            Edit Your Personal Setting
                        </h4>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control form-control-lg" type="email" />
                        </div>
                        <div class="form-group">
                            <label>Date of birth</label>
                            <input class="form-control form-control-lg date-picker" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="d-flex">
                                <div class="custom-control custom-radio mb-5 mr-20">
                                    <input type="radio" id="customRadio4" name="customRadio"
                                        class="custom-control-input" />
                                    <label class="custom-control-label weight-400" for="customRadio4">Male</label>
                                </div>
                                <div class="custom-control custom-radio mb-5">
                                    <input type="radio" id="customRadio5" name="customRadio"
                                        class="custom-control-input" />
                                    <label class="custom-control-label weight-400" for="customRadio5">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select class="selectpicker form-control form-control-lg"
                                data-style="btn-outline-secondary btn-lg" title="Not Chosen">
                                <option>United States</option>
                                <option>India</option>
                                <option>United Kingdom</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>State/Province/Region</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Visa Card Number</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <label>Paypal ID</label>
                            <input class="form-control form-control-lg" type="text" />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="customCheck1-1" />
                                <label class="custom-control-label weight-400" for="customCheck1-1">I agree to
                                    receive notification
                                    emails</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <input type="submit" class="btn btn-primary" value="Update Information" />
                        </div>
                    </li>
                    <li class="weight-500 col-md-6">
                        <h4 class="text-blue h5 mb-20">
                            Edit Social Media links
                        </h4>
                        <div class="form-group">
                            <label>Facebook URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Twitter URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Linkedin URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Instagram URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Dribbble URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Dropbox URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Google-plus URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Pinterest URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Skype URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group">
                            <label>Vine URL:</label>
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Paste your link here" />
                        </div>
                        <div class="form-group mb-0">
                            <input type="submit" class="btn btn-primary" value="Save & Update" />
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
