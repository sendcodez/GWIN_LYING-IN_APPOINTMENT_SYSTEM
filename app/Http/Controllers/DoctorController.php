<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Doctor_service;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


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
        $doctors = Doctor::with('services')->get();
        $services = Service::where('status', 1)->get();
        return view('admin.create_doctor', compact('doctors', 'services'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('services', 'availabilities');
        return view('admin.show_doctor', ['doctor' => $doctor]);
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
                'expertise' => 'required|integer',
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


            $service = Doctor_service::create([
                'doctor_id' => $doctor->id,
                'service_id' => $validatedData['expertise'],
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
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
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

    public function getDoctorsByService($serviceId, Request $request)
    {
        try {
            // Fetch the selected day from the request
            $selectedDay = strtolower($request->input('selected_day'));
    
            // Fetch doctors based on the selected service
            $service = Service::findOrFail($serviceId);
            $doctors = $service->doctors;
    
            // Filter doctors based on their availability for the selected day
            $availableDoctors = $doctors->filter(function ($doctor) use ($selectedDay) {
                return $doctor->availabilities()->where('day', $selectedDay)->exists();
            });
    
            // Transform the collection of models into an array of plain objects
            $availableDoctorsArray = $availableDoctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'firstname' => $doctor->firstname,
                    'lastname' => $doctor->lastname,
                    // Add any other properties you need
                ];
            })->toArray();
    
            // Return JSON response with the fetched doctors
            return response()->json($availableDoctorsArray);
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch doctors.'], 500);
        }
    }
    

    public function getDoctorAvailability($doctorId, Request $request)
    {
        try {
            // Fetch doctor's availability based on the doctor ID and the requested day
            $day = $request->input('day');
            $availability = DoctorAvailability::where('doctor_id', $doctorId)
                                               ->where('day', $day)
                                               ->first();
    
            // Fetch already booked appointments for the given doctor and date
            $selectedDate = $request->input('selected_date');
            $bookedAppointments = Appointment::where('doctor_id', $doctorId)
                                              ->where('date', $selectedDate)
                                              ->pluck('start_time')
                                              ->toArray();
    
            // Convert available times from 12-hour format to 24-hour format
            $availableTimes = explode(',', $availability->available_times);
            $availableTimes = array_map(function ($time) {
                return date('H:i', strtotime($time));
            }, $availableTimes);
    
            // Filter out already booked appointment times from availability
            $availability['booked_times'] = $bookedAppointments; // Include booked_times in the response
            $availability['available_times'] = array_values(array_diff($availableTimes, $bookedAppointments));
    
            // Return availability as JSON response
            return response()->json($availability);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            // Handle any errors that may occur
            return response()->json(['error' => 'Failed to fetch doctor availability.'], 500);
        }
    }

}
