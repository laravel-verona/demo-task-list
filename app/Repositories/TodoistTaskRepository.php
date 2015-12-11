<?php

namespace App\Repositories;

use App\Models\Task;
use GuzzleHttp\ClientInterface;
use App\Contracts\TaskContract;
use Illuminate\Support\Collection;

class TodoistTaskRepository implements TaskContract
{
    /**
     * Guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Tutti i Tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {

        $response = $this->client->get('getUncompletedItems');
        $items = json_decode($response->getBody());
        $tasks = [];

        foreach ($items as $item) {
            $tasks[] = new Task([
                'id'   => $item->id,
                'name' => $item->content,
                'done' => $item->is_archived,
            ]);
        }

        // dd($tasks);

        return new Collection($tasks);
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
