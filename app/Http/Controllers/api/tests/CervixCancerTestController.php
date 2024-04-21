<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\CervixCancerTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CervixCancerTestController extends Controller
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
            'patient_id' => 'required|exists:patients,id',
            'hpv_vaccine' => 'boolean|nullable',
            'via_test_result' => 'string|nullable',
            'via_test_comment' => 'string|nullable',
            'pap_smear_result' => 'string|nullable',
            'pap_smear_comment' => 'string|nullable',
            'recommendations' => 'string|nullable',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
        ]);

        if($request->hasfile('investigation_files')){
            $filePathes = [];
            
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $storedFile =$investigationFile->storeAs('cervix_cancer_test_investigations', $investigationFileName, 'public');
            $filePathes[]=Storage::url($storedFile);
            }

            $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
        }
        
        $data['doctor_id'] = auth()->user()->id;

        $examination = CervixCancerTest::create($data);

        return response()->json([
            'message' => 'Cervix cancer test has been saved successfully',
            'examination' => $examination], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = CervixCancerTest::where('patient_id',$pateint_id)->latest()->first();

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
        $test = CervixCancerTest::find($id);
        if($test){
            $data = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'hpv_vaccine' => 'boolean|nullable',
                'via_test_result' => 'string|nullable',
                'via_test_comment' => 'string|nullable',
                'pap_smear_result' => 'string|nullable',
                'pap_smear_comment' => 'string|nullable',
                'recommendations' => 'string|nullable',
                'investigation_files' => 'nullable',
                'investigation_files.*'=>'nullable|file',
            ]);

            if($request->hasfile('investigation_files')){
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('cervix_cancer_test_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = CervixCancerTest::create($data);

            return response()->json([
                'message' => 'Cervix cancer test has been updated successfully',
                'examination' => $newExamination], 201);

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
