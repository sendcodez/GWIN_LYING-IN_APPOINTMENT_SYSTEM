<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCancelled;
use App\Mail\AppointmentApproved;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $user = Auth::user(); // Get the authenticated user (assuming it's the patient)
        $doctor = Auth::user(); // Get the authenticated user (assuming it's the doctor)
        
        // Fetch appointments for the patient
        $appointments = Appointment::with(['doctor', 'service'])
            ->where('user_id', $user->id)
            ->get();
        
        // Fetch recent appointments for the doctor
        $doctor = Doctor::where('user_id', $user->id)->first();

        if ($doctor) {
            // Fetch recent appointments of the doctor
            $doc_app = Appointment::with(['patient', 'service'])
                ->where('doctor_id', $doctor->id)
                ->orderBy('date', 'desc')
                ->get();
        }
            
        return view('admin.dashboard', compact('appointments', 'doc_app'));
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
    public function cancel($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the status to 'cancelled' (status code 4)
        $appointment->status = 4;
        $appointment->save();
        Mail::to($appointment->patient->email)->send(new AppointmentCancelled($appointment));
        
        if (Auth::user()->usertype === 1 || Auth::user()->usertype === 2) {
            // Log the cancellation if the user is an admin
            $user = Auth::user();
            $action = 'cancel_appointment';
            $description = 'Cancelled an appointment on ' . $appointment->date . ' for: ' . $appointment->doctor->firstname . ' ' . $appointment->doctor->lastname . ' with ' . $appointment->patient->firstname;
    
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
        }
        return redirect()->back()->with('success', 'Appointment cancelled successfully');
    }
    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->status = 2;
        $appointment->save();
        Mail::to($appointment->patient->email)->send(new AppointmentApproved($appointment));

        $user = Auth::user();
        $action = 'approve_appointment';
        $description = 'Approved an appointment for: ' . $appointment->doctor->firstname . ' ' . $appointment->doctor->lastname . ' with ' . $appointment->patient->firstname . ' '. $appointment->patient->lastname;

        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->firstname,
            'action' => $action,
            'description' => $description,
        ]);
        return redirect()->back()->with('success', 'Appointment approved successfully');
    }
    public function complete($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the status to 'cancelled' (status code 4)
        $appointment->status = 3;
        $appointment->save();

        $user = Auth::user();
        $action = 'complete_appointment';
        $description = 'Dr.'. $appointment->doctor->firstname . ' ' . $appointment->doctor->lastname .' '. 'completed an appointment for: ' . $appointment->patient->firstname . ' '. $appointment->patient->lastname;

        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->firstname,
            'action' => $action,
            'description' => $description,
        ]);

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'Appointment completed successfully');
    }
}
