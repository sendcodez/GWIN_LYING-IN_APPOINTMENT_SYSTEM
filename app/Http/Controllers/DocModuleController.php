<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DocModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        // Retrieve appointments where the doctor_id matches the authenticated user's id
        $appointments = Appointment::with(['patient', 'service'])
            ->whereHas('doctor', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 2)
            ->orderBy('date', 'asc') // Order appointments by date in ascending order
            ->get();

        return view('doctor.mypatients', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'patient_name' => 'required|string',
            'bed' => 'nullable|string',
            'room' => 'nullable|string',
            'date' => 'required|date',
            'medications' => 'required|array',
            'medications.*.medications' => 'required|string', // Assuming each medication entry is a string
            // Additional validation rules as per your requirements
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
    
        // Serialize the medications array
        $medications = json_encode($request->input('medications.*.medications'));
    
        // Create a new Medication instance
        $medication = new Medication();
        $medication->patient_id = $request->patient_id;
        $medication->service_id = $request->service_id;
        $medication->bed = $request->bed;
        $medication->room = $request->room;
        $medication->name = $request->patient_name;
        $medication->date = $request->date;
        $medication->medications = $medications; // Assign the serialized array
        $medication->save();
    
        
        return redirect()->back()->with('success', 'Medication added successfully');
    } catch (\Exception $e) {
        $errorMessage = $e->getMessage();
        return redirect()->back()->with('error', $errorMessage);
    }
    }


    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        // Fetch the patient with related data based on the user_id
        $patient = Patient::with(['pregnancyTerms', 'PregnancyHistories', 'MedicalHistories'])
            ->where('user_id', $userId)
            ->first();

        if (!$patient) {
            return view('error.norecord');
        }

        // Pass the patient data to the view
        return view('doctor.show_patient', compact('patient'));
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
