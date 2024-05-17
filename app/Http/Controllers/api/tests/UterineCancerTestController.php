<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\UterineCancerTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UterineCancerTestController extends Controller
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
            "lynch_syndrome"=> "nullable|in:+ve,-ve",
            "irregular_bleeding"=> "nullable|boolean",
            "tvs_perimetrium_result"=> "nullable|string",
            "tvs_myometrium_result"=> "nullable|string",
            "tvs_endometrium_result"=> "nullable|string",
            "biopsy_result"=> "nullable|string",
            "biopsy_comment"=> "nullable|string",
            "tvs_perimetrium_comment"=> "nullable|string",
            "tvs_myometrium_comment"=> "nullable|string",
            "tvs_endometrium_comment"=> "nullable|string",
            "investigation_files"=> "nullable",
            "investigation_files.*"=> "nullable|file",
        ]);

        if($request->hasfile('investigation_files')){
            $filePathes = [];
            
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $storedFile =$investigationFile->storeAs('uterince_cancer_test_investigations', $investigationFileName, 'public');
            $filePathes[]=Storage::url($storedFile);
            }

            $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
        }
        
        $data['doctor_id'] = auth()->user()->id;

        $test = UterineCancerTest::create($data);
      
        return response()->json([
           'message' => 'Uterine Cancer Test has been saved successfully',
           'test' => $test,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = UterineCancerTest::where('patient_id',$pateint_id)->latest()->first();

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
        $test = UterineCancerTest::find($id); 
        if($test){
            $data = $request->validate([
                "patient_id"=> "required|exists:patients,id",
                "lynch_syndrome"=> "nullable|in:+ve,-ve",
                "irregular_bleeding"=> "nullable|boolean",
                "tvs_perimetrium_result"=> "nullable|string",
                "tvs_myometrium_result"=> "nullable|string",
                "tvs_endometrium_result"=> "nullable|string",
                "biopsy_result"=> "nullable|string",
                "biopsy_comment"=> "nullable|string",
                "tvs_perimetrium_comment"=> "nullable|string",
                "tvs_myometrium_comment"=> "nullable|string",
                "tvs_endometrium_comment"=> "nullable|string",
                "investigation_files"=> "nullable",
                "investigation_files.*"=> "nullable|file",
            ]);

            if($request->hasfile('investigation_files')){
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('uterince_cancer_test_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }
        
            $data['doctor_id'] = auth()->user()->id;

            $newExamination = UterineCancerTest::create($data);
        
            return response()->json([
            'message' => 'Uterine Cancer Test has been updated successfully',
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
