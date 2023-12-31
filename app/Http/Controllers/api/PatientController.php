<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return $patients;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "national_id"=> "required",
            "name" => "required",
            "age"=>"required",
            "date_of_birth"=> "required",
            "address"=> "required",
            "marital_state"=> "required",
            "username"=> "required",
            "password" => "required",
            "relative_name"=> "required",
            "relative_phone" => "required"
        ]);
        
        $patient = Patient::create($data);
    
        return response()->json(['message' => 'Patient has been saved successfully', 'patient' => $patient], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "national_id"=> "required",
            "name" => "required",
            "age"=>"required",
            "date_of_birth"=> "required",
            "address"=> "required",
            "marital_state"=> "required",
            "username"=> "required",
            "password" => "required",
            "relative_name"=> "required",
            "relative_phone" => "required"
        ]);

        $patient = Patient::find($id);
        $patient->update($data);
        
        return response()->json(['message' => 'Patient has been updated successfully', 'patient' => $patient], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient= Patient::find($id);
        $patient->delete();
        return response()->json(['patient    has been deleted successfully']);
    }
}
