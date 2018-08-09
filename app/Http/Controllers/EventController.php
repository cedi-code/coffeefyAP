<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events;
use App\Eventmembers;

class EventController extends Controller
{

    public $tableName = 'events';


    public $rules = array(
        'type' => 'int',
        'lesson' => 'required|int',
        'title' => 'required|string',
        'description' => 'string'
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data2 = [];
        $eventOwner = Events::select('id','type', 'lesson', 'title')->where("creator", $request->user()->id)->get();
        foreach ($eventOwner as $eventO) {
            $data2[] = [
                'event' => $eventO,
            ];
        }

        $eventsIsMember =  Eventmembers::select('event')->where("user", $request->user()->id)->get();
        foreach ($eventsIsMember as $event) {
            $data2[] = [
                'event' => Events::select('id','type', 'lesson', 'title')->where("id", $event->event)->get()[0]
            ];

        }
        return $data2;

    }
    public function getRaw() {
        return Events::all();
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

        $event = new Events([
            'type' => $request->type,
            'lesson' => $request->lesson,
            'creator' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);
        $event->save();
        return response()->json([
            'message' => 'Successfully created event!',
            'id' => $event->id
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
    public function show(Events $event)
    {
        return $event;

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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'some error has accured!',
                'errors' => $validator->messages()
            ], 200);
        }

        $event = Events::where("id", $id)->update([
            'type' => $request->type,
            'lesson' => $request->lesson,
            'title' => $request->title,
            'description' => $request->description
        ]);
        return response()->json(["id" => $id, "event" => $event], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event= Events::find($id);
        $event->delete();
        return response()->json([
            'message' => 'Successfully deleted event!'
        ], 200);
    }
}
