<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\CervixCancerTest;
use Illuminate\Http\Request;

class CervixCancerTestController extends Controller
{
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
            
            $data['investigation_files'] = json_encode($filesNames);
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

        return $examination;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
