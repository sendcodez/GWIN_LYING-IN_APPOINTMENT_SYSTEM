<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\User;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view ('admin.create_doctor', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */

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
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'expertise' => 'required|string',
            'email' => 'required|email|unique:doctors',
            'password' => 'required|string|min:8',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:30748'
            // You may need to add more validation rules for day and time inputs
        ]);
        $image = $request->file('image');
    
        // Concatenate the doctor's name with the filename
        $imageName = $validatedData['firstname'] . '_' . $validatedData['lastname'] . '_' . time() . '.' . $image->getClientOriginalExtension();
    
        // Move the uploaded file to the desired public path
        $image->move(public_path('doc_image'), $imageName);
        // Create a new doctor instance
        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'usertype' => 2,
            'password' => bcrypt($validatedData['password']),
        ]);
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'contact_no' => $validatedData['contact_number'],
            'address' => $validatedData['address'],
            'expertise' => $validatedData['expertise'],
            'email' => $validatedData['email'],
            'image' => $imageName,
            'password' => bcrypt($validatedData['password']),
        ]);
        // Save doctor availability
        $days = $request->input('day');
        $startTimes = $request->input('start_time');
        $endTimes = $request->input('end_time');

        foreach ($days as $key => $day) {
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day' => $day,
                'start_time' => $startTimes[$key],
                'end_time' => $endTimes[$key],
            ]);
        }

        return redirect()->back()->with('success', 'Doctor added successfully');
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
