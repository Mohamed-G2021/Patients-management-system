<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\PreEclampsiaTest;
use Illuminate\Http\Request;

class PreEclampsiaTestController extends Controller
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
            "history_of_pre-eclampsia"=> "nullable|boolean",
            "number_of_pregnancies_with_pe"=> "nullable|numeric",
            "date_of_pregnancies_with_pe"=> "nullable|string",
            "fate_of_the_pregnancy"=> "nullable|in:1 child,> 1 child,still birth",
            "investigation_files"=> "nullable",
            "investigation_files.*"=> "nullable|file",
        ]);

        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('pre-eclampsia_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames);
        }
    
        $test = PreEclampsiaTest::create($data);
      
        return response()->json([
           'message' => 'PreEclampsia Test has been saved successfully',
           'test' => $test,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = PreEclampsiaTest::find($id);

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
