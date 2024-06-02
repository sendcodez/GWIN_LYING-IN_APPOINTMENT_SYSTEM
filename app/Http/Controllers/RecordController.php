<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Record;
use App\Models\Laboratory;
use App\Models\Ultrasound;
use App\Models\Delivery;
use App\Models\Postpartum;
use App\Models\Labor;
use App\Models\Newborn;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{

    public function index()
    {
        return view('admin.record');
    }

    public function create()
    {

    }


    public function storeRecords(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:users,id',
                'patient_name' => 'required|string',
                'date' => 'required|date',
                'aog' => 'nullable|string',
                'chief' => 'nullable|string',
                'blood_pressure' => 'nullable|string',
                'weight' => 'nullable|string',
                'temperature' => 'nullable|string',
                'cardiac' => 'nullable|string',
                'respiratory' => 'nullable|string',
                'fundic' => 'nullable|string',
                'fht' => 'nullable|string',
                'ie' => 'nullable|string',
                'diagnosis' => 'nullable|string',
                'follow_up' => 'nullable|string',

                'plans' => 'required|array',
                'plans.*.plans' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Serialize the medications array
            $plans = json_encode($request->input('plans.*.plans'));

            // Create a new Medication instance
            $record = new Record();
            $record->user_id = $request->patient_id;
            $record->patient_name = $request->patient_name;
            $record->date = $request->date;
            $record->aog = $request->aog;
            $record->chief = $request->chief;
            $record->blood_pressure = $request->blood_pressure;
            $record->weight = $request->weight;
            $record->temperature = $request->temperature;
            $record->cardiac = $request->cardiac;
            $record->respiratory = $request->respiratory;
            $record->fundic = $request->fundic;
            $record->fht = $request->fht;
            $record->ie = $request->ie;
            $record->diagnosis = $request->diagnosis;
            $record->follow_up = $request->follow_up;

            $record->plan = $plans; // Assign the serialized array
            $record->save();

            $user = Auth::user();
            $action = 'added_record';
            $description = 'Added a record for patient: ' . $record->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);

            return redirect()->back()->with('success', 'Record added successfully');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }

    }

    public function storeUltrasound(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'patient_id' => 'required|exists:users,id',
                'patient_name' => 'required|string',
                'date' => 'nullable|date',
                'result' => 'nullable|string',
                'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:5120',
            ]);

            // Check if a file has been uploaded
            if ($request->hasFile('attachment')) {
                // Retrieve the uploaded file
                $attachment = $request->file('attachment');

                // Generate the filename using patient ID and current timestamp
                $imageName = 'ultrasound_' . $validatedData['patient_id'] . '_' . time() . '.' . $attachment->getClientOriginalExtension();

                // Move the uploaded file to the desired directory
                $attachment->move(public_path('ultrasound_image'), $imageName);
            } else {
                // If no file has been uploaded, set imageName to null
                $imageName = null;
            }

            // Create the ultrasound record with the filename
            $ultrasound = Ultrasound::create([
                'user_id' => $validatedData['patient_id'],
                'patient_name' => $validatedData['patient_name'],
                'date' => $validatedData['date'],
                'result' => $validatedData['result'],
                'attachment' => $imageName,
            ]);

            // Log the activity
            $user = Auth::user();
            $action = 'added_ultrasound';
            $description = 'Added a ultrasound result for patient: ' . $ultrasound->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);

            return back()->with('success', 'Ultrasound added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }



    public function storeLaboratory(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'patient_name' => 'required|string',
                'date' => 'nullable|date',
                'urinalysis' => 'nullable|string',
                'cbc' => 'nullable|string',
                'blood_type' => 'nullable|string',
                'hbsag' => 'nullable|string',
                'vdrl' => 'nullable|string',
                'fbs' => 'nullable|string',
            ]);


            $laboratory = Laboratory::create($validatedData);


            $user = Auth::user();
            $action = 'added_laboratory';
            $description = 'Added a laboratory result for patient: ' . $laboratory->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Laboratory added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function storeDelivery(Request $request)
    {
        try {
           // dd($request->all());
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string',
                'birthday' => 'required|required',
                'birthtime' => 'required|string',
                'sex' => 'required|string',
                'weight' => 'required|string',
                'birth_order' => 'required|string',
                'hc' => 'required|string',
                'cc' => 'required|string',
                'bl' => 'required|string',
                'ac' => 'required|string',
                'aog' => 'required|string',
                'hepa' => 'required|string',
                'bcg' => 'required|string',
                'nbs' => 'required|string',
                'hearing' => 'required|string',
                'handle' => 'required|string',
                'assist' => 'required|string',
                'referral' => 'required|string',
            ]);


            $delivery = Delivery::create($validatedData);


            $user = Auth::user();
            $action = 'added_delivery';
            $description = 'Added a delivery record for patient: ' . $delivery->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Delivery Record added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function storeNewborn(Request $request)
    {
        try {
           // dd($request->all());
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'card' => 'required|string',
                'baby_lastname' => 'required|required',
                'mother_lastname' => 'required|string',
                'mother_firstname' => 'required|string',
                'birthday' => 'required|string',
                'birthtime' => 'required|string',
                'date_collection' => 'required|string',
                'time_collection' => 'required|string',
                'weight' => 'required|string',
                'sex' => 'required|string',
                'aog' => 'required|string',
                'feeding' => 'required|string',
                'status' => 'required|string',
                'birthplace' => 'required|string',
                'address' => 'required|string',
                'contact' => 'required|string',
                'blood_collector' => 'required|string',
                'staff' => 'required|string',
                'result_received' => 'required|string',
                'result' => 'required|string',
                'date_claimed' => 'required|string',
                'claimed_by' => 'required|string',
            ]);


            $newborn = Newborn::create($validatedData);


            $user = Auth::user();
            $action = 'added_newborn';
            $description = 'Added a newborn record for patient: ' . $newborn->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Newborn Record added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    //STORE POSTPARTUM
    public function storePostpartum(Request $request)
    {
        try {
           // dd($request->all());
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'temperature' => 'required|string',
                'pr' => 'required|string',
                'rr' => 'required|string',
                'bp' => 'required|string',
                'u' => 'required|string',
                's' => 'required|string',
               
            ]);


            $postpartum = Postpartum::create($validatedData);


            $user = Auth::user();
            $action = 'added_postpartum';
            $description = 'Added a postpartum record for patient: ' . $postpartum->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Postpartum record added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function storeLabor(Request $request)
    {
        try {
           // dd($request->all());
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'temperature' => 'required|string',
                'pr' => 'required|string',
                'rr' => 'required|string',
                'bp' => 'required|string',
                'fmt' => 'required|string',
                'intensity' => 'required|string',
                'interval' => 'required|string',
                'frequency' => 'required|string',
            ]);


            $labor = labor::create($validatedData);


            $user = Auth::user();
            $action = 'added_labor';
            $description = 'Added a Labor record for patient: ' . $labor->patient_name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Labor record added successfully.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }


    public function show(string $id)
    {

    }


    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {

    }


    public function destroy(string $id)
    {

    }

    public function getPatientDetails($id)
    {
        $patient = Patient::with([
            'user',
            'pregnancyTerms',
            'pregnancyHistories',
            'medicalHistories',
            'appointments',
            'laboratories',
            'records',
            'ultrasounds',
            'medications',
            'delivery',
            'newborn',
            'postpartum',
            'labor',
          
        ])->where('user_id', $id)->first();

        if ($patient || User::where('id', $id)->exists()) {
            $user = $patient ? $patient->user : User::find($id);

            $terms = $patient ? $patient->pregnancyTerms->first() : null;
            $medical = $patient ? $patient->medicalHistories->first() : null;

            // Collect all pregnancy histories
            $pregnancyData = [];

            if ($patient && isset($patient->pregnancyHistories)) {
                foreach ($patient->pregnancyHistories as $preg) {
                    $pregnancyData[] = [
                        'pregnancy' => $preg ? $preg->pregnancy : 'No record',
                        'pregnancy_date' => $preg ? $preg->pregnancy_date : 'No record',
                        'aog' => $preg ? $preg->aog : 'No record',
                        'manner' => $preg ? $preg->manner : 'No record',
                        'bw' => $preg ? $preg->bw : 'No record',
                        'sex' => $preg ? $preg->sex : 'No record',
                        'present_status' => $preg ? $preg->status : 'No record',
                        'complications' => $preg ? $preg->complications : 'No record',
                    ];
                }
            } else {
                // Handle the case when $patient is null or pregnancyHistories is not set
                $pregnancyData[] = [
                    'pregnancy' => 'No record',
                    'pregnancy_date' => 'No record',
                    'aog' => 'No record',
                    'manner' => 'No record',
                    'bw' => 'No record',
                    'sex' => 'No record',
                    'present_status' => 'No record',
                    'complications' => 'No record',
                ];
            }


            // Collect all laboratory records
            $labData = [];

            if ($patient && isset($patient->laboratories)) {
                foreach ($patient->laboratories as $lab) {
                    $labData[] = [
                        'date' => $lab->date ? date('m-d-Y', strtotime($lab->date)) : 'No record',
                        'urinalysis' => $lab->urinalysis ?? 'No record',
                        'cbc' => $lab->cbc ?? 'No record',
                        'blood_type' => $lab->blood_type ?? 'No record',
                        'hbsag' => $lab->hbsag ?? 'No record',
                        'vdrl' => $lab->vdrl ?? 'No record',
                        'fbs' => $lab->fbs ?? 'No record'
                    ];
                }
            } else {
                // Handle the case when $patient is null or laboratories is not set
                $labData[] = [
                    'date' => 'No record',
                    'urinalysis' => 'No record',
                    'cbc' => 'No record',
                    'blood_type' => 'No record',
                    'hbsag' => 'No record',
                    'vdrl' => 'No record',
                    'fbs' => 'No record'
                ];
            }


            // Collect all ultrasound records
            $ultrasoundData = [];

            if ($patient && isset($patient->ultrasounds)) {
                foreach ($patient->ultrasounds as $ultra) {
                    $ultrasoundData[] = [
                        'ultra_date' => $ultra->date ? date('m-d-Y', strtotime($ultra->date)) : 'No record',
                        'result' => $ultra->result ?? 'No record',
                        'attachment' => $ultra->attachment ? asset('ultrasound_image/' . $ultra->attachment) : 'No record'
                    ];
                }
            } else {
                // Handle the case when $patient is null or ultrasounds is not set
                $ultrasoundData[] = [
                    'ultra_date' => 'No record',
                    'result' => 'No record',
                    'attachment' => 'No record'
                ];
            }

            // Collect all appointment records
            $appointmentData = [];

            if ($patient && isset($patient->appointments)) {
                // Sort appointments by date in descending order
                $appointments = $patient->appointments->sortByDesc('date');

                foreach ($appointments as $app) {
                    $appointmentData[] = [
                        'app_date' => $app->date ? date('m-d-Y', strtotime($app->date)) : 'No record',
                        'doctor' => $app->doctor ? 'Dr. ' . $app->doctor->lastname : 'No record',
                        'service' => $app->service ? $app->service->name : 'No record',
                        'start_time' => $app->start_time ? date('h:i A', strtotime($app->start_time)) : 'No record',
                        'status' => $app->status == 1 ? 'Pending' : ($app->status == 2 ? 'Approved' : ($app->status == 3 ? 'Completed' : ($app->status == 4 ? 'Cancelled' : 'No record')))
                    ];
                }
            } else {
                // Handle the case when $patient is null or appointments is empty
                $appointmentData[] = [
                    'app_date' => 'No record',
                    'doctor' => 'No record',
                    'service' => 'No record',
                    'start_time' => 'No record',
                    'status' => 'No record'
                ];
            }

 
            $medicationData = [];
            if ($patient && isset($patient->medications)) {
                foreach ($patient->medications as $medication) {
                    $medicationData[] = [
                        'name' => $medication->name ?? 'No record',
                        'med_date' => optional($medication->created_at)->format('Y-m-d') ?? 'No record',
                        'medications' => $medication->medications ? json_decode($medication->medications) : 'No record'
                    ];
                }
            } else {
                $medicationData[] = [
                    'name' => 'No record',
                    'date' => 'No record',
                    'medications' => 'No record'
                ];
            }

            $deliveryData = [];
            if ($patient && isset($patient->delivery)) {
                foreach ($patient->delivery as $delivery) {
                    $deliveryData[] = [
                        'name' => $delivery->name ?? 'No record',
                        'birthday' => $delivery->birthday ?? 'No record',
                        'birthtime' => $delivery->birthtime ?? 'No record',
                        'sex' => $delivery->sex ?? 'No record',
                        'weight' => $delivery->weight ?? 'No record',
                        'hc' => $delivery->hc ?? 'No record',
                        'cc' => $delivery->cc ?? 'No record',
                        'ac' => $delivery->ac ?? 'No record',
                        'bl' => $delivery->bl ?? 'No record',
                        'birth_order' => $delivery->birth_order ?? 'No record',
                        'aog' => $delivery->aog ?? 'No record',
                        'hepa' => $delivery->hepa ?? 'No record',
                        'bcg' => $delivery->bcg ?? 'No record',
                        'nbs' => $delivery->nbs ?? 'No record',
                        'hearing' => $delivery->hearing ?? 'No record',
                        'handle' => $delivery->handle ?? 'No record',
                        'assist' => $delivery->assist ?? 'No record',
                        'referral' => $delivery->referral ?? 'No record',

                    ];
                }
            } else {
                $deliveryData[] = [
                    'name' => 'No record',
                    'birthday' => 'No record',
                    'birthtime' => 'No record',
                    'sex' => 'No record',
                    'weight' => 'No record',
                    'hc' => 'No record',
                    'cc' => 'No record',
                    'ac' => 'No record',
                    'bl' => 'No record',
                    'birth_order' => 'No record',
                    'aog' => 'No record',
                    'hepa' => 'No record',
                    'bcg' => 'No record',
                    'nbs' => 'No record',
                    'hearing' => 'No record',
                    'handle' => 'No record',
                    'assist' => 'No record',
                    'referral' => 'No record',
                ];
            }

            $newbornData = [];
            if ($patient && isset($patient->newborn)) {
                foreach ($patient->newborn as $newborn) {
                    $newbornData[] = [
                        'card' => $newborn->card ?? 'No record',
                        'bln' => $newborn->baby_lastname ?? 'No record',
                        'mln' => $newborn->mother_lastname ?? 'No record',
                        'mfn' => $newborn->mother_firstname ?? 'No record',
                        'dob' => $newborn->birthday ?? 'No record',
                        'dot' => $newborn->birthtime ?? 'No record',
                        'doc' => $newborn->date_collection ?? 'No record',
                        'toc' => $newborn->time_collection ?? 'No record',
                        'baby_weight' => $newborn->weight ?? 'No record',
                        'baby_sex' => $newborn->sex ?? 'No record',
                        'baby_aog' => $newborn->aog ?? 'No record',
                        'baby_feeding' => $newborn->feeding ?? 'No record',
                        'baby_status' => $newborn->status ?? 'No record',
                        'baby_birthplace' => $newborn->birthplace ?? 'No record',
                        'baby_address' => $newborn->address ?? 'No record',
                        'baby_contact' => $newborn->contact ?? 'No record',
                        'baby_blood' => $newborn->blood_collector   ?? 'No record',
                        'baby_staff' => $newborn->staff ?? 'No record',
                        'drr' => $newborn->result_received ?? 'No record',
                        'baby_result' => $newborn->result ?? 'No record',
                        'dc' => $newborn->date_claimed ?? 'No record',
                        'cb' => $newborn->claimed_by     ?? 'No record',


                    ];
                }
            } else {
                $newbornData[] = [
                    'card' => 'No record',
                    'baby_lastname' => 'No record',
                    'mother_lastname' => 'No record',
                    'mother_firstname' => 'No record',
                    'birthday' => 'No record',
                    'birthtime' => 'No record',
                    'date_collection' => 'No record',
                    'time_collection' => 'No record',
                    'weight' => 'No record',
                    'sex' => 'No record',
                    'aog' => 'No record',
                    'feeding' => 'No record',
                    'status' => 'No record',
                    'birthplace' => 'No record',
                    'address' => 'No record',
                    'contact' => 'No record',
                    'blood_collector' => 'No record',
                    'staff' => 'No record',
                    'result_received' => 'No record',
                    'result' => 'No record',
                    'date_claimed' => 'No record',
                    'claimed_by' => 'No record',
                ];
            }

            $postpartumData = [];
            if ($patient && isset($patient->postpartum)) {
                foreach ($patient->postpartum as $postpartum) {
                    $postpartumData[] = [
                        'post_date' => optional($postpartum->created_at)->format('Y-m-d') ?? 'No record',
                        'post_time' => $postpartum->time ?? 'No record',
                        'post_temp' => $postpartum->temperature ?? 'No record',
                        'pr' => $postpartum->pr ?? 'No record',
                        'rr' => $postpartum->rr ?? 'No record',
                        'bp' => $postpartum->bp ?? 'No record',
                        'u' => $postpartum->u ?? 'No record',
                        's' => $postpartum->s ?? 'No record',
                    ];
                }
            } else {
                $postpartumData[] = [
                    'post_date' => 'No record',
                    'post_time' => 'No record',
                    'post_temp' => 'No record',
                    'pr' => 'No record',
                    'rr' => 'No record',
                    'bp' => 'No record',
                    'u' => 'No record',
                    's' => 'No record',
                ];
            }

            $laborData = [];
            if ($patient && isset($patient->labor)) {
                foreach ($patient->labor as $labor) {
                    $laborData[] = [
                        'labor_date' => optional($labor->created_at)->format('Y-m-d') ?? 'No record',
                        'labor_time' => $labor->time ?? 'No record',
                        'labor_temp' => $labor->temperature ?? 'No record',
                        'labor_pr' => $labor->pr ?? 'No record',
                        'labor_rr' => $labor->rr ?? 'No record',
                        'labor_bp' => $labor->bp ?? 'No record',
                        'fmt' => $labor->fmt ?? 'No record',
                        'intensity' => $labor->intensity ?? 'No record',
                        'interval' => $labor->interval ?? 'No record',
                        'frequency' => $labor->frequency ?? 'No record',
                    ];
                }
            } else {
                $laborData[] = [
                    'labor_date' => 'No record',
                    'labor_time' => 'No record',
                    'labor_temp' => 'No record',
                    'labor_pr' => 'No record',
                    'labor_rr' => 'No record',
                    'labor_bp' => 'No record',
                    'fmt' => 'No record',
                    'intensity' => 'No record',
                    'interval' => 'No record',
                    'frequency' => 'No record',
                    
                ];
            }


            return response()->json([
                // USER
                'firstname' => $user->firstname,
                'middlename' => $user->middlename,
                'lastname' => $user->lastname,
                'contact_number' => $patient ? $patient->contact_number : 'No record',
                'birthday' => $patient ? $patient->birthday : 'No record',
                'birthplace' => $patient ? $patient->birthplace : 'No record',
                // PATIENT
                'age' => $patient ? $patient->age : 'No record',
                'civil' => $patient ? $patient->civil : 'No record',
                'religion' => $patient ? $patient->religion : 'No record',
                'occupation' => $patient ? $patient->occupation : 'No record',
                'nationality' => $patient ? $patient->nationality : 'No record',
                'husband_firstname' => $patient ? $patient->husband_firstname : 'No record',
                'husband_middlename' => $patient ? $patient->husband_middlename : 'No record',
                'husband_lastname' => $patient ? $patient->husband_lastname : 'No record',
                'husband_occupation' => $patient ? $patient->husband_occupation : 'No record',
                'husband_birthday' => $patient ? $patient->husband_birthday : 'No record',
                'husband_age' => $patient ? $patient->husband_age : 'No record',
                'husband_contact_number' => $patient ? $patient->husband_contact_number : 'No record',
                'husband_religion' => $patient ? $patient->husband_religion : 'No record',
                'province' => $patient ? $patient->province : 'No record',
                'city' => $patient ? $patient->city : 'No record',
                'barangay' => $patient ? $patient->barangay : 'No record',
                'husband_province' => $patient ? $patient->husband_province : 'No record',
                'husband_city' => $patient ? $patient->husband_city : 'No record',
                'husband_barangay' => $patient ? $patient->husband_barangay : 'No record',
                // TERMS
                'gravida' => $terms ? $terms->gravida : 'No record',
                'para' => $terms ? $terms->para : 'No record',
                't' => $terms ? $terms->t : 'No record',
                'p' => $terms ? $terms->p : 'No record',
                'a' => $terms ? $terms->a : 'No record',
                'l' => $terms ? $terms->l : 'No record',
                // PREGNANCY HISTORIES
                'pregnancyHistories' => $pregnancyData,
                // LABORATORIES
                'laboratories' => $labData,
                // ULTRASOUNDS
                'ultrasounds' => $ultrasoundData,
                // APPOINTMENTS
                'appointments' => $appointmentData,
                //MEDICATIONS
                'medications' => $medicationData,
                //DELIVERY
                'delivery' => $deliveryData,
                //NEWBORN
                'newborn' => $newbornData,
                //POSTPARTUM
                'postpartum' => $postpartumData,
                //LABOR
                'labor' => $laborData,
                // MEDICAL HISTORY
                'hypertension' => $medical ? ($medical->hypertension == 1 ? 'Yes' : 'No') : 'No record',
                'heartdisease' => $medical ? ($medical->heartdisease == 1 ? 'Yes' : 'No') : 'No record',
                'asthma' => $medical ? ($medical->asthma == 1 ? 'Yes' : 'No') : 'No record',
                'tuberculosis' => $medical ? ($medical->tuberculosis == 1 ? 'Yes' : 'No') : 'No record',
                'diabetes' => $medical ? ($medical->diabetes == 1 ? 'Yes' : 'No') : 'No record',
                'goiter' => $medical ? ($medical->goiter == 1 ? 'Yes' : 'No') : 'No record',
                'epilepsy' => $medical ? ($medical->epilepsy == 1 ? 'Yes' : 'No') : 'No record',
                'allergy' => $medical ? ($medical->allergy == 1 ? 'Yes' : 'No') : 'No record',
                'hepatitis' => $medical ? ($medical->hepatitis == 1 ? 'Yes' : 'No') : 'No record',
                'medical_vdrl' => $medical ? ($medical->vdrl == 1 ? 'Yes' : 'No') : 'No record',
                'bleeding' => $medical ? ($medical->bleeding == 1 ? 'Yes' : 'No') : 'No record',
                'operation' => $medical ? ($medical->operation == 1 ? 'Yes' : 'No') : 'No record',
                'others' => $medical ? $medical->others : 'No record',
            ]);
        } else {
            return response()->json([
                'error' => 'Patient not found for user id ' . $id
            ], 404);
        }
    }

}
