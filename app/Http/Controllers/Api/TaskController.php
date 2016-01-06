<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Contracts\TaskContract as TaskRepository;

class TaskController extends ApiController
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        parent::__construct();

        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->taskRepository->all();

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\TaskCreateRequest $request)
    {
        $name = $request->get('name');
        $task = $this->taskRepository->create(compact('name'));

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);

        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\TaskUpdateRequest $request, $id)
    {
        $input = [
            'done' => $request->has('done'),
        ];

        if ($request->has('name')) {
            $input['name'] = $request->get('name');
        }

        $task = $this->taskRepository->update($id, $input);

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->taskRepository->delete($id);

        return response([
            'id'      => $id,
            'deleted' => true,
        ]);
    }
}
