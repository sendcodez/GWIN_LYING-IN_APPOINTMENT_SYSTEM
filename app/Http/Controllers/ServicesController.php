<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $services = Service::all();
       return view ('admin.create_services',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'required|string|max:255',
            'type' => 'nullable|boolean',
            'referral' => 'nullable|boolean', // ✅ Add referral validation
        ]);

        // ✅ Explicitly set referral (force 1 or 0)
        $validatedData['referral'] = $request->has('referral') ? 1 : 0;

        // Debug before saving
    

        $service = Service::create($validatedData);

        return back()->with('success', 'Service added successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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
    public function destroy($id)
    {
        // Find the doctor record
        $service = Service::findOrFail($id);

        // Soft delete the service
        $service->delete();

        $user = Auth::user();
        $action = 'delete_service';
        $description = 'Deleted service: ' . $service->name;
        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->firstname,
            'action' => $action,
            'description' => $description,
        ]);
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        if ($request->has('status')) {
            $service->status = $request->status;
            $service->save();

            $user = Auth::user();
            $action = 'update_service';
            $description = 'Update a service status: ' . $service->name;
            ActivityLog::create([
                'user_id' => $user->id,
                'name' => $user->firstname,
                'action' => $action,
                'description' => $description,
            ]);
            return redirect()->back()->with('success', 'Service status updated successfully.');
        }
        return redirect()->back()->with('error', 'No status provided.');
    }
    

}
