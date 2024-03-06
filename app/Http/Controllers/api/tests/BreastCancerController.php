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
            'family_history' => 'string|nullable|in:negative,positive in second degree relatives (any number),positive in one first degree relatives,positive in more than one first degree relatives',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
        ]);

        $points = 0;

        if($data['age'] <= 25){
            $points += 1;
        }elseif($data['age'] >= 26 && $data['age'] <= 39){
            $points += 2;
        }elseif($data['age'] >= 40 && $data['age'] <= 49){
            $points += 3;
        }elseif($data['age'] >= 50 && $data['age'] <= 70){
            $points += 4;
        }elseif($data['age'] > 70){
            $points += 3;
        }

        if($data['family_history'] == 'negative'){
            $points += 1;
        }elseif($data['family_history'] == 'positive in second degree relatives (any number)'){
            $points += 2;
        }elseif($data['family_history'] == 'positive in one first degree relatives'){
            $points += 3;
        }elseif($data['family_history'] == 'positive in more than one first degree relatives'){
            $points += 4;
        }
    
        if($points >= 2 && $points <= 4){
            $data['recommendations'] = 'Breast self exam: monthly, Breast specialist exam : Once a year';
        }elseif($points >= 5 && $points <= 6){
            $data['recommendations'] = 'Breast self exam : monthly, Breast specialist exam Once a year, Mamography : every 2 years (at age 40-70 only)';
        }elseif($points >= 7 && $points <= 8){
            $data['recommendations'] = 'Breast self exam : monthly, Breast specialist exam : twice a year, Mamography : every year (at age 40-70 Only)';
        }

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
