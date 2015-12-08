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

    public function add($task)
    {
        $user = Auth::user();
        $task = $this->task_repo->create($user, [
            'task' => $task,
        ]);

        $this->event($task, 'created');
    }

    public function update($id, $task)
    {
        $task = $this->task_repo->update($id, [
            'task' => $task,
        ]);

        $this->event($task);
    }

    public function delete($id)
    {
        $task = $this->task_repo->destroy($id);

        $this->event($task, 'deleted');
    }

    public function done($id)
    {
        $task = $this->task_repo->update($id, [
            'done' => true,
        ]);

        $this->event($task);
    }

    public function undone($id)
    {
        $task = $this->task_repo->update($id, [
            'done' => false,
        ]);

        $this->event($task);
    }

    protected function event($task, $type = 'updated')
    {
        $class = "Todo\Events\Task" . ucfirst($type);
        $event = new $class($task);

        event($event);
    }
}
