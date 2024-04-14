<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
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
            $record->patient_id = $request->patient_id;
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

        // Retrieve the uploaded file
        $attachment = $request->file('attachment');

        // Generate the filename using patient ID and current timestamp
        $imageName = 'ultrasound_' . $validatedData['patient_id'] . '_' . time() . '.' . $attachment->getClientOriginalExtension();

        // Move the uploaded file to the desired directory
        $attachment->move(public_path('ultrasound_image'), $imageName);

        // Create the ultrasound record with the filename
        $ultrasound = Ultrasound::create([
            'patient_id' => $validatedData['patient_id'],
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
                'patient_id' => 'required|exists:users,id',
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
}
