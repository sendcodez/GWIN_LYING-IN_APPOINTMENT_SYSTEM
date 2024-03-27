<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Pregnancy_term;
use App\Models\PregnancyHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
                'firstname' => 'required|string',
                'middlename' => 'nullable|string',
                'lastname' => 'required|string',
                'maiden' => 'nullable|string',
                'birthday' => 'required|string',
                'birthplace' => 'required|string',
                'age' => 'required|integer',
                'civil' => 'required|string',
                'contact_number' => 'nullable|string',
                'religion' => 'required|string',
                'occupation' => 'nullable|string',
                'nationality' => 'required|string',
                'husband_firstname' => 'required|string',
                'husband_middlename' => 'nullable|string',
                'husband_lastname' => 'required|string',
                'husband_occupation' => 'nullable|string',
                'husband_birthday' => 'required|string',
                'husband_age' => 'required|integer',
                'husband_contact_number' => 'nullable|string',
                'husband_religion' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',

                'pregnancies' => 'array|nullable',
                'pregnancies.*.pregnancy' => 'nullable|integer',
                'pregnancies.*.pregnancy_date' => 'nullable|date',
                'pregnancies.*.aog' => 'nullable|string',
                'pregnancies.*.manner' => 'nullable|string',
                'pregnancies.*.bw' => 'nullable|string',
                'pregnancies.*.sex' => 'nullable|string|in:male,female',
                'pregnancies.*.present_status' => 'nullable|string',
                'pregnancies.*.complications' => 'nullable|string',
                

            ]);
                 
  
            // Save patient information
            $patient = new Patient();

            $patient->firstname = $validatedData['firstname'];
            $patient->middlename = $validatedData['middlename'];
            $patient->lastname = $validatedData['lastname'];
            $patient->maiden = $validatedData['maiden'];
            $patient->birthplace = $validatedData['birthplace'];
            $patient->birthday = $validatedData['birthday'];
            $patient->age = $validatedData['age'];
            $patient->civil = $validatedData['civil'];
            $patient->contact_number = $validatedData['contact_number'];
            $patient->religion = $validatedData['religion'];
            $patient->occupation = $validatedData['occupation'];
            $patient->nationality = $validatedData['nationality'];
            $patient->husband_firstname = $validatedData['husband_firstname'];
            $patient->husband_middlename = $validatedData['husband_middlename'];
            $patient->husband_lastname = $validatedData['husband_lastname'];
            $patient->husband_occupation = $validatedData['husband_occupation'];
            $patient->husband_birthday = $validatedData['husband_birthday'];
            $patient->husband_age = $validatedData['husband_age'];
            $patient->husband_contact_number = $validatedData['husband_contact_number'];
            $patient->husband_religion = $validatedData['husband_religion'];
            $patient->province = $validatedData['province'];
            $patient->city = $validatedData['city'];
            $patient->barangay = $validatedData['barangay'];

            $patient->save();

            $pregnancy_term = new Pregnancy_term();
            $pregnancy_term->patient_id = $patient->id;
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
                $item['patient_id'] = $patient->id;
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
            $medicalHistory->patient_id = $patient->id;
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

            return back()->with('success', 'Patient  added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            $errorMessages = $e->getMessage();
            
            // Log the error message
            Log::error($errorMessages);
            
            // Debug the error message using dd()
            dd($errorMessages);
            
            return redirect()->back()->withErrors($errorMessages);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
