<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\PregnancyHistory;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Laboratory;
use App\Models\Record;
use App\Models\Ultrasound;
use App\Models\Pregnancy_term;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;
class MyRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $appointments = Appointment::where('user_id', Auth::id())
        ->where('status', 3)
        ->with('services')
        ->get();

    $patient = Patient::where('user_id', Auth::id())->get();   
    $preghis = PregnancyHistory::where('user_id', Auth::id())->get();
    $pregterm = Pregnancy_term::where('user_id', Auth::id())->get();
    $medical = MedicalHistory::where('user_id', Auth::id())->get();
    $ultra = Ultrasound::where('user_id', Auth::id())->get();
    $lab = Laboratory::where('user_id', Auth::id())->get();
    $record = Record::where('user_id', Auth::id())->get();
    $medication = Medication::where('user_id', Auth::id())->get();
    $app = Appointment::where('user_id', Auth::id())
                  ->where('status', 3)
                  ->get();
    
    return view('patient.myrecords', [
        'appointments' => $appointments,
        'preghis' => $preghis,
        'pregterm' => $pregterm,
        'patient' => $patient,
        'medical' => $medical,
        'ultra' => $ultra,
        'lab' => $lab,
        'record' => $record,
        'app' => $app,
        'medication' => $medication,
    ]);
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
        //
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
