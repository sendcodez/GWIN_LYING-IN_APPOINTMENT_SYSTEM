<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{

    public function index()
    {
        $websiteData = Website::first();
        return view('admin.website', compact('websiteData'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show(string $id)
    {

    }


    public function edit()
    {


    }



            public function update(Request $request)
            {
                // Validate the incoming request data
                $request->validate([
                    'business_name' => 'required|string|max:255',
                    'tagline' => 'nullable|string|max:255',
                    'tagline2' => 'nullable|string|max:255',
                    'email' => 'nullable|email|max:255',
                    'contact_no' => 'nullable|string|max:20',
                    'address' => 'nullable|string|max:500',
                    'about_us' => 'nullable|string',
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation rule for image files
                ]);

                $websiteData = Website::first();

                $websiteData->update([
                    'business_name' => $request->business_name,
                    'tagline' => $request->tagline,
                    'tagline_2' => $request->tagline2,
                    'email' => $request->email,
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                    'about_us' => $request->about_us,
                ]);

                $logo = $request->file('logo');

                if ($logo) {
                    $currentDateTime = now()->format('Ymd_His');
                    $originalFileName = $request->logo->getClientOriginalName();
                    $logoName = $currentDateTime . '_' . $originalFileName;
                    $destinationPath = public_path('website_images');

                    if ($logo->move($destinationPath, $logoName)) {
                        $websiteData->update(['logo' => $logoName]);
                    } else {
                        return redirect()->back()->with('error', 'Failed to update website data. Please try again.');
                    }
                }

                $user = Auth::user();
                $action = 'update_website';
                $description = 'Update our website';
                ActivityLog::create([
                    'user_id' => $user->id,
                    'name' => $user->firstname,
                    'action' => $action,
                    'description' => $description,
                ]);

                return redirect()->back()->with('success', 'Website data updated successfully!');
            }


    public function destroy(string $id)
    {

    }
}
