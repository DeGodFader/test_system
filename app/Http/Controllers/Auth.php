<?php

namespace App\Http\Controllers;

use App\Helpers\DBHelper;
use App\Helpers\SecurityHelpers;
use App\Models\Staff;
use App\Models\Super_Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class Auth extends Controller
{
    
    function login(Request $request)
    {
        // Rules to check
        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role'=> 'required|string|max:255',
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
        $name = $validatedData['name'];
        $password = $validatedData['password'];
        $role= $validatedData['role'];

        try {
            switch ($role) {
                case 'user':
                    $user= User::where('name', $request->name)
                                ->orWhere('email', $request->name)
                                ->first();
                    $role= $user->role;
                    break;
                case 'admin':
                    $user= Super_Admin::where('name', $request->name)
                                ->orWhere('email', $request->name)
                                ->first();
                    $role= "SUPER_ADMIN";
                    break;
                case 'staff':
                    $user= Staff::where('name', $request->name)
                                ->orWhere('email', $request->name)
                                ->first();
                    $role= $user->role;
                    break;
                default:
                    # code...
                    break;
            } 
            if($user){
                if(password_verify($password, $user->password)){
                    $authorization= SecurityHelpers::generateAccessToken($user, $role);
                    return response()->json([
                        'message' => "Welcome, $name!",
                        'token' => $authorization,
                        'institution_id'=> $user->institution_id
                    ], 200);
                }else{
                    return response()->json([
                        'message'=>"Incorect Password"
                    ], 200);
                }
            }
            return response()->json([
                'message'=>"User Not Found"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=> $th->getMessage()
            ],400);
        }
        
    }

    function register(Request $request)
    {
        // Rules to check
        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email' => 'required|email|max:255',
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
        $name = $validatedData['name'];
        $password = $validatedData['password'];
        $email = $validatedData['email'];

        $user= new User();
        $user->name = $name;
        $user->password = $password;
        $user->email = $email;
        $userSave= DBHelper::save($user);
        if($userSave[0]==='success'){
            $authorization= SecurityHelpers::generateAccessToken($user, "USER");
            return response()->json([
                'message' => "Welcome, $name! ",
                'token'=> $authorization
            ]);
        }
        return response()->json(['error'=>$userSave[1]], 400);

    }

    function logout(Request $request)
    {
        if($request->header('authorization')){
            $token= explode(' ', $request->header('authorization'));
            if(SecurityHelpers::DeleteAccessToken($token[1])){
                return response()->json([
                    'message'=>'Logged Out',
                ],200);
            }
            return response()->json(['error'=> 'Error1'],400);
        }
        return response()->json(['error'=> 'Error2'],400);
    }
}
