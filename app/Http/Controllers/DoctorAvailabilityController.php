<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorAvailability;

class DoctorAvailabilityController extends Controller
{
    public function fetchUnavailableDays()
    {
        // Fetch unavailable days for doctors
        $unavailableDays = DoctorAvailability::pluck('day')->unique();

        return response()->json($unavailableDays);
    }
}
