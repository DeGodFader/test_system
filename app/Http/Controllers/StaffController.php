<?php

namespace App\Http\Controllers;

use App\Helpers\DBHelper;
use App\Helpers\SecurityHelpers;
use App\Mail\WelcomeMessage;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        if($id){
            try {
                $staffs= Staff::where("institution_id", $id)->get();
                return response()->json([
                    'staffs'=>$staffs
                ],200);
            } catch (\Throwable $th) {
                return response()->json([
                    'error'=> $th->getMessage()
                ],400);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rule=[
            'name'=> "required|string",
            'email'=> "required|email",
            'institution_id'=> "required",
            'role'=> "required|string",
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()){
            return response()->json([
                'message'=> $validator->errors(),
            ],400);
        }

        $validatedData= $validator->validated();
        $password= SecurityHelpers::passwordGenerator() ;
        $staff= new Staff();
        $staff->name=$validatedData['name'];
        $staff->email=$validatedData['email'];
        $staff->role=$validatedData['role'];
        $staff->institution_id=$validatedData['institution_id'];
        $staff->password= SecurityHelpers::passwordHash($password);
        $staffSave= DBHelper::save($staff);
        if($staffSave[0]==='success'){

            // Mail::to($staff->email)->send(new WelcomeMessage($staff));
            
            return response()->json([
                'message'=> "User created\n Name: ". $staff->name ."\n Password: $password"
            ],200);
        }
        return response()->json([
            'error'=> $staffSave[1]
        ],400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($institution_id, $id)
    {
        //
        if($institution_id && $id){
            try {
                $staff= Staff::where('institution_id', $institution_id)
                                ->where('id', $id)
                                ->first();
                return response()->json([
                    'staff'=> $staff
                ],200);
            } catch (\Throwable $th) {
                return response()->json([
                    'error'=> $th->getMessage()
                ],400);
            }
        }

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
