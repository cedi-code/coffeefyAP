<?php

namespace App\Http\Controllers;

use App\Event_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{

    public $tableName = 'event_types';


    public $rules = array(
        'type' => 'required|string'
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event_types::all();
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

        $eventType = new Event_types([
            'type' => $request->type
        ]);
        $eventType->save();
        return response()->json([
            'message' => 'Successfully created event type!',
            'id' => $eventType->id
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
    public function show(Event_types $event_type)
    {
        return $event_type;
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

        $eventType = Event_types::where("id", $id)->update([
            'type' => $request->type
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
        $eventType = Event_types::find($id);
        $eventType->delete();
        return response()->json([
            'message' => 'Successfully deleted event type!'
        ], 200);
    }
}
