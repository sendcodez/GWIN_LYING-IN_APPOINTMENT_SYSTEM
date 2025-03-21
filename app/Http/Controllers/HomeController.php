<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalAppointments = Appointment::count();

        $totalPatients = Patient::count();

        $completedAppointments = Appointment::with(['doctor', 'services'])
            ->orderBy('date', 'desc')
            ->where('status', 3)
            ->get();

        $totalDoctors = Doctor::where('usertype', 2)->whereNull('deleted_at')->count();


        $totalEarnings = DB::table('appointments')
            ->join('appointment_service', 'appointments.id', '=', 'appointment_service.appointment_id')
            ->join('services', 'appointment_service.service_id', '=', 'services.id')
            ->sum('services.price');
        $recentPatients = Patient::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.home', compact('totalAppointments', 'totalPatients', 'totalEarnings', 'totalDoctors', 'completedAppointments', 'recentPatients'));
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
