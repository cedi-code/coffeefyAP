<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eventmembers;
use Illuminate\Support\Facades\Validator;
use App\Events;
use Illuminate\Support\Facades\DB;

class EventMemberController extends Controller
{


    public $tableName = 'eventmembers';
    public $rules = array(
        'user' => 'required|int',
        'event' => 'required|int',
    );
    /**
     * Zeigt alle Events in dem der User in einer Gruppe ist.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data2 = [];
        $eventOwner = Events::select('id')->where("creator", $request->user()->id)->get();
        foreach ($eventOwner as $eventO) {

            $eventM = Eventmembers::select('user')->where("event", $eventO->id)->get();
            if(count($eventM) > 0) {
                $data2[] = [
                    'event' => $eventO->id,
                    'members' => $eventM
                ];
            }

        }

        $events =  Eventmembers::select('event')->where("user", $request->user()->id)->get();
        foreach ($events as $event) {
            $data2[] = [
                'event' => $event->event,
                'members' => Eventmembers::select('user')->where("event", $event->event)->get()
            ];

        }
        return $data2;
    }
    public function getRaw() {
        return Eventmembers::all();
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
        if(Events::find($request->event)->creator == $request->user()->id ||$request->user()->is_admin ) {
            $eventmember = new Eventmembers([
                'user' => $request->user,
                'event' => $request->event

            ]);
            $eventmember->save();
            return response()->json([
                'message' => 'Successfully created event type!',
                'id' => $eventmember->event
            ], 201);
        }



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
        return [
            'event' => $event->id,
            'members' => Eventmembers::select('user')->where("event", $event->id)->get()];
    }
    public function showUser($id)
    {
        $data2 = [];
        $eventOwner = Events::select('id')->where("creator", $id)->get();
        foreach ($eventOwner as $eventO) {

            $eventM = Eventmembers::select('user')->where("event", $eventO->id)->get();
            if(count($eventM) > 0) {
                $data2[] = [
                    'event' => $eventO->id,
                    'members' => $eventM
                ];
            }

        }

        $events =  Eventmembers::select('event')->where("user", $id)->get();
        foreach ($events as $event) {
            $data2[] = [
                'event' => $event->event,
                'members' => Eventmembers::select('user')->where("event", $event->event)->get()
            ];

        }
        return $data2;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function destroyUser(Request $request,$id) {
        $validator = Validator::make($request->all(), [
            'event' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'event id is required!',
                'errors' => $validator->messages()
            ], 400);
        }
        //$event= Eventmembers::where("event", $request->event)->where("user", $id)->get()[0];
        //$event->delete();
        $query = "DELETE FROM `eventmembers` WHERE `event`=$request->event AND `user`=$id";
        DB::delete($query);

        return response()->json([
            'message' => 'succsesful kicked user',
            'id' => $id
        ], 200);

    }
    public function destroyEventMembers($id) {
        $query = "DELETE FROM `eventmembers` WHERE `event`=$id";
        DB::delete($query);
        return response()->json([
            'message' => 'succsesful deleted eventmembers!',
            'id' => $id
        ], 200);
    }
}
