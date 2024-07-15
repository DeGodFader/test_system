<?php

// app/Helpers/MyHelper.php
namespace App\Helpers;
use Carbon\Carbon;
use Log;

class SecurityHelpers
{
    public static function passwordGenerator(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        
        return ($randomString);
    }

    public static function passwordHash($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify($password, $hash){
        return password_verify($password, $hash);
    }

    public static function generateAccessToken($user, $role){
        $access_token= bcrypt($user->id);
        $time= Carbon::now();
        $expires_at= $time->addMinutes(30);
        $token=['token'=>$access_token, $expires_at];
        $authorization= "$role $access_token";
        $_SESSION['tokens'][]=$token;
        return $authorization;
    }

    public static function DeleteAccessToken($token){
        Log::info($token);
        foreach($_SESSION['tokens'] as $key=>$tok){
            Log::info($tok);
            if($tok['token'] == $token){
                unset($_SESSION['tokens'][$key]);
                return true;
            }
        }
    }
}
