<?php

namespace Todo\Http\Controllers;

use Tasks, Auth;

use Illuminate\Http\Request;
use Todo\Http\Requests;
use Todo\Http\Controllers\Controller;
use Todo\Repositories\TaskRepository;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskRepository $task_repo)
    {
        $tasks = $task_repo->all('author');

        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreTaskRequest $request)
    {
        $task_text = $request->get('task');
        $task         = Tasks::add($task_text);

        return response($task, 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateTaskRequest $request, $id)
    {
        if ($request->has('done'))
        {
            $done = $request->get('done');
            $task  = Tasks::done($id, $done);
        }

        if ($request->has('task'))
        {
            $task_text = $request->get('task');
            $task         = Tasks::update($id, $task_text);
        }

         return response($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Tasks::delete($id);

        return response($task, 200);
    }
}
