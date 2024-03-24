<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalHistory;
use App\Models\PregnancyHistory;
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

        $pregnancyHistory = new PregnancyHistory();
        $pregnancyHistory->patient_id = $patient->id;
        
        $pregnancyHistory->gravida = $request->gravida;
        $pregnancyHistory->para = $request->para;
        $pregnancyHistory->t = $request->t;
        $pregnancyHistory->p = $request->p;
        $pregnancyHistory->a = $request->a;
        $pregnancyHistory->l = $request->l;
        $pregnancyHistory->save();
        
        // Assuming the form data arrays are received properly
        $pregnancyData = $request->only(['pregnancy', 'pregnancy_date', 'aog', 'manner', 'bw', 'sex', 'present_status', 'complications']);
        
        foreach ($pregnancyData['pregnancy'] as $key => $pregnancy) {
            $pregnancyHistory = new PregnancyHistory(); // Create a new instance for each iteration
            $pregnancyHistory->patient_id = $patient->id;
            $pregnancyHistory->pregnancy = $pregnancy;
            $pregnancyHistory->pregnancy_date = $pregnancyData['pregnancy_date'][$key];
            $pregnancyHistory->aog = $pregnancyData['aog'][$key];
            $pregnancyHistory->manner = $pregnancyData['manner'][$key];
            $pregnancyHistory->bw = $pregnancyData['bw'][$key];
            $pregnancyHistory->sex = $pregnancyData['sex'][$key];
            $pregnancyHistory->present_status = $pregnancyData['present_status'][$key];
            $pregnancyHistory->complications = $pregnancyData['complications'][$key];
            $pregnancyHistory->save(); // Save each instance
        }
        DB::commit();


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


        return back()->with('success', 'Resident added successfully.');
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
