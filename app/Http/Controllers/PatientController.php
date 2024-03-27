<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Pregnancy_term;
use App\Models\PregnancyHistory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all patient records from the database
        $patients = Patient::all();
    
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
            $patient->fill($validatedData);


            $patient->save();
            $patientId = $patient->id;
            $qrCode = QrCode::format('png')
                ->size(200)
                ->errorCorrection('H')
                ->generate($patientId);
            
            // Define the output file path
            $output_filename = 'patient_' . $patientId . '_' . time() . '.png';
            $output_file_path = public_path('qr_image/' . $output_filename);
            
            // Save the QR code image to the public directory
            File::put($output_file_path, $qrCode);
            
            // Update the patient record with the filename of the QR code image
            $patient->qr_name = $output_filename;
            $patient->save();

            //PREGNANCY_TERM
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
