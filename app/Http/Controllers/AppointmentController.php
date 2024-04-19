<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorAvailability;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
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

   

    $appointments = Appointment::where('user_id', Auth::id())->get();

    $doctorAvailabilities = DoctorAvailability::all();

   

    $services = Service::where('status', 1)->get();
    return view('patient.appointment', [
        'doctorAvailabilities' => $doctorAvailabilities,
        'services' => $services,
        'allAppointments' => $allAppointments,
        'appointments' => $appointments,
    ]);
}

    
    public function showAppointments(){

        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'service'])
                        ->orderBy('date', 'desc')
                        ->get(); 
        return view('admin.showAppointments', compact('appointments'));
       
    }

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
                'user_id' => $request->input('patient_id'),
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

    public function getAll(Request $request)
    {
        // Fetch all appointments with the corresponding doctor's name
        $appointments = Appointment::where('status', '!=', 4) // Exclude appointments with status code 4 (cancelled)
        ->get()
        ->map(function ($appointment) {
            $doctor = Doctor::find($appointment->doctor_id);
            $appointment->doctor_name = $doctor->lastname; // Assuming the doctor's last name is stored in the 'lastname' column
            return $appointment;
        });
    
        // Return JSON response with appointments including doctors' names
        return response()->json($appointments);
    }
    

}
