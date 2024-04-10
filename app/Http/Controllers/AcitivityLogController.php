<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AcitivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::orderBy('created_at', 'desc')->get();

        // Pass the activity logs to the view
        return view('admin.activity', compact('activityLogs'));
    }
}
