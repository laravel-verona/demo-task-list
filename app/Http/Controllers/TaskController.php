<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Contracts\TaskContract as TaskRepository;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        parent::__construct();

        $this->middleware('auth');
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

        return view('tasks.index', compact('tasks'));
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
    public function store(Requests\TaskCreateRequest $request)
    {
        $name = $request->get('name');
        $task = $this->taskRepository->create(compact('name'));

        return redirect()->back()->with('success', trans('app.tasks.message.create_success'));
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
    public function update(Requests\TaskUpdateRequest $request, $id)
    {
        $input = [
            'done' => $request->has('done'),
        ];

        if ($request->has('name')) {
            $input['name'] = $request->get('name');
        }

        $task = $this->taskRepository->update($id, $input);

        return redirect()->back()->with('success', trans('app.tasks.message.update_success'));
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

        return redirect()->back()->with('success', trans('app.tasks.message.delete_success'));
    }
}
