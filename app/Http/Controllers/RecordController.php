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
                'attachment' => 'nullable|file',
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
            'medications'
          
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
