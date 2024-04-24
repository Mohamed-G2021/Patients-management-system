<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdminHistory;
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
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->except(['getDoctorHistory']);
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
        $validated_data = $request->validate([
            "password" => "required|confirmed",
            "name" => "required",
            "phone_number" => "required",
            "email" => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
        ]);
    
        $doctor = User::create($request->all());

        AdminHistory::create([
            'admin_id' => auth()->user()->id,
            'doctor_id' => $doctor->id,
            'action' => 'added',
        ]);
    
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

            AdminHistory::create([
                'admin_id' => auth()->user()->id,
                'doctor_id' => $doctor->id,
                'action' => 'edited',
            ]);

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

        if($doctor && $doctor->role == 'doctor'){
            AdminHistory::create([
                'admin_id' => auth()->user()->id,
                'doctor_id' => $doctor->id,
                'action' => 'deleted',
            ]);

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
                    "patient_name" => $patientName,
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
            return response()->json($response, 200);   
        }else{
            return response()->json(null, 200);
        }
    }

    public function getAdminHistory(string $id){
        $admin = User::find($id);
        if($admin){
            $history = collect();
            $actions = AdminHistory::where('admin_id', $id)->orderByDesc('created_at')->get();;
            
            foreach($actions as $action){
                $doctor = User::withTrashed()->find($action->doctor_id);
                $history->push([
                    "action" => $action->action,
                    "doctor_id" => $action->doctor_id,
                    "doctor_name" => "Dr. " . $doctor->name,
                    "date" => $action->created_at->format('d-m-Y'),
                    "time" => $action->created_at->format('h:i A'),
                ]);
            }

            return response()->json($history, 200);
        }else{
            return response()->json(null, 200);        
        }
    }
}
