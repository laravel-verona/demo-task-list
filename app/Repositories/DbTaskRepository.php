<?php

namespace App\Repositories;

use App\Models\Task;
use App\Contracts\TaskContract;

class DbTaskRepository implements TaskContract
{
    protected $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Istanza della Model.
     *
     * @return \App\Models\Task
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Tutti i Tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Trova un Task.
     *
     * @param  int $id
     * @return \App\Models\Task
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Crea un Task.
     *
     * @param  array  $input
     * @return \App\Models\Task
     */
    public function create(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * Aggiorna un Task.
     *
     * @param  int    $id
     * @param  array  $input
     * @return \App\Models\Task
     */
    public function update($id, array $input)
    {
        $task = $this->find($id);

        $task->fill($input);
        $task->save();

        return $task;
    }

    /**
     * Elimina un Task.
     *
     * @param  int $id
     * @return void
     */
    public function delete($id)
    {
        $task = $this->find($id);
        $task->delete();
    }
}
