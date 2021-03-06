<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('id_user', Auth::id() )->get();
        return response($tasks,200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        $task = new Task();
        $task->description = $request->description;
        $task->status = $request->status;
        $task->id_user = Auth::id();
        $task->save();

        return response([
            'message' => 'Successfully created task!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where('id_user', Auth::id() )->where('id',$id)->first();
        
        if (is_null($task)) {
            return response([
                'message' => 'Non-existent record !'
            ], 404);
        }

        return response($task,200);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$task = Task::find($request->get('id'));
        $task = Task::where('id_user', Auth::id() )->where('id',$request->get('id'))->first();

        if (is_null($task)) {
            return response([
                'message' => 'Non-existent record !'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }        
       
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();

        return response([
            'message' => 'Successfully updated task!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id_user', Auth::id() )->where('id',$id)->first();

        if (is_null($task)) {
            return response([
                'message' => 'Non-existent record !'
            ], 404);
        }

        $task->delete();

        return response([
            'message' => 'Successfully deleted task!'
        ], 200);
    }
}
