<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins=Admin::all();
        return $admins;
    }
      
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([ 
            "username"=> "required",
            "password"=> "required",
        ]);
        $admin=Admin::create($data);
        return response()->json(['message'=>'Admin has been saved successfully','admin'=>$admin],200);
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
            "username"=> "required",
            "password"=> "required",
        ]);
        $admin=Admin::find($id);
        $admin->update($data);  
        return response()->json(["message"=> "Admin has been updated successfully","admin"=>$admin],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     
    }
}
