<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\GynaecologicalTest;
use App\Models\HistoryTests\GynaecologicalHistoryTest;
use Illuminate\Http\Request;

class GynaecologicalHistoryTestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum');
    }
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
            'date_of_last_period' => 'date|nullable',
            'menstrual_cycle_abnormalities' => 'string|nullable',
            'contact_bleeding' => 'boolean|nullable',
            'menopause' => 'boolean|nullable',
            'menopause_age' => 'nullable|required_if_accepted:menopause|integer',
            'using_of_contraception' => 'boolean|nullable',
            'contraception_method' => 'nullable|required_if_accepted:using_of_contraception|string|in:Pills,IUD,Injectable,Other',
            'other_contraception_method' => 'nullable|string|required_if:contraception_method,Other',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
            ]);
    
        if (!$request->menopause) {
            $data['menopause_age'] = null;
        }
        if (!$request->using_of_contraception) {
            $data['contraception_method'] = null;
        } 
        if (!$request->using_of_contraception || $request->contraception_method != 'Other') {
            $data['other_contraception_method'] = null;
        }
        
        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames, JSON_UNESCAPED_UNICODE);
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
        $examination = GynaecologicalTest::find($id);

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
        $data = $request->validate([
            'patient_id' =>'required|exists:patients,id',
            'date_of_last_period' => 'date|nullable',
            'menstrual_cycle_abnormalities' => 'string|nullable',
            'contact_bleeding' => 'boolean|nullable',
            'menopause' => 'boolean|nullable',
            'menopause_age' => 'nullable|required_if_accepted:menopause|integer',
            'using_of_contraception' => 'boolean|nullable',
            'contraception_method' => 'nullable|required_if_accepted:using_of_contraception|string|in:Pills,IUD,Injectable,Other',
            'other_contraception_method' => 'nullable|string|required_if:contraception_method,Other',
            'investigation_files' => 'nullable',
            'investigation_files.*'=>'nullable|file',
            ]);
        
         if (!$request->menopause) {
            $data['menopause_age'] = null;
        }
        if (!$request->using_of_contraception) {
            $data['contraception_method'] = null;
        } 
        if (!$request->using_of_contraception || $request->contraception_method != 'Other') {
            $data['other_contraception_method'] = null;
        }
        
        if($request->hasfile('investigation_files')){
            $filesNames = [];
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $filesNames[]=$investigationFileName;

            $investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
            }
            
            $data['investigation_files'] = json_encode($filesNames, JSON_UNESCAPED_UNICODE);
        }

        $oldExamination = GynaecologicalTest::find($id);
        $data['test_id'] = $oldExamination->id;
        $data['doctor_id'] = 1;

        $newExamination = GynaecologicalHistoryTest::create($data);

        return response()->json([
            'message' => 'Gynaecological history test has been updated successfully',
            'examination' => $newExamination],
            200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
