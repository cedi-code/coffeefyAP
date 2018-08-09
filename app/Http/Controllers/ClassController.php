<?php

namespace App\Http\Controllers;

use App\Classmembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Classes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $tableName = 'classes';


    public $rules = array(
        'school' => 'required|int',
        'teacher' => 'required|int',
        'title' => 'required|string'
    );

    public function index()
    {
        return Classes::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // TODO überprüfen ob es um eine Teacher id handelt oder nicht!!!!

        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 400);
        }

        $class = new Classes([
            'school' => $request->school,
            'teacher' => $request->teacher,
            'title' => $request->title
        ]);
        $class->save();
        return response()->json([
            'message' => 'Successfully created class!',
            'id' => $class->id
        ], 201);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $class)
    {
        return $class;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 200);
        }

        $class = Classes::where("id", $id)->update([
            'school' => $request->school,
            'teacher' => $request->teacher,
            'title' => $request->title,
            'updated_at' => DB::raw('NOW()')

        ]);
        return response()->json(["id" => $id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classmembers::find($id);
        $class->delete();
        return response()->json([
            'message' => 'Successfully deleted class!'
        ], 200);

    }
}
