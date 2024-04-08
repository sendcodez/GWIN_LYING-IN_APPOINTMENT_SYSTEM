<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Patient;
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
        $user = Auth::user(); // Get the authenticated user
        $appointments = Appointment::with(['doctor', 'service'])
                        ->where('patient_id', $user->id)
                        ->get(); // Fetch appointments with related doctor and service information
        return view('admin.dashboard', compact('appointments'));
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

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'Appointment cancelled successfully');
    }
    public function approve($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the status to 'cancelled' (status code 4)
        $appointment->status = 2;
        $appointment->save();

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'Appointment approved successfully');
    }
    public function complete($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the status to 'cancelled' (status code 4)
        $appointment->status = 3;
        $appointment->save();

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'Appointment completed successfully');
    }
}
