<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\ObstetricTest;
use Illuminate\Http\Request;

class ObstetricHistoryTestController extends Controller
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
        $data=$request->validate([
            'patient_id' =>'required|exists:patients,id',
            "gravidity"=> "nullable|integer",
            "parity"=> "nullable|integer",
            "abortion"=> "nullable|integer",
            "notes"=> "nullable|string",
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',         
        ]);

        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('obstetric_history_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames);
        }
    
        $obstetric= ObstetricTest::create($data);
      
       return response()->json([
           'message' => 'Obstetric History Test has been saved successfully',
           'obstetric' => $obstetric,
       ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $examination = ObstetricTest::find($id);

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
        $data=$request->validate([
            "gravidity"=> "required",
            "parity"=> "required",
            "abortion"=> "required",
            "notes"=> "required",
            'investigation' => 'required|file|mimes:pdf,doc,docx', 
         
        ]);
        $obstetric= ObstetricHistoryTest::find($id);
        $obstetric->update($data);
       
        if ($request->hasFile('investigation')) {
            $newInvestigationFile = $request->file('investigation');
            $newInvestigationFileName = $newInvestigationFile->getClientOriginalName();
            $data['investigation'] = $newInvestigationFileName;
            $obstetric->update($data);
            $newInvestigationFile->storeAs('obstetrichistorytestinvestigations', $newInvestigationFileName, 'public');
        }

        return response()->json(['message' => 'Obstetric History Test has been updated successfully', 'obstetric' => $obstetric], 200);
    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
