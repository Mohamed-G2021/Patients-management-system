<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\GeneralExamination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class GeneralExaminationController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
                'patient_id' =>'required|exists:patients,id',
                'height' => 'numeric|nullable',
                'weight'=> 'numeric|nullable',
                'pulse' => 'numeric|nullable',
                'random_blood_sugar' => 'numeric|nullable',
                'blood_pressure'=> 'string|nullable',
                'investigation_files' => 'nullable',
                'investigation_files.*'=>'nullable|file',
            ]);

            if($request->hasfile('investigation_files')){
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('general_examination_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }

        $data['doctor_id'] = auth()->user()->id;
        $examination = GeneralExamination::create($data);

        return response()->json([
            'message' => 'General examination has been saved successfully',
            'examination' => $examination], 201);

    }
    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = GeneralExamination::where('patient_id',$pateint_id)->latest()->first();

        if($examination){
            return response()->json($examination);  
        }else{
            return response()->json(null, 200);        
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $examination = GeneralExamination::find($id);

        if($examination){
            $data=$request->validate([
                    'patient_id' =>'required|exists:patients,id',
                    'height' => 'numeric|nullable',
                    'weight'=> 'numeric|nullable',
                    'pulse' => 'numeric|nullable',
                    'random_blood_sugar' => 'numeric|nullable',
                    'blood_pressure'=> 'string|nullable',
                    'investigation_files' => 'nullable',
                    'investigation_files.*'=>'nullable|file',
                ]);
            
                if($request->hasfile('investigation_files')){
                    $filePathes = [];
                    
                    foreach($request->file('investigation_files')  as $investigationFile){
                    $investigationFileName = $investigationFile->getClientOriginalName();
                    $storedFile =$investigationFile->storeAs('general_examination_investigations', $investigationFileName, 'public');
                    $filePathes[]=Storage::url($storedFile);
                    }
        
                    $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
                }

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = GeneralExamination::create($data);

            return response()->json([
                'message' => 'General examination has been updated successfully',
                'examination' => $newExamination],
                200);
                
        }else{
            return response()->json(['error' => 'No examination found'], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
