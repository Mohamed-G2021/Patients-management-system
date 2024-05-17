<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\OvarianCancerTest;
use Illuminate\Http\Request;

class OvarianCancerTestController extends Controller
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
            "breast_cancer_history" => 'nullable|boolean',
            "relatives_with_ovarian_cancer" => 'nullable|boolean',
            "gene_mutation_or_lynch_syndrome" => 'nullable|boolean',
            "tvs_result" => 'nullable|string',
            "tvs_comment" => 'nullable|string',
            "ca-125_result" => 'nullable|string',
            "ca-125_comment" => 'nullable|string',
            "recommendations" => 'nullable|string',
        ]);

        $data['doctor_id'] = auth()->user()->id;

        $examination = OvarianCancerTest::create($data);

        return response()->json([
            'message' => 'Ovarian test has been saved successfully',
            'examination' => $examination
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = OvarianCancerTest::where('patient_id',$pateint_id)->latest()->first();

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
        $test = OvarianCancerTest::find($id);
        if($test){
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

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = OvarianCancerTest::create($data);
        
            return response()->json([
            'message' => 'Ovarian Test has been updated successfully',
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
