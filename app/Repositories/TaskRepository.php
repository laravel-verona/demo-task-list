<?php

namespace Todo\Repositories;

use Todo\Task;
use Todo\User;

class TaskRepository {

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

    /**
     * Tutti i tasks registrati
     *
     * @param  Mixed $with
     * @return   Collection
     */
    public function all($with = null)
    {
         $query = Task::query();

         if ($with) $query->with($with);

         return $query->get();
    }

    /**
     * Trova un task per id
     *
     * @param  Integer $id
     * @param  String   $with
     * @return   Task
     */
    public function find($id, $with = null)
    {
        $query = Task::where('id', $id);

        if ($with) $query->with($with);

        return $query->firstOrFail();
    }
}
