<?php

namespace App\Http\Controllers;
use App\Models\Website;
use App\Models\Doctor;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $website = Website::first();
        $doctors = Doctor::all(); 
        return view('index', compact('website', 'doctors'));
    }
    
    
    public function login()
    {
        return view ('auth.login');
    }
    public function services()
    {
        $website = Website::first();
        $doctors = Doctor::all(); 
        return view('services', compact('website', 'doctors'));
    }

    public function about()
    {
        $website = Website::first();
        $doctors = Doctor::all(); 
        return view('about', compact('website', 'doctors'));
    }

    public function pricing()
    {
        $website = Website::first();
        $doctors = Doctor::all(); 
        return view('pricing', compact('website', 'doctors'));
    }


    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}