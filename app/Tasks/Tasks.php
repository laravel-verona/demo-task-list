<?php

namespace App\Tasks;

use Auth;
use App\Repositories\TaskRepository;

class Tasks {

    /**
     * Task Repository
     *
     * @var App\Repositories\TaskRepository
     */
    protected $task_repo;

    public function __construct(TaskRepository $task_repo)
    {
        $this->task_repo = $task_repo;
    }

    public static function __callStatic($name, $arguments)
    {
        $me = app('App\Tasks\Tasks');

        return call_user_func_array([$me, $name], $arguments);
    }

    /**
     * Crea un nuovo task
     *
     * @param String $task_text
     * @return  \App\Task
     */
    public function add($task_text)
    {
        $user = Auth::user();
        $task = $this->task_repo->create($user, [
            'task' => $task_text,
        ]);

        $this->event($task, 'created');

        return $this->formatResponse($task);
    }

    /**
     * Aggiorna un task esistente
     *
     * @param  Integer $id
     * @param  String   $task_text
     * @return   \App\Task
     */
    public function update($id, $task_text)
    {
        $task = $this->task_repo->update($id, [
            'task' => $task_text,
        ]);

        $this->event($task);

        return $this->formatResponse($task);
    }

    /**
     * Cancella un task
     *
     * @param  Integer $id
     * @return   \App\Task
     */
    public function delete($id)
    {
        $task = $this->task_repo->destroy($id);

        $this->event($task, 'deleted');

        return $this->formatResponse($task);
    }

    /**
     * Setta un task completato o no
     *
     * @param  Integer    $id
     * @param  Boolean  $flag
     * @return   \App\Task
     */
    public function done($id, $flag)
    {
        $task = $this->task_repo->update($id, [
            'done' => $flag,
        ]);

        $this->event($task);

        return $this->formatResponse($task);
    }

    /**
     * Crea evento laravel
     * @param  \App\Task $task
     * @param  String          $type
     */
    protected function event(\App\Task $task, $type = 'updated')
    {
        $class = "App\Events\Task" . ucfirst($type);
        $event = new $class($task);

        event($event);
    }

    /**
     * Formatta l'oggetto task per la risposta
     *
     * @param  \App\Task $task
     * @return   \App\Task
     */
    protected function formatResponse(\App\Task $task)
    {
        $task->load('author');
        $task->author->setGravatar();

        return $task;
    }
}
