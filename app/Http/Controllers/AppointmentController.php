<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
  
    public function showCalendar(Request $request)
{
    $doctorId = $request->input('doctor_id');

   
    $allAppointments = Appointment::all();

    Log::info('Appointments:', $allAppointments->toArray()); 

    $appointments = Appointment::where('patient_id', Auth::id())->get();

    $doctorAvailabilities = DoctorAvailability::all();

    Log::info('Doctor Availability:', $doctorAvailabilities->toArray()); 

    $services = Service::where('status', 1)->get();
    return view('patient.appointment', [
        'doctorAvailabilities' => $doctorAvailabilities,
        'services' => $services,
        'allAppointments' => $allAppointments,
        'appointments' => $appointments,
    ]);
}

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:users,id',
                'doctor' => 'required|exists:doctors,id',
                'service' => 'required|exists:services,id',
                'selected_date' => 'required|date',
                'selected_day' => 'required|string',
                'time' => 'required|string',
                'end_time' => 'required|string',
            ]);
    
            // If validation fails, return the validation errors
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            // Create a new appointment instance
            $appointment = new Appointment([
                'patient_id' => $request->input('patient_id'),
                'doctor_id' => $request->input('doctor'),
                'service_id' => $request->input('service'),
                'date' => $request->input('selected_date'),
                'day' => $request->input('selected_day'),
                'start_time' => $request->input('time'),
                'end_time' => $request->input('end_time'),
               
                // Add other fields as needed
            ]);
    

            $appointment->save();
    
            // Return success response
            return redirect()->back()->with('success', 'Appointment added successfully.');
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return redirect()->back()->with('error', 'Failed to add appointment.');
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
