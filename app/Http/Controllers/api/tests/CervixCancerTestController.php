<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\CervixCancerTest;
use App\Models\HistoryTests\CervixCancerHistoryTest;
use Illuminate\Http\Request;

class CervixCancerTestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum');
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
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('cervix_cancer_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames, JSON_UNESCAPED_UNICODE);
        }

        $examination = CervixCancerTest::create($data);

        return response()->json([
            'message' => 'Cervix cancer test has been saved successfully',
            'examination' => $examination], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = CervixCancerTest::find($id);

        if($examination){
            return response()->json($examination);  
        }else{
            return response()->json(['error' => 'Examination not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('cervix_cancer_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames, JSON_UNESCAPED_UNICODE);
        }

        $oldExamination = CervixCancerTest::find($id);
        $data['test_id'] = $oldExamination->id;
        $data['doctor_id'] = 1;

        $newExamination = CervixCancerHistoryTest::create($data);

        return response()->json([
            'message' => 'Cervix cancer test has been updated successfully',
            'examination' => $newExamination], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
