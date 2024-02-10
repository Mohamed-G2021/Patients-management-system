<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\GeneralExamination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class GeneralExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
                'patient_id' =>'required|exists:patients,id',
                'height' => 'required',
                'pulse' => 'required',
                'weight' => 'required',
                'random_blood_sugar' => 'required',
                'blood_pressure' => 'required',
                'investigation_files' => 'nullable',
                'investigation_files.*'=>'nullable|file',
            ]);

            if($request->hasfile('investigation_files')){
                $filesNames = [];
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $filesNames[]=$investigationFileName;

                $investigationFile->storeAs('general_examination_investigations', $investigationFileName, 'public');
                }
                
                $data['investigation_files'] = implode(',', $filesNames);
            }

            $examination = GeneralExamination::create($data);

            return response()->json([
                'message' => 'General examination has been saved successfully',
                'examination' => $examination], 201);

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
        $data = $request->validate([
            'patient_id' =>'required',
            'height' => 'required',
            'pulse' => 'required',
            'weight' => 'required',
            'random_blood_sugar' => 'required',
            'blood_pressure' => 'required',
            'investigationFiles' => 'nullable',
            'investigationFiles.*'=>'nullable|file',
        ]);

        $examination = GeneralExamination::find($id);
        
        if($request->hasfile('investigationFiles')){
            $filesNames = [];
            foreach($request->file('investigationFiles')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('general_examination_investigations', $investigationFileName, 'public');
            }
            
            $data['investigationFiles'] = implode(',', $filesNames);
        }

        $examination->update($data);

        return response()->json(['message' => 'General examination has been updated successfully', 'examination' => $examination], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
