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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin');
    }
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
            "password" => "required|confirmed",
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
        $doctor = User::find($id);
        
        if($doctor){
            return response()->json($doctor);  
        }else{
            return response()->json(['error' => 'Doctor not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = User::find($id);
        
        if($doctor){
            $data = $request->validate([
                "password" => "required|confirmed",
                "email"=> "required|unique:users,email,".$doctor->id,
            ]);

            $doctor->update($data);

            return response()->json(['message' => 'Doctor has been updated successfully', 'doctor' => $doctor], 200);
        }else{
            return response()->json(['error' => 'Doctor not found'], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor=User::find($id);

        if($doctor){
            $doctor->delete();
            return response()->json(['doctor has been deleted successfully']);
        }else{
            return response()->json(['error' => 'Doctor not found'], 404);
        }
    }

    public function getDoctorHistory(string $id){
        $doctor = User::find($id); 
        
        if($doctor){
            $generalExaminations = GeneralExamination::where('doctor_id', $id)->orderByDesc('created_at')->get();

            $response = collect();

            foreach ($generalExaminations as $generalExamination) {
                $patient = $generalExamination->patient_id;
                $patientName = Patient::find($patient)->name;
 
                if($generalExamination == GeneralExamination::where('doctor_id', $id)->orderByDesc('created_at')->latest()->first()){
                    $personalInformation = Patient::find($patient)->where('doctor_id', $id)->whereDate('created_at', $generalExamination->created_at)->first();
                }else{
                    $personalInformation = PatientPersonalInfoHistory::where('patient_id', $patient)->where('doctor_id', $id)->whereDate('created_at', $generalExamination->created_at)->first();
                }
                
                $gynaecological = GynaecologicalTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $obstetric = ObstetricTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $breast = BreastCancerTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $ovarian = OvarianCancerTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $preEclampsia = PreEclampsiaTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $uterine = UterineCancerTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $osteoporosis = OsteoporosisTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();
                $cervix = CervixCancerTest::where('doctor_id', $id)->where('doctor_id', $doctor)->whereDate('created_at', $generalExamination->created_at)->first();

                $response->push([
                    "date" => $generalExamination->created_at->format('d-m-Y'),
                    "patient name" => $patientName,
                    "personal information" => $personalInformation,
                    "general examination" => $generalExamination,
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
            return response()->json(["Dr. " . $doctor->name .  " History" => $response], 200);   
        }else{
            return response()->json(['error' => 'Doctor not found'], 404);
        }
    }
}
