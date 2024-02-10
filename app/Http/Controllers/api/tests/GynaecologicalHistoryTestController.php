<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\GynaecologicalTest;
use Illuminate\Http\Request;

class GynaecologicalHistoryTestController extends Controller
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
            'patient_id' =>'required|exists:patients,id',
            'date_of_last_period' => 'required|date',
            'menstrual_cycle_abnormalities' => 'required|string',
            'contact_bleeding' => 'required|boolean',
            'menopause' => 'required|boolean',
            'menopause_age' => 'nullable|required_if:menopause,yes|integer',
            'using_of_contraception' => 'required|boolean',
            'contraception_method' => 'nullable|required_if:using_of_contraception,yes|string|in:Pills,IUD,Injectable,Other',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
            ]);
    
        if (!$data['menopause']) {
            $data['menopause_age'] = null;
        }
        if (!$data['using_of_contraception']) {
            $data['contraception_method'] = null;
        }
        
        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = implode(',', $filesNames);
        }
        $historyTest = GynaecologicalTest::create($data);
        
        return response()->json([
            'message' => 'Gynaecological history test has been saved successfully',
            'history_test' => $historyTest,
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
     
        $data = $request->validate([
            'date_of_last_period' => 'required|date',
            'menstrual_cycle_abnormalities' => 'required|string',
            'contact_bleeding' => 'required|boolean',
            'menopause' => 'required|boolean',
            'menopause_age' => 'nullable|required_if:menopause,yes|integer',
            'using_of_contraception' => 'required|boolean',
            'contraception_method' => 'nullable|required_if:using_of_contraception,yes|string|in:Pills,IUD,Injectable,Other',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
        ]);

        if (!$data['menopause']) {
            $data['menopause_age'] = null;
        }
        if (!$data['using_of_contraception']) {
            $data['contraception_method'] = null;
        }
        
        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = implode(',', $filesNames);
        }

        $historyTest = GynaecologicalTest::find($id);
        $historyTest->update($data);

        return response()->json([
            'message' => 'Gynaecological history test has been updated successfully',
            'history_test' => $historyTest,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
