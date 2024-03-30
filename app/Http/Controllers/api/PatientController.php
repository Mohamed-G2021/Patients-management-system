<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BreastCancerTest;
use App\Models\CervixCancerTest;
use App\Models\GeneralExamination;
use App\Models\GynaecologicalTest;
use App\Models\ObstetricTest;
use App\Models\OsteoporosisTest;
use App\Models\OvarianCancerTest;
use App\Models\Patient;
use App\Models\PatientPersonalInfoHistory;
use App\Models\PreEclampsiaTest;
use App\Models\User;
use App\Models\UterineCancerTest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum')->except(['search', 'show']);
    }
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
            "phone_number"=> "required",
            "date_of_birth"=> "required|date",
            "marital_state"=> "required",    
            "email" => "unique:patients,email",       
        ]);
        
        $data['address'] = $request->address;
        $data['relative_name'] = $request->relative_name;
        $data['relative_phone'] = $request->relative_phone;
        $data['patient_code']=random_int(10000, 99999);
        $data['doctor_id'] = auth()->user()->id;

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
        
        if($patient){
            $data = $request->validate([
                "national_id"=> "digits:14|required|unique:patients,national_id,".$patient->id,
                "name" => "required",
                "phone_number"=> "required",
                "date_of_birth"=> "required|date",
                "marital_state"=> "required",
                "email" => "nullable|unique:patients,email,".$patient->id,
            ]);
            
            $data['age'] = $patient->age;
            $data['patient_id'] = $patient->id;
            $data['address'] = $request->address;
            $data['relative_name'] = $request->relative_name;
            $data['relative_phone'] = $request->relative_phone;
            $data['patient_code'] = $patient->patient_code;
            $data['doctor_id'] = auth()->user()->id;

            $newInformation = PatientPersonalInfoHistory::create($data);
            
            return response()->json(['message' => 'Patient has been updated successfully', 'patient' => $newInformation], 200);
        }else{
            return response()->json(['error' => 'Patient not found'], 404);
        }
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

    public function search(string $patient_code)
    {
        $patient = Patient::where('patient_code',$patient_code)->first();
        
        if($patient){
            return response()->json($patient);  
        }else{
            return response()->json(['error' => 'Patient not found'], 404);
        }
    }

    public function getPatientHistory(string $id){
        $patient = Patient::find($id); 
        
        if($patient){
            $generalExaminations = GeneralExamination::where('patient_id', $id)->orderByDesc('created_at')->get();

            $response = collect();

            foreach ($generalExaminations as $generalExamination) {
                $doctor = $generalExamination->doctor_id;
                $doctorName = User::where('id',$doctor)->first()->name;
                
                if($generalExamination == GeneralExamination::where('patient_id', $id)->orderByDesc('created_at')->latest()->first()){
                    $personalInformation = Patient::find($id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                }else{
                    $personalInformation = PatientPersonalInfoHistory::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                }
                
                $gynaecological = GynaecologicalTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $obstetric = ObstetricTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $breast = BreastCancerTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $ovarian = OvarianCancerTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $preEclampsia = PreEclampsiaTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $uterine = UterineCancerTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $osteoporosis = OsteoporosisTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $cervix = CervixCancerTest::where('patient_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();

                $response->push([
                    "date" => $generalExamination->created_at->format('d-m-Y'),
                    "doctor_name" => $doctorName,
                    "personal_information" => $personalInformation,
                    "general_examination" => $generalExamination,
                    "gynaecological" => $gynaecological,
                    "obstetric" => $obstetric,
                    "breast" => $breast,
                    "ovarian" => $ovarian,
                    "preEclampsia" => $preEclampsia,
                    "uterine" => $uterine,
                    "osteoporosis" => $osteoporosis,
                    "cervix" => $cervix,
                ]);
            }
            return response()->json( $response, 200);   
        }else{
            return response()->json(['error' => 'Patient not found'], 404);
        }
    }
}
