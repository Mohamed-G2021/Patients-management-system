<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ObstetricHistoryTest;
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
            "gravidity"=> "required",
            "parity"=> "required",
            "abortion"=> "required",
            "notes"=> "required",
            'investigation' => 'required|file|mimes:pdf,doc,docx', 
         
        ]);
        $investigationFile=$request->file('investigation');
        $investigationFileName= $investigationFile->getClientOriginalName();

        $data['investigation']=   $investigationFileName;
       $obstetric= ObstetricHistoryTest::create($data);
      
       $investigationFile->storeAs('obstetrichistorytestinvestigations', $investigationFileName, 'public');
    
       return response()->json([
           'message' => 'Obstetric History Test has been saved successfully',
           'obstetric' => $obstetric,
           'original_investigation_name' => $investigationFileName,
       ], 201);
   


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
