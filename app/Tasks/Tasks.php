<?php

namespace Todo\Tasks;

use Auth;
use Todo\Repositories\TaskRepository;

class Tasks {

    /**
     * Task Repository
     *
     * @var Todo\Repositories\TaskRepository
     */
    protected $task_repo;

    public function __construct(TaskRepository $task_repo)
    {
        $this->task_repo = $task_repo;
    }

    public static function __callStatic($name, $arguments)
    {
        $me = app('Todo\Tasks\Tasks');

        return call_user_func_array([$me, $name], $arguments);
    }

    /**
     * Crea un nuovo task
     *
     * @param String $task_text
     * @return  \Todo\Task
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
     * @return   \Todo\Task
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
     * @return   \Todo\Task
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
     * @return   \Todo\Task
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
     * @param  \Todo\Task $task
     * @param  String          $type
     */
    protected function event(\Todo\Task $task, $type = 'updated')
    {
        $class = "Todo\Events\Task" . ucfirst($type);
        $event = new $class($task);

        event($event);
    }

    /**
     * Formatta l'oggetto task per la risposta
     *
     * @param  \Todo\Task $task
     * @return   \Todo\Task
     */
    protected function formatResponse(\Todo\Task $task)
    {
        $task->load('author');
        $task->author->setGravatar();

        return $task;
    }
}
