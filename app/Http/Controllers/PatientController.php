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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;


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

    public function addAccount()
    {
        return view('admin.profiling.addpatientform');
    }
    public function getPatient($user_id)
    {
        $patient = Patient::where('user_id', $user_id)->first();

        if ($patient) {
            $fullName = $patient->firstname . ' ' . $patient->middlename . ' ' . $patient->lastname;
            return response()->json(['name' => trim($fullName)]);
        } else {
            return response()->json(['error' => 'Patient not found'], 404);
        }
    }



    public function storeAccount(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['nullable', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required'],
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
            ]);

            // Create user
            $user = User::create([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'email_verified_at' => now(), // Set email_verified_at to today's date
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => 3,
            ]);

            // Create patient and associate with user
            $patient = new Patient();
            $patient->fill($validatedData);
            $patient->user_id = $user->id;
            $patient->save();

            // Generate QR code
            $userId = $user->id;
            $qrCode = QrCode::format('png')
                ->size(200)
                ->errorCorrection('H')
                ->generate($userId);

            // Define the output file path
            $output_filename = 'patient_' . $userId . '_' . time() . '.png';
            $output_file_path = public_path('qr_image/' . $output_filename);

            // Save the QR code image to the public directory
            File::put($output_file_path, $qrCode);

            // Update the user record with the filename of the QR code image
            $user->qr_name = $output_filename;
            $user->save();

            return back()->with('success', 'Patient  added successfully.');

        } catch (\Exception $e) {
            // Handle any errors
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
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
        DB::beginTransaction();
        try {
            // Find the patient by user_id
            $patient = Patient::where('user_id', $userId)->firstOrFail();

            // Validate the incoming request data
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
                'pregnancies' => 'array|nullable',
                'pregnancies.*.id' => 'nullable|exists:pregnancy_histories,id',
                'pregnancies.*.pregnancy' => 'nullable|integer',
                'pregnancies.*.pregnancy_date' => 'nullable|date',
                'pregnancies.*.aog' => 'nullable|string',
                'pregnancies.*.manner' => 'nullable|string',
                'pregnancies.*.bw' => 'nullable|string',
                'pregnancies.*.sex' => 'nullable|string|in:male,female',
                'pregnancies.*.present_status' => 'nullable|string',
                'pregnancies.*.complications' => 'nullable|string',
                'tt1' => 'nullable|string|max:255',
                'tt2' => 'nullable|string|max:255',
                'tt3' => 'nullable|string|max:255',
                'tt4' => 'nullable|string|max:255',
                'tt5' => 'nullable|string|max:255',
            ]);

            // Update patient details
            $patient->update($validatedData);

            // Update or create medical history
            $medicalHistoryData = $request->only([
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
                'tt1',
                'tt2',
                'tt3',
                'tt4',
                'tt5'
            ]);
            $medicalHistoryData['tt1'] = $request->input('tt1') ?: null;
            $medicalHistoryData['tt2'] = $request->input('tt2') ?: null;
            $medicalHistoryData['tt3'] = $request->input('tt3') ?: null;
            $medicalHistoryData['tt4'] = $request->input('tt4') ?: null;
            $medicalHistoryData['tt5'] = $request->input('tt5') ?: null;


            foreach ($medicalHistoryData as $key => $value) {
                $medicalHistoryData[$key] = $value ? true : false;
            }

            $medicalHistory = MedicalHistory::updateOrCreate(
                ['user_id' => $patient->user_id],
                $request->only(['tt1', 'tt2', 'tt3', 'tt4', 'tt5'])
            );

            // Update or create pregnancy term
            $pregnancyTerm = Pregnancy_term::updateOrCreate(
                ['user_id' => $patient->user_id],
                $request->only(['gravida', 'para', 't', 'p', 'a', 'l'])
            );     


            $pregnancyHistories = $request->input('pregnancies', []); // Defaults to empty array if not provided

            // Loop through each pregnancy history data
            foreach ($pregnancyHistories as $pregnancyData) {
                // Ensure user_id is included
                $pregnancyData['user_id'] = $patient->user_id; // Assign the patient’s user_id to the pregnancy data
    
                // Check if a pregnancy history already exists for this user and pregnancy date
                $existingPregnancyHistory = PregnancyHistory::where('user_id', $patient->user_id)
                                                            ->where('pregnancy_date', $pregnancyData['pregnancy_date'])
                                                            ->first();
    
                if ($existingPregnancyHistory) {
                    // If a record exists, update it
                    $existingPregnancyHistory->update($pregnancyData);
                } else {
                    // Otherwise, create a new record
                    PregnancyHistory::create($pregnancyData);
                }
            }



            // Log the update action
            $user = Auth::user();
            $action = 'patient_update';
            $description = 'Updated patient information: ' . $patient->firstname . ' ' . $patient->lastname;

            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);

            DB::commit();
            Log::debug('Medical history data:', $medicalHistoryData);

            return redirect()->route('patient.index', ['userId' => $userId])->with('success', 'Patient information updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating patient information: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update patient information.');
        }
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
