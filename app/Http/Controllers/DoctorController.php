<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Service;
use App\Models\Restday;
use App\Models\Appointment;
use App\Models\Doctor_service;
use App\Models\DoctorAvailability;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
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
        // Fetch doctors with their services and availability
        $doctors = Doctor::with(['services', 'availability'])->get();

        // Fetch active services
        $services = Service::where('status', 1)->get();

        // Prepare availability days data
        $availabilityDays = [];
        foreach ($doctors as $doctor) {
            $availabilityDays[$doctor->id] = $doctor->availability ? $doctor->availability->pluck('day')->toArray() : [];
        }

        // Pass data to the view
        return view('admin.create_doctor', compact('doctors', 'services', 'availabilityDays'));
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
                //'expertise' => 'required|array',
                //'expertise.*' => 'integer|exists:services,id',
                'expertise' => 'required|integer|exists:services,id',
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
                'email_verified_at' => '2024-08-01 09:34:57',
                'usertype' => 2,
                'password' => bcrypt($validatedData['password']),
            ]);

            // Create a new doctor instance
            //  $expertiseString = json_encode($validatedData['expertise']); // JSON string
            // $expertiseString = implode(',', $validatedData['expertise']); // Comma-separated string

            // Create a new doctor instance
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'firstname' => $validatedData['firstname'],
                'middlename' => $validatedData['middlename'],
                'lastname' => $validatedData['lastname'],
                'contact_no' => $validatedData['contact_number'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'email' => $validatedData['email'],
                'image' => $imageName,
                'password' => bcrypt($validatedData['password']),
                'expertise' => $validatedData['expertise'] // Store the expertise string
            ]);


            Doctor_service::create([
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
            $user = Auth::user();
            $action = 'create_doctor';
            $description = 'Added Dr. ' . $doctor->firstname . ' ' . $doctor->lastname;

            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return redirect()->back()->with('success', 'Doctor added successfully');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }


    public function edit($doctorId)
    {
        $doctor = Doctor::with('availability')->findOrFail($doctorId);
        return view('admin.create_doctor', compact('doctor'));
    }


    public function update(Request $request, string $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            logger()->info('Request data:', $request->all());
            // Validate request data
            $request->validate([
                'firstname' => 'required|string',
                'middlename' => 'nullable|string',
                'lastname' => 'required|string',
                'contact_number' => 'required|string',
                'address' => 'required|string',
                'description' => 'required|string',
                'expertise' => 'required|integer',
                'email' => 'required|email|unique:doctors,email,' . $doctor->id,
                'password' => 'required|string|min:8',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:30748',
                'day' => 'required|array', // Ensure day is provided as an array
                'day.*' => 'required|string', // Validate each day value
                'sched_in' => 'required|array', // Ensure sched_in is provided as an array
                'sched_out' => 'required|array', // Ensure sched_out is provided as an array
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

            // Begin database transaction
            DB::beginTransaction();

            try {
                // Update doctor
                $doctor->save();

                // Delete existing availabilities
                $doctor->availabilities()->delete();

                // Insert new availabilities
                $availabilities = [];
                foreach ($request->input('day') as $key => $day) {
                    $availabilities[] = [
                        'doctor_id' => $doctor->id,
                        'day' => $day,
                        'start_time' => $request->input('sched_in')[$key],
                        'end_time' => $request->input('sched_out')[$key],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('doctor_availabilities')->insert($availabilities);

                // Commit transaction
                DB::commit();

                // Log activity
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'name' => Auth::user()->firstname,
                    'action' => 'update_doctor',
                    'description' => 'Updated information for: Dr. ' . $doctor->firstname . ' ' . $doctor->lastname,
                ]);

                return redirect()->back()->with('success', 'Doctor updated successfully.');
            } catch (\Exception $e) {
                // Rollback transaction if an error occurred
                DB::rollBack();
                Log::error('Error occurred while updating doctor: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while updating the doctor. Please try again.');
            }
        } catch (\Exception $e) {
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

        DoctorAvailability::where('doctor_id', $doctor->id)->delete();
        // Soft delete the doctor
        $doctor->delete();

        $user = Auth::user();
        $action = 'delete_doctor';
        $description = 'Deleted Dr. ' . $doctor->firstname . ' ' . $doctor->lastname;

        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->firstname,
            'action' => $action,
            'description' => $description,
        ]);
        return redirect()->back()->with('success', 'Doctor deleted successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        if ($request->has('status')) {
            $doctor->status = $request->status;
            $doctor->save();

            $user = Auth::user();
            $action = 'update_status';
            $description = 'Updated an status for: Dr. ' . $doctor->firstname . ' ' . $doctor->lastname;

            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return redirect()->back()->with('success', 'Doctor status updated successfully.');
        }
        return redirect()->back()->with('error', 'No status provided.');
    }

    public function getDoctorsByServices(Request $request)
    {
        try {
            $selectedDay = strtolower($request->input('selected_day'));
            $selectedDate = $request->input('selected_date');
            $serviceIds = $request->input('services', []);

            Log::info('Selected Day: ' . $selectedDay);
            Log::info('Selected Date: ' . $selectedDate);
            Log::info('Service IDs: ' . implode(',', $serviceIds));

            $doctors = Doctor::whereHas('services', function ($query) use ($serviceIds) {
                $query->whereIn('services.id', $serviceIds);
            }, '=', count($serviceIds))
                ->whereDoesntHave('restDays', function ($query) use ($selectedDate) {
                    $query->whereDate('rest_day', $selectedDate);
                })
                ->whereHas('availabilities', function ($query) use ($selectedDay) {
                    $query->where('day', ucfirst($selectedDay));
                })
                ->get();

            Log::info('Doctors found: ' . $doctors->count());

            $availableDoctorsArray = $doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'firstname' => $doctor->firstname,
                    'lastname' => $doctor->lastname,
                ];
            })->toArray();

            return response()->json($availableDoctorsArray);
        } catch (\Exception $e) {
            Log::error('Error fetching doctors: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch doctors.'], 500);
        }
    }



    public function addRestDay(Request $request, $id)
    {
        $request->validate([
            'rest_day' => 'required|date',
        ]);

        $doctor = Doctor::find($id);
        if ($doctor) {
            $doctor->rest_days()->create([
                'rest_day' => $request->rest_day,
            ]);
        }

        return redirect()->back()->with('success', 'Rest day added successfully.');
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
                ->where('status', '!=', 4)
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


    public function getAvailability(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $availability = DoctorAvailability::where('doctor_id', $doctorId)
            ->get(['start_time', 'end_time']);

        return response()->json($availability);
    }




    public function getSchedule($id)
    {
        $availabilities = DoctorAvailability::where('doctor_id', $id)->get();
        return response()->json($availabilities);
    }


    public function updateSchedule(Request $request, $id)
    {
        dd($request->all);
        $doctor = Doctor::find($id);

        foreach ($request->input('schedule_id', []) as $index => $scheduleId) {
            $schedule = DoctorAvailability::find($scheduleId);
            if ($schedule) {
                $schedule->update([
                    'day' => $request->input('day')[$index],
                    'start_time' => $request->input('start_time')[$index],
                    'end_time' => $request->input('end_time')[$index],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Updated successfully.');
    }
    public function updateAvailability(Request $request, $doctorId)
    {
        $days = $request->input('day');
        $startTimes = $request->input('start_time');
        $endTimes = $request->input('end_time');

        // First, delete existing availabilities
        DoctorAvailability::where('doctor_id', $doctorId)->delete();

        // Then, add updated availabilities
        foreach ($days as $key => $day) {
            DoctorAvailability::create([
                'doctor_id' => $doctorId,
                'day' => $day,
                'start_time' => $startTimes[$key],
                'end_time' => $endTimes[$key],
            ]);
        }

        return redirect()->back()->with('success', 'Availability updated successfully');
    }
    public function getRestDays(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $restDays = RestDay::where('doctor_id', $doctorId)->pluck('rest_day')->toArray();
        return response()->json(['restDays' => $restDays]);

    }


}
