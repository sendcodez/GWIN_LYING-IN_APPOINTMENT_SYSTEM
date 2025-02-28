<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorAvailability;
use App\Models\Service;
use App\Models\RestDay;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApproved;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function showCalendar(Request $request)
    {
        $doctorId = $request->input('doctor_id');
    
        $allAppointments = Appointment::all();
        $appointments = Appointment::where('user_id', Auth::id())->get();
        $doctorAvailabilities = DoctorAvailability::with(['doctor', 'doctor_services'])->get();
        $services = Service::all();
        $doctors = Doctor::all();
    
        // Retrieve rest days from the RestDay model
        $restDays = RestDay::pluck('rest_day')->toArray();
        $rd = RestDay::all();
    
        // Log the doctor and their corresponding rest days
        foreach ($doctors as $doctor) {
            $doctorRestDays = RestDay::where('doctor_id', $doctor->id)->pluck('rest_day')->toArray();
            \Log::info("Doctor: {$doctor->name}, Rest Days: " . implode(", ", $doctorRestDays));
        }
    
        return view('patient.appointment', compact('allAppointments', 'appointments', 'doctorAvailabilities', 'services', 'restDays', 'rd', 'doctors'));
    }
    



    public function showAppointments()
    {

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
                //  'service' => 'required|array',
                //  'service.*' => 'exists:services,id',
                'service' => 'required|exists:services,id', 
                'selected_date' => 'required|date',
                'selected_day' => 'required|string',
                'time' => 'nullable|string',
                'end_time' => 'nullable|string',
                'remarks' => 'nullable|string',
            ]);

            // If validation fails, return the validation errors
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Create a new appointment instance
            $appointment = new Appointment([
                'user_id' => $request->input('patient_id'),
                'doctor_id' => $request->input('doctor'),
                'date' => $request->input('selected_date'),
                'day' => $request->input('selected_day'),
                'start_time' => $request->input('time'),
                'end_time' => $request->input('end_time'),
                'remarks' => $request->input('remarks'),
            ]);

            $appointment->save();

            // Save related services
            $serviceIds = $request->input('service');
            $appointment->services()->sync($serviceIds);

            // Return success response
            return redirect()->back()->with('success', 'Appointment added successfully.');
        } catch (\Exception $e) {
            // Handle any errors that may occur
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
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
    public function destroy($id)
    {
        // Find the doctor record
        $appointment = Appointment::findOrFail($id);


        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully.');
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


    //SHOW APPOINTMENTS BY STATUS


    public function pendingApp()
{
    $user = Auth::user(); // Get the authenticated user

    // Automatically update past appointments where status is 1 to status 5
    Appointment::where('status', 1)
        ->whereDate('date', '<', now()->toDateString()) // Check if date is in the past
        ->update(['status' => 5]);

    // Get all pending appointments with doctors and services
    $appointments = Appointment::with(['doctor', 'services'])
        ->where('status', '1')
        ->orderBy('date', 'desc')
        ->get();

    // Get all unique doctor IDs from the appointments
    $doctorIds = $appointments->pluck('doctor_id')->unique();

    // Fetch all availabilities for these doctors
    $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)->get();

    // Group availabilities by doctor ID and day
    $groupedAvailabilities = $availabilities->groupBy('doctor_id')->mapWithKeys(function ($items, $doctorId) {
        return [$doctorId => $items->groupBy('day')];
    });

    // Fetch existing appointments for these doctors
    $existingAppointments = Appointment::whereIn('doctor_id', $doctorIds)
        ->whereIn('status', ['1', '2']) // Pending or approved
        ->get()
        ->groupBy('doctor_id');

    // Log grouped availabilities to verify structure
    Log::info('Grouped Availabilities:', $groupedAvailabilities->toArray());
    Log::info('Existing Appointments:', $existingAppointments->toArray());

    return view('admin.pendingapp', compact('appointments', 'groupedAvailabilities', 'existingAppointments'));
}






    public function approvedApp()
    {
        $user = Auth::user(); // Get the authenticated user

        // Get all approved appointments with doctors and services
        $appointments = Appointment::with(['doctor', 'services'])
            ->where('status', '2')
            ->orderBy('date', 'desc')
            ->get();

        // Get all unique doctor IDs from the appointments
        $doctorIds = $appointments->pluck('doctor_id')->unique();

        // Fetch all availabilities for these doctors
        $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)->get();

        // Group availabilities by doctor ID and day
        $groupedAvailabilities = $availabilities->groupBy('doctor_id')->mapWithKeys(function ($items, $doctorId) {
            return [$doctorId => $items->groupBy('day')];
        });

        // Log grouped availabilities to verify structure
        Log::info('Grouped Availabilities:', $groupedAvailabilities->toArray());

        return view('admin.approvedapp', compact('appointments', 'groupedAvailabilities'));
    }

    public function completedApp()
    {

        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'services'])
            ->where('status', '3')
            ->orderBy('date', 'desc')
            ->get();
        $doctorIds = $appointments->pluck('doctor_id')->unique();

        // Fetch all availabilities for these doctors
        $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)->get();

        // Group availabilities by doctor ID and day
        $groupedAvailabilities = $availabilities->groupBy('doctor_id')->mapWithKeys(function ($items, $doctorId) {
            return [$doctorId => $items->groupBy('day')];
        });

        // Log grouped availabilities to verify structure
        Log::info('Grouped Availabilities:', $groupedAvailabilities->toArray());
        return view('admin.completedapp', compact('appointments', 'groupedAvailabilities'));
    }

    public function cancelledApp()
    {

        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'services'])
            ->where('status', '4')
            ->orderBy('date', 'desc')
            ->get();
        $doctorIds = $appointments->pluck('doctor_id')->unique();

        // Fetch all availabilities for these doctors
        $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)->get();

        // Group availabilities by doctor ID and day
        $groupedAvailabilities = $availabilities->groupBy('doctor_id')->mapWithKeys(function ($items, $doctorId) {
            return [$doctorId => $items->groupBy('day')];
        });
        return view('admin.cancelledapp', compact('appointments', 'groupedAvailabilities'));
    }

    public function disapprovedApp()
    {

        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'services'])
            ->where('status', '5')
            ->orderBy('date', 'desc')
            ->get();
        $doctorIds = $appointments->pluck('doctor_id')->unique();

        // Fetch all availabilities for these doctors
        $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)->get();

        // Group availabilities by doctor ID and day
        $groupedAvailabilities = $availabilities->groupBy('doctor_id')->mapWithKeys(function ($items, $doctorId) {
            return [$doctorId => $items->groupBy('day')];
        });
        return view('admin.disapprovedapp', compact('appointments', 'groupedAvailabilities'));

    }
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->start_time = $request->input('start_time');
        $appointment->end_time = $request->input('end_time');
        $appointment->status = 2; // Set status to Approved
        $appointment->save();
        Mail::to($appointment->patient->email)->send(new AppointmentApproved($appointment));

        return redirect()->back()->with('success', 'Appointment approved successfully.');
    }


}
