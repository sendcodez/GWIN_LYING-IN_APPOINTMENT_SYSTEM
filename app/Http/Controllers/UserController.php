<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.create_user', compact('users')); 
    }

 
    public function store(Request $request)
    {
        try {
  
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required','min:8'],
            'usertype' => ['required', 'integer'],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
        ]);

        $userId = $user->id;
        $qrCode = QrCode::format('png')
            ->size(200)
            ->errorCorrection('H')
            ->generate($userId);
        
        // Define the output file path
        $output_filename = 'patient_' . $userId . '_' . time() . '.png';
        $output_file_path = public_path('qr_image/' . $output_filename);
        
        // Save the QR code image to the public directory
        File::put($output_file_path, $qrCode);
        
        // Update the patient record with the filename of the QR code image
        $user->qr_name = $output_filename;
        $user->save();

        return redirect()->back()->with('success', 'User added successfully');
    } catch (\Exception $e) {
        // Handle the exception, you can log it or return a response
        return redirect()->back()->with('error', 'An error occurred while adding the User');
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

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->has('status')) {
            $user->status = $request->status;
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully.');
        }
        return redirect()->back()->with('error', 'No status provided.');
    }
}
