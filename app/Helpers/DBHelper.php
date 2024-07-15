<?php

// app/Helpers/MyHelper.php
namespace App\Helpers;
use Log;

class DBHelper
{
    public static function save($object)
    {
        try {
            $object->save();
            return ['success', true];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public static function delete($object)
    {
        try {
            $object->delete();
            return ['success', true];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public static function update($object)
    {
        try {
            $object->update();
            return ['success', true];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public static function getAll($object){
        try {
            $response= $object::get();
            Log::info($response);
            return ['success',$response];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }
    
    public static function getByID($object, $id){
        try {
            return ['success',$object::find($id)->first()];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }
}
