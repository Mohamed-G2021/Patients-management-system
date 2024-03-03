<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\BreastCancerTest;
use Illuminate\Http\Request;

class BreastCancerController extends Controller
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
            'age' => 'numeric|nullable',
            'family_history' => 'string|nullable',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
        ]);

        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('breast_cancer_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames);
        }

        $examination = BreastCancerTest::create($data);

        return response()->json([
            'message' => 'Breast cancer data has been saved successfully',
            'examination' => $examination], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = BreastCancerTest::find($id);

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
