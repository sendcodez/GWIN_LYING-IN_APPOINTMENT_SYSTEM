<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Support\Facades\File;

class WebsiteController extends Controller
{
   
    public function index()
    {
        $websiteData = Website::first(); // Assuming you only have one row for website data
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
        $websiteData = Website::first(); // Assuming you only have one row for website data
    
        // Update other fields
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
            // Get the current date and time
            $currentDateTime = now()->format('Ymd_His');
        
            // Get the original filename of the uploaded file
            $originalFileName = $request->logo->getClientOriginalName();
        
            // Concatenate the current date and time with the original filename
            $logoName = $currentDateTime . '_' . $originalFileName;
        
            // Define the destination path
            $destinationPath = public_path('website_images');
        
            // Move the uploaded file to the desired public path with the new filename
            if ($logo->move($destinationPath, $logoName)) {
                // File moved successfully
                // Update the 'logo' field in the database with the new filename
                $websiteData->update(['logo' => $logoName]);
            } else {
                // File moving failed
                return redirect()->back()->with('error', 'Failed to update website data. Please try again.');
            }
        }
    
        return redirect()->back()->with('success', 'Website data updated successfully!');
    }

    
    public function destroy(string $id)
    {
        
    }
}
