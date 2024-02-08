<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\GynaecologicalHistoryTest;
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
            'date_of_last_period' => 'required|date',
            'menstrual_cycle_abnormalities' => 'required|string',
            'contact_bleeding' => 'required|boolean',
            'menopause' => 'required|boolean',
            'menopause_age' => 'nullable|required_if:menopause,yes|integer',
            'using_of_contraception' => 'required|boolean',
            'contraception_method' => 'nullable|required_if:using_of_contraception,yes|string|in:Pills,IUD,Injectable,Other',
            'investigation' => 'nullable|file|mimes:pdf,doc,docx', 
            ]);
            if (!$data['menopause']) {
                $data['menopause_age'] = null;
            }
            if (!$data['using_of_contraception']) {
                $data['contraception_method'] = null;
            }
            $investigationFile = $request->file('investigation');
            $investigationFileName = $investigationFile->getClientOriginalName();
    
            $data['investigation'] = $investigationFileName;
        
            $historyTest = GynaecologicalHistoryTest::create($data);
            $investigationFile->storeAs('gynaecologicalhistorytestinvestigations', $investigationFileName, 'public');
    
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
            'investigation' => 'nullable|file|mimes:pdf,doc,docx', 
        ]);

        if (!$data['menopause']) {
            $data['menopause_age'] = null;
        }
        if (!$data['using_of_contraception']) {
            $data['contraception_method'] = null;
        }
        $historyTest = GynaecologicalHistoryTest::find($id);
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
