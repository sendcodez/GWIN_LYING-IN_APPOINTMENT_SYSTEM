<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['nullable', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'maiden' => 'nullable|string',
                'birthday' => 'required|string',
                'birthplace' => 'required|string',
                'age' => 'required|integer',
                'civil' => 'required|string',
                'contact_number' => 'nullable|string',
                'religion' => 'required|string',
                'occupation' => 'nullable|string',
                'nationality' => 'required|string',
                'husband_firstname' => 'required|string',
                'husband_middlename' => 'nullable|string',
                'husband_lastname' => 'required|string',
                'husband_occupation' => 'nullable|string',
                'husband_birthday' => 'required|string',
                'husband_age' => 'required|integer',
                'husband_contact_number' => 'nullable|string',
                'husband_religion' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'husband_province' => 'required|string',
                'husband_city' => 'required|string',
                'husband_barangay' => 'required|string',
            ]);
    
            // Create user
            $user = User::create([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => 3,
            ]);
    
            // Create patient and associate with user
            $patient = new Patient();
            $patient->fill($validatedData);
            $patient->user_id = $user->id;
            $patient->save();
    
            // Generate QR code
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
    
            // Update the user record with the filename of the QR code image
            $user->qr_name = $output_filename;
            $user->save();
    
            event(new Registered($user));
    
            Auth::login($user);

            $user->sendEmailVerificationNotification();
    
            return redirect(RouteServiceProvider::HOME);
    
        } catch (\Exception $e) {
            // Handle any errors
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }
        
}