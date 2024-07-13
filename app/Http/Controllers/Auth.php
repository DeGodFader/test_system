<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class Auth extends Controller
{
    function login(Request $request)
    {
        // Rules to check
        $rules = [
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
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
        $username = $validatedData['username'];
        $password = $validatedData['password'];

        // Responding 
        return response()->json([
            'message' => "Welcome, $username! Your password is $password.",
        ]);
    }

    function register(Request $request)
    {
        // Rules to check
        $rules = [
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
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
        $username = $validatedData['username'];
        $password = $validatedData['password'];
    }

    function checkToken(string $role)
    {
        return true;
    }

    function checkRole(string $role)
    {
        // TODO: Implement checkRole() method.
    }

    function logout(Request $request)
    {
        // TODO: Implement logout() method.
    }
}
