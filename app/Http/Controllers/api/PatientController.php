<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientPersonalInfoHistory;
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
            "national_id"=> "required|unique:patients,national_id|digits:14",
            "name" => "required",
            "age"=>"required",
            "phone_number"=> "required",
            "date_of_birth"=> "required",
            "marital_state"=> "required",            
        ]);
        
        $data['address'] = $request->address;
        $data['relative_name'] = $request->relative_name;
        $data['relative_phone'] = $request->relative_phone;
        $data['patient_code']=random_int(10000, 99999);

        $patient = Patient::create($data);
        return response()->json(['message' => 'Patient has been saved successfully', 'patient' => $patient], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient=Patient::find($id);
        
        if($patient){
            return response()->json($patient);  
        }else{
            return response()->json(['error' => 'Patient not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::find($id);

        $data = $request->validate([
            "national_id"=> "digits:14|required|unique:patients,national_id,".$patient->id,
            "name" => "required",
            "age"=>"required",
            "phone_number"=> "required",
            "date_of_birth"=> "required",
            "marital_state"=> "required",
        ]);
        
        $data['address'] = $request->address;
        $data['relative_name'] = $request->relative_name;
        $data['relative_phone'] = $request->relative_phone;

        $data['patient_id'] = $patient->id;
        $data['patient_code'] = $patient->patient_code;
        $data['doctor_id'] = 1;

        $newInformation = PatientPersonalInfoHistory::create($data);
        
        return response()->json(['message' => 'Patient has been updated successfully', 'patient' => $newInformation], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient= Patient::find($id);
        $patient->delete();
        return response()->json(['patient has been deleted successfully']);
    }

    public function Search(string $patient_code)
    {
        $patient = Patient::where('patient_code',$patient_code)->first();
        
        if($patient){
            return response()->json($patient);  
        }else{
            return response()->json(['error' => 'Patient not found'], 404);
        }
    }
}
