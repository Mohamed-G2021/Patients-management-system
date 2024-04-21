<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\PreEclampsiaTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PreEclampsiaTestController extends Controller
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
        $data = $request->validate([
            "patient_id"=> "required|exists:patients,id",
            "history_of_pre-eclampsia"=> "nullable|boolean",
            "number_of_pregnancies_with_pe"=> "nullable|numeric",
            "date_of_pregnancies_with_pe"=> "nullable|string",
            "fate_of_the_pregnancy"=> "nullable|in:1 child,> 1 child,still birth",
            "investigation_files"=> "nullable",
            "investigation_files.*"=> "nullable|file",
        ]);

        if($request->hasfile('investigation_files')){
            $filePathes = [];
            
            foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('preeclampsia_test_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
            }

            $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
        }
        
        $data['doctor_id'] = auth()->user()->id;

        $test = PreEclampsiaTest::create($data);
      
        return response()->json([
           'message' => 'PreEclampsia Test has been saved successfully',
           'test' => $test,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = PreEclampsiaTest::where('patient_id',$pateint_id)->latest()->first();

        if($examination){
            return response()->json($examination);  
        }else{
            return response()->json(['error' => 'No examinations found for this patient'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $test = PreEclampsiaTest::find($id);
        if($test){
            $data = $request->validate([
                "patient_id"=> "required|exists:patients,id",
                "history_of_pre-eclampsia"=> "nullable|boolean",
                "number_of_pregnancies_with_pe"=> "nullable|numeric",
                "date_of_pregnancies_with_pe"=> "nullable|string",
                "fate_of_the_pregnancy"=> "nullable|in:1 child,> 1 child,still birth",
                "investigation_files"=> "nullable",
                "investigation_files.*"=> "nullable|file",
            ]);

            if($request->hasfile('investigation_files')){
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                    $investigationFileName = $investigationFile->getClientOriginalName();
                    $storedFile =$investigationFile->storeAs('preeclampsia_test_investigations', $investigationFileName, 'public');
                    $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = PreEclampsiaTest::create($data);
        
            return response()->json([
            'message' => 'PreEclampsia Test has been updated successfully',
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
