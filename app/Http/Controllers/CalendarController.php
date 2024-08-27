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
    $restDays = RestDay::pluck('rest_day')->toArray();
    $rd = RestDay::all();


   

    $services = Service::where('status', 1)->get();
    return view('admin.calendar', [
        'doctorAvailabilities' => $doctorAvailabilities,
        'services' => $services,
        'allAppointments' => $allAppointments,
        'appointments' => $appointments,
        'restDays' => $restDays,
        'rd' => $rd,
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
                'remarks' => 'required|string',
                'status' => 'required|integer',
            ]);
            // Create a new appointment instance
            $appointment = new Appointment([
                'user_id' => $request->input('patient_id'),
                'doctor_id' => $request->input('doctor'),
                'service_id' => $request->input('service'),
                'date' => $request->input('selected_date'),
                'day' => $request->input('selected_day'),
                'start_time' => $request->input('time'),
                'end_time' => $request->input('end_time'),
                'remarks' => $request->input('remarks'),
                'status' => '2',
               
            ]);
    

            $appointment->save();
    
            // Return success response
            return redirect()->back()->with('success', 'Appointment added successfully.');
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return redirect()->back()->with('error', 'Patient ID not found');
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
