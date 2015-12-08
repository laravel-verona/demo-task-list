<?php

namespace Todo\Repositories;

use Todo\Task;
use Todo\User;
use Todo\Support\Repository;

class TaskRepository extends Repository {

    /**
     * Namespace Model
     *
     * @var String
     */
    protected $model = Task::class;

    /**
     * Crea un task
     *
     * @param  User   $user
     * @param  Array  $fields
     * @return   Task
     */
    public function create(User $user, Array $fields)
    {
        $task = new Task;

        $task->fill($fields);

        $user->tasks()->save($task);

        return $task;
    }

    /**
     * Aggiorna un task
     *
     * @param  Integer $id
     * @param  Array   $fields
     * @return   Task
     */
    public function update($id, Array $fields)
    {
        $task = $this->find($id);

        $task->update($fields);

        return $task;
    }

    /**
     * Cancella un task
     *
     * @param  Integer $id
     * @return   Task
     */
    public function destroy($id)
    {
        $task = $this->find($id);

        $task->delete();

        return $task;
    }
}
