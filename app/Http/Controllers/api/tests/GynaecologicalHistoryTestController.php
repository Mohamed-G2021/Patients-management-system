<?php

namespace App\Http\Controllers\api\tests;

use App\Http\Controllers\Controller;
use App\Models\GynaecologicalTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GynaecologicalHistoryTestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show']);
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
            $filePathes = [];
            
            foreach($request->file('investigation_files')  as $investigationFile){
            $investigationFileName = $investigationFile->getClientOriginalName();
            $storedFile =$investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
            $filePathes[]=Storage::url($storedFile);
            }

            $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
        }
        
        $data['doctor_id'] = auth()->user()->id;

        $historyTest = GynaecologicalTest::create($data);
        
        return response()->json([
            'message' => 'Gynaecological history test has been saved successfully',
            'history_test' => $historyTest,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pateint_id)
    {
        $examination = GynaecologicalTest::where('patient_id',$pateint_id)->latest()->first();

        if($examination){
            return response()->json($examination);  
        }else{
            return response()->json(null, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $test = GynaecologicalTest::find($id);
        if($test){
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
                $filePathes = [];
                
                foreach($request->file('investigation_files')  as $investigationFile){
                $investigationFileName = $investigationFile->getClientOriginalName();
                $storedFile =$investigationFile->storeAs('gynaecological_history_test_investigations', $investigationFileName, 'public');
                $filePathes[]=Storage::url($storedFile);
                }
    
                $data['investigation_files'] = json_encode($filePathes, JSON_UNESCAPED_UNICODE);
            }

            $data['doctor_id'] = auth()->user()->id;

            $newExamination = GynaecologicalTest::create($data);

            return response()->json([
                'message' => 'Gynaecological history test has been updated successfully',
                'examination' => $newExamination],
                200);
                
        }else{
            return response()->json(['error' => 'No examination found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
