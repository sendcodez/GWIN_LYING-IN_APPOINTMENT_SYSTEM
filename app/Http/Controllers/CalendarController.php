<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorAvailability;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RestDay;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showCalendar(Request $request)
    {
        $doctorId = $request->input('doctor_id');

        $allAppointments = Appointment::all();
        $appointments = Appointment::all();
        $doctorAvailabilities = DoctorAvailability::with(['doctor', 'doctor_services'])->get();
        $services = Service::all();
        $doctors = Doctor::all();

        // Retrieve rest days from the RestDay model
        $restDays = RestDay::pluck('rest_day')->toArray();
        $rd = RestDay::all();

        return view('admin.calendar', compact('allAppointments', 'appointments', 'doctorAvailabilities', 'services', 'restDays', 'rd','doctors'));
    }



    public function showAppointments()
    {

        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'service'])
            ->orderBy('date', 'desc')
            ->get();
        return view('admin.showAppointments', compact('appointments'));

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
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database specific errors
            if ($e->getCode() === '23000') {
                // Foreign key constraint violation
                $errorMessage = "The patient ID you provided does not exist. Please check the patient ID.";
            } else {
                $errorMessage = "An error occurred while saving the appointment. Please try again.";
            }
    
            return redirect()->back()->with('error', $errorMessage)->withInput();
        } catch (\Exception $e) {
            // Handle any other errors
            return redirect()->back()->with('error', "An error occurred: " . $e->getMessage())->withInput();
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
