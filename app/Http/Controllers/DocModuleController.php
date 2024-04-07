<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
class DocModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index()
{   
    $user = Auth::user(); // Get the authenticated user

    // Retrieve appointments where the doctor_id matches the authenticated user's id
    $appointments = Appointment::with(['patient', 'service'])
                    ->whereHas('doctor', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->orderBy('date', 'asc') // Order appointments by date in ascending order
                    ->get(); 

    return view('doctor.mypatients', compact('appointments'));
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
