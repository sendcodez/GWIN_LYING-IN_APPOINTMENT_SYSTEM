<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Pregnancy_term;
use App\Models\PregnancyHistory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;  
use Illuminate\Support\Facades\Crypt;
use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        // Fetch all patient records from the database
        $patients = Patient::join('users', 'patients.user_id', '=', 'users.id')
            ->select('patients.*', 'users.qr_name')
            ->get();

        // Pass the patient records to the view
        return view('admin.profiling.manage_patient', ['patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profiling.add_patient');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            // Validate request data
            $validatedData = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['nullable', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'maiden' => 'nullable|string',
                'birthday' => 'required|string',
                'birthplace' => 'required|string',
                'age' => 'required|integer',
                'civil' => 'required|string',
                'contact_number' => 'nullable|string',
                'religion' => 'required|string',
                'occupation' => 'nullable|string',
                'nationality' => 'required|string',
                'husband_firstname' => 'nullable|string',
                'husband_middlename' => 'nullable|string',
                'husband_lastname' => 'nullable|string',
                'husband_occupation' => 'nullable|string',
                'husband_birthday' => 'nullable|string',
                'husband_age' => 'nullable|integer',
                'husband_contact_number' => 'nullable|string',
                'husband_religion' => 'nullable|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'husband_province' => 'nullable|string',
                'husband_city' => 'nullable|string',
                'husband_barangay' => 'nullable|string',
    
                'user_id' => 'required|exists:users,id',
                'pregnancies' => 'array|nullable',
                'pregnancies.*.pregnancy' => 'nullable|integer',
                'pregnancies.*.pregnancy_date' => 'nullable|date',
                'pregnancies.*.aog' => 'nullable|string',
                'pregnancies.*.manner' => 'nullable|string',
                'pregnancies.*.bw' => 'nullable|string',
                'pregnancies.*.sex' => 'nullable|string|in:male,female',
                'pregnancies.*.present_status' => 'nullable|string',
                'pregnancies.*.complications' => 'nullable|string',


            ], [
                'user_id.exists' => 'The selected user ID does not exist in the users table.',
            ]);



            // Save patient information
            $patient = new Patient();
            $patient->fill($validatedData);
            $patient->save();
            //PREGNANCY_TERM
            $pregnancy_term = new Pregnancy_term();
            $user_id = $patient->user->id;
            $pregnancy_term->user_id = $user_id;
            $pregnancy_term->gravida = $request->gravida;
            $pregnancy_term->para = $request->para;
            $pregnancy_term->t = $request->t;
            $pregnancy_term->p = $request->p;
            $pregnancy_term->a = $request->a;
            $pregnancy_term->l = $request->l;

            $pregnancy_term->save();

            $history = [];

            foreach ($validatedData['pregnancies'] as $key => $pregnancy) {
                $item = [];
                $user_id = $patient->user->id;
                $item['user_id'] = $patient->user->id;
                $item['pregnancy'] = $pregnancy['pregnancy'];
                $item['pregnancy_date'] = $pregnancy['pregnancy_date'];
                $item['aog'] = $pregnancy['aog'];
                $item['manner'] = $pregnancy['manner'];
                $item['bw'] = $pregnancy['bw'];
                $item['sex'] = $pregnancy['sex'];
                $item['present_status'] = $pregnancy['present_status'];
                $item['complications'] = $pregnancy['complications'];

                // Check if any value is null or empty, if so, skip adding this item to the $history array
                if (!in_array(null, $item, true)) {
                    $history[] = $item;
                }
            }

            // Insert only the non-null items into the database
            if (!empty($history)) {
                PregnancyHistory::insert($history);
            }

            //Save medical history
            $medicalHistory = new MedicalHistory();
            $user_id = $patient->user->id;
            $medicalHistory->user_id = $patient->user->id;
            $booleanValues = [
                'hypertension',
                'heartdisease',
                'asthma',
                'tuberculosis',
                'diabetes',
                'goiter',
                'epilepsy',
                'allergy',
                'hepatitis',
                'vdrl',
                'bleeding',
                'operation',
            ];

            foreach ($booleanValues as $field) {
                $medicalHistory->$field = $request->has($field) ? 1 : 0;
            }

            // If 'othersCheckbox' is checked, save the 'others' value
            if ($request->filled('othersCheckbox')) {
                $medicalHistory->others = $request->input('others');
            }

            // Save Tetanus Toxoid information
            $medicalHistory->tt1 = $request->input('tt1');
            $medicalHistory->tt2 = $request->input('tt2');
            $medicalHistory->tt3 = $request->input('tt3');
            $medicalHistory->tt4 = $request->input('tt4');
            $medicalHistory->tt5 = $request->input('tt5');

            $medicalHistory->save();

            DB::commit();

            $user = Auth::user();
            $action = 'patient_profile';
            $description = 'Profiled patient: ' . $patient->firstname . ' ' . $patient->lastname;
    
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Patient  added successfully.');
        } catch (ValidationException $e) {
            // Custom error message for exists validation rule failure
            if ($e->validator->errors()->has('user_id')) {
                return back()->with('error', 'The selected user ID does not have an account.');
            }
    
            // Other validation errors
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            DB::rollback();
            $errorMessages = $e->getMessage();
            Log::error($errorMessages);
            return redirect()->back()->with('error', 'Failed to add patient.');
        }

    }


    public function show($userId)
    {
        // Fetch the patient with related data based on the user_id
        $patient = Patient::with(['pregnancyTerms', 'PregnancyHistories', 'MedicalHistories'])
            ->where('user_id', $userId)
            ->firstOrFail();

        // Pass the patient data to the view
        return view('admin.profiling.show_patient', compact('patient'));
    }


    public function edit($userId)
    {
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        $pregnancyterm = Pregnancy_term::where('user_id', $userId)->firstOrFail();
        $pregnancyHistories = PregnancyHistory::where('user_id', $userId)->get();
        $medicalHistory = MedicalHistory::where('user_id', $userId)->first();
        return view('admin.profiling.edit_patient', compact('patient', 'pregnancyterm', 'pregnancyHistories', 'medicalHistory'));
    }

    public function update(Request $request, $userId)
{
    $patient = Patient::where('user_id', $userId)->firstOrFail();

    $patient->update($request->all());

    // Convert checkbox values to boolean
    $medicalHistoryData = $request->only(['hypertension', 'heartdisease', 'asthma', 'tuberculosis', 'diabetes', 'goiter', 'epilepsy', 'allergy', 'hepatitis', 'vdrl', 'bleeding', 'operation']);
    foreach ($medicalHistoryData as $key => $value) {
        $medicalHistoryData[$key] = $value ? true : false;
    }

    $medicalHistory = MedicalHistory::updateOrCreate(
        ['user_id' => $patient->user_id],
        $medicalHistoryData
    );

    $pregnancyTerm = Pregnancy_term::updateOrCreate(
        ['user_id' => $patient->user_id],
        $request->only(['tt1', 'tt2', 'tt3', 'tt4', 'tt5'])
    );

    if ($request->has('pregnancies')) {
        foreach ($request->pregnancies as $pregnancy) {
            PregnancyHistory::updateOrCreate(
                ['user_id' => $patient->user_id],
                $pregnancy
            );
        }
    }

    $user = Auth::user();
    $action = 'patient_update';
    $description = 'Update patient information: ' . $patient->firstname . ' ' . $patient->lastname;

    ActivityLog::create([
        'user_id' => $user->id,
        'name' => $user->firstname,
        'action' => $action,
        'description' => $description,
    ]);
    return redirect()->route('patients.show', ['userId' => $userId])->with('success', 'Patient information updated successfully');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the patient by ID
            $patient = Patient::findOrFail($id);
            
            // Soft delete the patient record
            $patient->delete();
    
          
            $user = Auth::user();
            $action = 'delete_patient';
            $description = 'Deleted patient: ' . $patient->firstname . ' ' . $patient->lastname;
    
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return redirect()->back()->with('success', 'Patient deleted successfully.');
        } catch (\Exception $e) {
            // Log the error
            Log::error($e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to delete patient.');
        }
    }
    public function export()
    {
        return Excel::download(new PatientsExport, 'patients.xlsx');
    }


    public function medicalprofile(Request $request)
    {

        DB::beginTransaction();
        try {

            // Validate request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'pregnancies' => 'array|nullable',
                'pregnancies.*.pregnancy' => 'nullable|integer',
                'pregnancies.*.pregnancy_date' => 'nullable|date',
                'pregnancies.*.aog' => 'nullable|string',
                'pregnancies.*.manner' => 'nullable|string',
                'pregnancies.*.bw' => 'nullable|string',
                'pregnancies.*.sex' => 'nullable|string|in:male,female',
                'pregnancies.*.present_status' => 'nullable|string',
                'pregnancies.*.complications' => 'nullable|string',


            ], [
                'user_id.exists' => 'The selected user ID does not exist in the users table.',
            ]);



            // Save patient information
            $patient = new Patient();
            $patient->fill($validatedData);
   
            //PREGNANCY_TERM
            $pregnancy_term = new Pregnancy_term();
            $user_id = $patient->user->id;
            $pregnancy_term->user_id = $user_id;
            $pregnancy_term->gravida = $request->gravida;
            $pregnancy_term->para = $request->para;
            $pregnancy_term->t = $request->t;
            $pregnancy_term->p = $request->p;
            $pregnancy_term->a = $request->a;
            $pregnancy_term->l = $request->l;

            $pregnancy_term->save();

            $history = [];

            foreach ($validatedData['pregnancies'] as $key => $pregnancy) {
                $item = [];
                $user_id = $patient->user->id;
                $item['user_id'] = $patient->user->id;
                $item['pregnancy'] = $pregnancy['pregnancy'];
                $item['pregnancy_date'] = $pregnancy['pregnancy_date'];
                $item['aog'] = $pregnancy['aog'];
                $item['manner'] = $pregnancy['manner'];
                $item['bw'] = $pregnancy['bw'];
                $item['sex'] = $pregnancy['sex'];
                $item['present_status'] = $pregnancy['present_status'];
                $item['complications'] = $pregnancy['complications'];

                // Check if any value is null or empty, if so, skip adding this item to the $history array
                if (!in_array(null, $item, true)) {
                    $history[] = $item;
                }
            }

            // Insert only the non-null items into the database
            if (!empty($history)) {
                PregnancyHistory::insert($history);
            }

            //Save medical history
            $medicalHistory = new MedicalHistory();
            $user_id = $patient->user->id;
            $medicalHistory->user_id = $patient->user->id;
            $booleanValues = [
                'hypertension',
                'heartdisease',
                'asthma',
                'tuberculosis',
                'diabetes',
                'goiter',
                'epilepsy',
                'allergy',
                'hepatitis',
                'vdrl',
                'bleeding',
                'operation',
            ];

            foreach ($booleanValues as $field) {
                $medicalHistory->$field = $request->has($field) ? 1 : 0;
            }

            // If 'othersCheckbox' is checked, save the 'others' value
            if ($request->filled('othersCheckbox')) {
                $medicalHistory->others = $request->input('others');
            }

            // Save Tetanus Toxoid information
            $medicalHistory->tt1 = $request->input('tt1');
            $medicalHistory->tt2 = $request->input('tt2');
            $medicalHistory->tt3 = $request->input('tt3');
            $medicalHistory->tt4 = $request->input('tt4');
            $medicalHistory->tt5 = $request->input('tt5');

            $medicalHistory->save();

            DB::commit();

            $user = Auth::user();
            $action = 'patient_profile';
            $description = 'Profiled patient: ' . $patient->firstname . ' ' . $patient->lastname;
    
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return back()->with('success', 'Patient  added successfully.');
        } catch (ValidationException $e) {
            // Custom error message for exists validation rule failure
            if ($e->validator->errors()->has('user_id')) {
                return back()->with('error', 'The selected user ID does not have an account.');
            }
    
            // Other validation errors
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            DB::rollback();
            $errorMessages = $e->getMessage();
            Log::error($errorMessages);
            return redirect()->back()->with('error', 'Failed to add patient.');
        }

    }


}
