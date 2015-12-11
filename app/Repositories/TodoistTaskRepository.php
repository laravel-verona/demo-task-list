<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Task;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use App\Contracts\TaskContract;
use Illuminate\Support\Collection;

class TodoistTaskRepository implements TaskContract
{
    protected $token;
    protected $client;
    protected $projectId;

    public function __construct()
    {
        $this->client = $this->getClient();

        $this->token = env('TODOIST_TOKEN');
        $this->projectId = env('TODOIST_PROJECT');
    }

    /**
     * Tutti i Tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $tasks = [];
        $response = $this->client->get('sync');

        if ($response->getStatusCode() != 200) {
            throw new \Exception('Error Processing Request');
        }

        return $this->getTaskResource($response);
    }

    /**
     * Trova un Task.
     *
     * @param  int $id
     * @return \App\Models\Task
     */
    public function find($id)
    {
        return $this->all()[$id];
    }

    /**
     * Crea un Task.
     *
     * @param  array  $input
     * @return \App\Models\Task
     */
    public function create(array $input)
    {
        $params = $this->setClientParamsByAction('item_add', [
            'content' => array_get($input, 'name'),
        ]);

        $response = $this->client->post('sync', [
            'form_params' => $params,
        ]);

        return $this->all()->first();
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
        $done = array_get($input, 'done');

        if (array_has($input, 'name')) {
            $params = $this->setClientParamsByAction('item_update', [
                'id'      => $id,
                'content' => array_get($input, 'name'),
            ]);

            $response = $this->client->post('sync', [
                'form_params' => $params,
            ]);
        }

        if (! is_null($done) and $done != $task->done) {
            if ($done == true) {
                $params = $this->setClientParamsByAction('item_complete', [
                    'ids' => [(int) $id],
                ]);
            } else {
                $params = $this->setClientParamsByAction('item_uncomplete', [
                    'ids' => [(int) $id],
                ]);
            }

            $response = $this->client->post('sync', [
                'form_params' => $params,
            ]);
        }

        return $this->all()->first();
    }

    /**
     * Elimina un Task.
     *
     * @param  int $id
     * @return void
     */
    public function delete($id)
    {
        $params = $this->setClientParamsByAction('item_delete', [
            'ids' => [(int) $id],
        ]);

        $response = $this->client->post('sync', [
            'form_params' => $params,
        ]);
    }

    /**
     * Istanza del Client HTTP.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        $client = new Client([
            'base_uri' => 'https://todoist.com/API/v6/',
            'query'    => [
                'token'          => $this->token,
                'project_id'     => $this->projectId,
                'seq_no'         => 0,
                'seq_no_global'  => 0,
                'resource_types' => json_encode(['all']),
            ],
        ]);

        return $client;
    }

    /**
     * Prepara i parametri del CLient HTTP per eseguire le
     * richieste alle API.
     *
     * @param string $action
     * @param array  $fields
     */
    protected function setClientParamsByAction($action, array $fields)
    {
        $args = array_merge($fields, [
            'project_id' => $this->projectId,
        ]);

        $commands = [
            'type' => $action,
            'uuid' => Uuid::uuid4()->toString(),
            'args' => $args,
        ];

        if ($action === 'item_add') {
            $commands['temp_id'] = Uuid::uuid4()->toString();
        }

        return [
            'commands' => json_encode([$commands]),
        ];
    }

    /**
     * Ritorna una risorsa Task in base alla risposta
     * ottenuta dalla richiesta alle API.
     *
     * @param  \GuzzleHttp\Psr7\Response $response
     * @return Illuminate\Support\Collection
     */
    protected function getTaskResource(Response $response)
    {
        $data = json_decode($response->getBody());
        $user = $this->getUserResource($response);

        $result = [];

        foreach ($data->Items as $item) {
            $task = new Task;
            $task->id = $item->id;
            $task->name = $item->content;
            $task->done = $item->is_archived;
            $task->created_at = Carbon::parse($item->date_added);
            $task->updated_at = Carbon::parse($item->date_added);
            $task->author = $user;

            $result[$item->id] = $task;
        }

        return new Collection($result);
    }

    /**
     * Ritorna una risorsa User in base alla risposta
     * ottenuta dalla richiesta alle API.
     *
     * @param  \GuzzleHttp\Psr7\Response $response
     * @return Illuminate\Support\Collection
     */
    protected function getUserResource(Response $response)
    {
        $data = json_decode($response->getBody());
        $user = new User;

        $user->id = $data->UserId;
        $user->name = $data->User->full_name;
        $user->email = $data->User->email;
        $user->created_at = Carbon::parse($data->User->join_date);
        $user->updated_at = Carbon::parse($data->User->join_date);

        return $user;
    }
}
