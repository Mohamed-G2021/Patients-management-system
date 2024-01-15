<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return $doctors;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "password" => "required",
            "email"=> "required",
            "phone_number" => "required"
        ]);
    
        $doctor = Doctor::create($data);
    
        return response()->json(['message' => 'Doctor has been saved successfully', 'doctor' => $doctor], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor =Doctor::find($id);
        return $doctor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "name" => "required",
            "password" => "required",
            "email"=> "required",
            "phone_number" => "required"
        ]);

        $doctor = Doctor::find($id);
        $doctor->update($data);

        return response()->json(['message' => 'Doctor has been updated successfully', 'doctor' => $doctor], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor=Doctor::find($id);
        $doctor->delete();
        return response()->json(['doctor has been deleted successfully']);
    }
}
