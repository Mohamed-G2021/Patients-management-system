<?php

namespace App\Http\Controllers\api;

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
                'height' => 'required',
                'pulse' => 'required',
                'weight' => 'required',
                'random_blood_sugar' => 'required',
                'blood_pressure' => 'required',
                'investigation' => 'nullable|file|mimes:pdf,doc,docx',
            ]);
            $investigationFile = $request->file('investigation');

            if($investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();

                $data['investigation'] = $investigationFileName;

                $investigationFile->storeAs('general_examination_investigations', $investigationFileName, 'public');
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
            'height' => 'required',
            'pulse' => 'required',
            'weight' => 'required',
            'random_blood_sugar' => 'required',
            'blood_pressure' => 'required',
            'investigation' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $examination = GeneralExamination::find($id);
        $examination->update($data);

        if ($request->hasFile('investigation')) {
            $newInvestigationFile = $request->file('investigation');
            $newInvestigationFileName = $newInvestigationFile->getClientOriginalName();
            $data['investigation'] = $newInvestigationFileName;
            $examination->update($data);
            $newInvestigationFile->storeAs('general_examination_investigations', $newInvestigationFileName, 'public');
        }

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
