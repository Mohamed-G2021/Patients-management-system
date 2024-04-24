<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\ObstetricTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObstetricHistoryTestController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'patient_id' =>'required|exists:patients,id',
            "gravidity"=> "nullable|integer",
            "parity"=> "nullable|integer",
            "abortion"=> "nullable|integer",
            "notes"=> "nullable|string",
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',         
        ]);

        if($request->hasfile('investigation_files')){
            $filePathes = [];
            
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $storedFile =$investigationFile->storeAs('obstetric_history_test_investigations', $investigationFileName, 'public');
            $filePathes[]=Storage::url($storedFile);
            }

            $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
        }
        
        $data['doctor_id'] = auth()->user()->id;

        $obstetric= ObstetricTest::create($data);
      
        return response()->json([
           'message' => 'Obstetric History Test has been saved successfully',
           'obstetric' => $obstetric,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = ObstetricTest::where('patient_id',$pateint_id)->latest()->first();

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
        $test = ObstetricTest::find($id);
        if($test){
            $data=$request->validate([
                'patient_id' =>'required|exists:patients,id',
                "gravidity"=> "nullable|integer",
                "parity"=> "nullable|integer",
                "abortion"=> "nullable|integer",
                "notes"=> "nullable|string",
                'investigation_files' => 'nullable',
                'investigation_files.*'=>'nullable|file',         
            ]);

            if($request->hasfile('investigation_files')){
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('obstetric_history_test_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = ObstetricTest::create($data);
        
            return response()->json([
            'message' => 'Obstetric History Test has been updated successfully',
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
