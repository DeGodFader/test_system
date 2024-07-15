<?php

namespace App\Http\Controllers;

use App\Helpers\DBHelper;
use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class ThesisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thesis= DBHelper::getAll(new Thesis);
        if($thesis[0]==='success'){
            return response()->json([
                'thesis'=> $thesis[1]
            ]);
        }

        return response()->json([
            'error'=> $thesis[1]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $rule=[
            'description'=> "required| string",
            'title'=> "required|string",
            'author'=> "required"
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()){
            return response()->json([
                'message'=> $validator->errors(),
            ],400);
        }

        $validatedData= $validator->validated();
        $thesis= new Thesis();
        $thesis->title= $validatedData['title'];
        $thesis->description= $validatedData['description'];
        $thesis->author= $validatedData['author'];
        Log::info($thesis);
        $thesisSave= DBHelper::save($thesis);
        if($thesisSave[0]==='success'){
            return response()->json([
                'message'=> 'Thesis: '. $thesis->title .' Created Successfully'
            ],200);
        }

        return response()->json([
            'error'=> $thesisSave[1],
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
    public function show($id, $author= null)
    {
        //
        if($id){
            try {
                $thesis= Thesis::find($id)->first();
                return response()->json([
                    'thesis'=>$thesis
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
    public function edit(Request $request, $id)
    {
        //
        if($id){
            $rule=[
                'title'=> 'required|string',
                'description'=> 'required|string'
            ];

            $validator=Validator::make($request->all(), $rule);
            if($validator->fails()){
                return response()->json([
                    'error'=> $validator->errors(),
                ],400);
            }
            $validatorData= $validator->validated();
            $thesis = Thesis::find($id);
            $thesis->title= $validatorData['title'];
            $thesis->description= $validatorData['description'];
            $thesisSave= DBHelper::update($thesis);
            if($thesisSave[0]==='success'){
                return response()->json([
                    'message'=> 'Thesis: '. $thesis->title .' Updated Successfully'
                ],200);
            }

            return response()->json([
                'error'=> $thesisSave[1],
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thesis $thesis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        if($id){
            $thesis= DBHelper::getByID(new Thesis,$id);
            if($thesis[0]==='success'){
                $thesisDelete= DBHelper::delete($thesis[1]);
                if($thesisDelete[0]=== 'success'){
                    return response()->json([
                        'message'=> "Thesis with id: $id Deleted"
                    ],200);
                }

                return response()->json([
                    "error"=> $thesisDelete[1],
                ],400);
            }
            return response()->json([
                "error"=> $thesis[1],
            ],400);
        }
    }
}
