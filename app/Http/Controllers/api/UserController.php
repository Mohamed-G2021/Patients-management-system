<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();
        return $doctors;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "password" => "required",
            "email"=> "required|unique:users,email",
        ]);
    
        $doctor = User::create($request->all());
    
        return response()->json(['message' => 'Doctor has been saved successfully', 'doctor' => $doctor], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor =User::find($id);
        return $doctor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "password" => "required",
            "email"=> "required|unique:users,email",
        ]);

        $doctor = User::find($id);
        $doctor->update($data);

        return response()->json(['message' => 'Doctor has been updated successfully', 'doctor' => $doctor], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor=User::find($id);
        $doctor->delete();
        return response()->json(['doctor has been deleted successfully']);
    }
}
