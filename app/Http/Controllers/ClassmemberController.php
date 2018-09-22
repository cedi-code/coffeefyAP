<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Classmembers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ClassmemberController extends Controller
{


    public $tableName = 'classmembers';

    public $rules = array(
        'class' => 'required|int',
        'pupil' => 'required|int'
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data2 = [];
        $classes =  Classmembers::select('class')->where("pupil", $request->user()->id)->with('classTo')->get();
        foreach ($classes as $class) {
            $data2[] = [
                'class' => [
                    'school' => $class->classTo->school,
                    'teacher' => $class->classTo->teacher,
                    'title' => $class->classTo->title
                ],
                'members' => Classmembers::select('pupil')->where("class", $class->class)->get()
            ];

        }
        return $data2;
    }

    public function getRaw() {
        return Classmembers::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 400);
        }

        $classmember = new Classmembers([
            'class' => $request->class,
            'pupil' => $request->pupil,
        ]);
        $classmember->save();
        return response()->json([
            'message' => 'Successfully created classmember!',
            'id' => $classmember->class
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClass($id)
    {
        $data2[] = [
            'class' => Classes::find($id),
            'members' => Classmembers::select('pupil')->where("class", $id)->with('user')->get()
        ];
        return $data2;
    }
    public function showPupil($id)
    {
        return  Classmembers::select('class')->where("pupil", $id)->with('classTo')->get();
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
    public function updateClass(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 400);
        }

        $classmember = Classes::where("class", $id);
           foreach($classmember as $pupils) {
               $pupils->update([
                   'class' => $request->class,
                   'pupil' => $request->pupil,
               ]);
           }
        return response()->json(["id" => $id], 200);
    }

    public function updatePupil(Request $request, $id) {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 400);
        }

        $classmember = Classes::where("pupil", $id)->get();
            foreach($classmember as $class) {
                    $class->update([
                  'class' => $request->class,
                  'pupil' => $request->pupil,
                    ]);
            };



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
        /*$classmember = Classmembers::where();
        $classmember->delete();*/
        return response()->json([
            'message' => 'work in progress!'
        ], 200);
    }
}
