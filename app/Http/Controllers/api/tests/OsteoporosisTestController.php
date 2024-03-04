<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\OsteoporosisTest;
use Illuminate\Http\Request;

class OsteoporosisTestController extends Controller
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
            "patient_id"=> "required|exists:patients,id",
            "age"=> "nullable|numeric",
            "weight"=> "nullable|numeric",
            "current_oestrogen_use"=> "nullable|boolean",
            "investigation_files"=> "nullable",
            "investigation_files.*"=> "nullable|file",
        ]);

        $points = 0;

        if($data['age'] >= 45 && $data['age'] <= 54){
            $points += 0;
        }elseif($data['age'] >= 55 && $data['age'] <= 64){
            $points += 5;
        }elseif($data['age'] >= 65 && $data['age'] <= 74){
            $points += 9;
        }elseif($data['age'] >= 75){
            $points += 15;
        }

        if($data['weight'] >= 70){
            $points += 0;
        }elseif($data['weight'] >= 60 && $data['weight'] <= 69){
            $points += 3;
        }elseif($data['weight'] < 60){
            $points += 9;
        }

        if($data['current_oestrogen_use'] == false){
            $points += 2;
        }else{
            $points += 0;
        }
        
        if($points >= 9){
            $data['recommendations'] = 'Bone densitometry should be done';
        }

        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('osteoporosis_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames);
        }
    
        $test = OsteoporosisTest::create($data);
      
        return response()->json([
           'message' => 'Osteoporosis Test has been saved successfully',
           'test' => $test,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = OsteoporosisTest::find($id);

        if($examination){
            return response()->json($examination);  
        }else{
            return response()->json(['error' => 'Test not found'], 404);
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
