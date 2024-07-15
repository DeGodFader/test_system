<?php

namespace App\Http\Controllers;

use App\Helpers\DBHelper;
use App\Helpers\SecurityHelpers;
use App\Mail\WelcomeMessage;
use App\Models\Staff;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Log;


class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutions= DBHelper::getAll(new Institution);
        if($institutions[0]==='success'){
            return response()->json([
                'institutions'=> $institutions[1]
            ]);
        }

        return response()->json([
            'error'=> $institutions[1]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rules= [
            'name'=> "required|string",
            'address'=> "required|string",
            'telephone'=> "required|string",
            'email'=> "required|email",
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
        ];

        // Validating
        $validator = Validator::make($request->all(), $rules);

        // Checking Validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Moving Validated data
        $validatedData = $validator->validated();

        $error= "";
        $institution= new Institution();
        $institution->name =  $validatedData['name'];
        $institution->address = $validatedData['address'];
        $institution->email = $validatedData['email'];
        $institution->telephone = $validatedData['telephone'];
        $institutionSave= DBHelper::save($institution);
        if($institutionSave[0]=='success'){
            $admin= new Staff();
            $password= SecurityHelpers::passwordGenerator();
            $admin->name= $validatedData['admin_name'];
            $admin->email= $validatedData['admin_email'];
            $admin->password= SecurityHelpers::passwordHash($password);
            $admin->role= "ADMIN";
            $admin->institution_id= $institution->id;
            $adminSave= DBHelper::save($admin);
            if($adminSave[0]=='success'){
                $adminID= $admin->id;
                $institution->admin_id= $adminID;
                $institutionSave= DBHelper::update($institution);
                if($institutionSave[0]=='success'){

                    // Mail::to($admin->email)->send(new WelcomeMessage($admin));
                    
                    return response()->json([
                        'message' => 'Institution and Admin created successfully',
                        'admin_password'=> $password,
                    ], 200);
                }
                $error= $institutionSave[1];
            }
            $error= $adminSave[1];       
        }
        return response()->json([
            'error'=> $error,
            ], 400);
        

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
    public function show($id)
    {
        //
        if($id){
            Log::info($id);
            $institutions= DBHelper::getByID(new Institution, $id);
            if($institutions[0]==="success"){
                return response()->json([
                    'institution'=> $institutions[1]
                ], 200);
            }
            return response()->json([
                'error'=> $institutions[1]
            ], 400);
        }
        return response()->json([
            'error'=> 'id parameter missen'
        ],404);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        //
    }
}
