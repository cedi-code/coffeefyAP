<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lessons;
use App\Classmembers;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{


    public $tableName = 'lessons';


    public $rules = array(
        'course' => 'required|int',
        'class' => 'required|int',
        'teacher' => 'required|int',
        'start_lesson' => 'required|int',
        'duration' => 'required|int',
        'room' => 'string',
        'start' => 'required|timestamp',
        'end' => 'required|timestamp',
        'week' => 'required|int'
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->user()->is_teacher) {
            return Lessons::where('teacher',$request->user()->id)->get();
        }else  {
            $data2 = [];
            $classes =  Classmembers::select('class')->where("pupil", $request->user()->id)->get();
            foreach($classes as $class) {
                array_push($data2, $class->class);
            }

            return Lessons::whereIn('class',$data2)->get();
        }

    }

    public function getRaw() {
        return Lessons::all();
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

        $lesson = new Lessons([
            'course' => $request->course,
            'class' => $request->class,
            'teacher' => $request->teacher,
            'start_lesson' => $request->start_lesson,
            'duration' => $request->duration,
            'room' => $request->room,
            'start' => $request->start,
            'end' => $request->end,
            'week' => $request->week
        ]);
        $lesson->save();
        return response()->json([
            'message' => 'Successfully created lesson!',
            'id' => $lesson->id
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 200);
        }

        $lesson = Lessons::where("id", $id)->update([
            'course' => $request->course,
            'class' => $request->class,
            'teacher' => $request->teacher,
            'start_lesson' => $request->start_lesson,
            'duration' => $request->duration,
            'room' => $request->room,
            'start' => $request->start,
            'end' => $request->end,
            'week' => $request->week

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
        $lesson = Lessons::find($id);
        $lesson->delete();
        return response()->json([
            'message' => 'Successfully deleted lesson!'
        ], 200);
    }
}
