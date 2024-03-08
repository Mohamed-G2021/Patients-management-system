<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\HistoryTests\OvarianCancerHistoryTest;
use App\Models\OvarianCancerTest;
use Illuminate\Http\Request;

class OvarianCancerTestController extends Controller
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
            "breast_cancer_history" => 'nullable|boolean',
            "relatives_with_ovarian_cancer" => 'nullable|boolean',
            "gene_mutation_or_lynch_syndrome" => 'nullable|boolean',
            "tvs_result" => 'nullable|string',
            "tvs_comment" => 'nullable|string',
            "ca-125_result" => 'nullable|string',
            "ca-125_comment" => 'nullable|string',
            "recommendations" => 'nullable|string',
        ]);

        $examination = OvarianCancerTest::create($data);

        return response()->json([
            'message' => 'Ovarian test has been saved successfully',
            'examination' => $examination
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = OvarianCancerTest::find($id);

        if($examination) {
            return response()->json($examination);            
        }else{
            return response()->json(['error'=> 'Examination not found'],404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            "breast_cancer_history" => 'nullable|boolean',
            "relatives_with_ovarian_cancer" => 'nullable|boolean',
            "gene_mutation_or_lynch_syndrome" => 'nullable|boolean',
            "tvs_result" => 'nullable|string',
            "tvs_comment" => 'nullable|string',
            "ca-125_result" => 'nullable|string',
            "ca-125_comment" => 'nullable|string',
            "recommendations" => 'nullable|string',
        ]);

        $oldExamination = OvarianCancerTest::find($id);
        $data['test_id'] = $oldExamination->id;
        $data['doctor_id'] = 1;

        $newExamination = OvarianCancerHistoryTest::create($data);
       
        return response()->json([
        'message' => 'Ovarian Test has been updated successfully',
        'examination' => $newExamination],
        200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
