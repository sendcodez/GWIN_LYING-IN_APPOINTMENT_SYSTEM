<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Service;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        $services = Service::where('status', 1)->get();
        // Fetch all services
        return view('admin.create_doctor', compact('doctors','services')); 
    }
    
    public function show(Doctor $doctor)
    {
        $doctor->load('availabilities');
        return view('admin/show_doctor', ['doctor' => $doctor]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming data
            $validatedData = $request->validate([
                'firstname' => 'required|string',
                'middlename' => 'nullable|string',
                'lastname' => 'required|string',
                'contact_number' => 'required|string',
                'description' => 'required|string',
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
            
            // Create a new user instance
            $user = User::create([
                'firstname' => $validatedData['firstname'],
                'middlename' => $validatedData['middlename'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'usertype' => 2,
                'password' => bcrypt($validatedData['password']),
            ]);
    
            // Create a new doctor instance
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'firstname' => $validatedData['firstname'],
                'middlename' => $validatedData['middlename'],
                'lastname' => $validatedData['lastname'],
                'contact_no' => $validatedData['contact_number'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
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
        } catch (\Exception $e) {
            // Handle the exception, you can log it or return a response
            return redirect()->back()->with('error', 'An error occurred while adding the doctor');
        }
    }
    

    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id); // Retrieve the user by ID
        return view('doctor.edit', compact('doctor'));
    }
    public function update(Request $request, string $id)
{
    try {
        $doctor = Doctor::with('availabilities')->findOrFail($id);

        $request->validate([
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'expertise' => 'required|string',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:30748',
            // You may need to add more validation rules for day and time inputs
        ]);

        // Update doctor properties
        $doctor->firstname = $request->input('firstname');
        $doctor->middlename = $request->input('middlename');
        $doctor->lastname = $request->input('lastname');
        $doctor->contact_no = $request->input('contact_number');
        $doctor->address = $request->input('address');
        $doctor->expertise = $request->input('expertise');
        $doctor->description = $request->input('description');
        $doctor->email = $request->input('email');
        $doctor->password = $request->input('password');

        // Upload new image if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $doctor->firstname . '_' . $doctor->lastname . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('doc_image'), $imageName);
            $doctor->image = $imageName;
        }

        $doctor->save();

        // Update doctor availabilities
        $days = $request->input('day');
        $startTimes = $request->input('start_time');
        $endTimes = $request->input('end_time');

        // Delete existing availabilities
        $doctor->availabilities()->delete();

        // Save new availabilities
        foreach ($days as $key => $day) {
            DoctorAvailability::create([
                'doctor_id' => $doctor->id,
                'day' => $day,
                'start_time' => $startTimes[$key],
                'end_time' => $endTimes[$key],
            ]);
        }

        return redirect()->back()->with('success', 'Doctor updated successfully.');
    } catch (Exception $e) {
        Log::error('Error occurred while updating doctor: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while updating the doctor. Please try again.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the doctor record
        $doctor = Doctor::findOrFail($id);
    
        // Soft delete the doctor
        $doctor->delete();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Doctor deleted successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        if ($request->has('status')) {
            $doctor->status = $request->status;
            $doctor->save();
            return redirect()->back()->with('success', 'Doctor status updated successfully.');
        }
        return redirect()->back()->with('error', 'No status provided.');
    }
}
