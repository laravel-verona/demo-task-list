<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserContract;

class DbUserRepository implements UserContract
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Istanza della Model.
     *
     * @return \App\Models\User
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Tutti gli Utenti.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    /**
     * Tutti gli Utenti suddivisi per pagina.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 5)
    {
        return $this->model->orderBy('name')->paginate($perPage);
    }

    /**
     * Trova un Utente.
     *
     * @param  int $id
     * @return \App\Models\User
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Crea un Utente.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * Aggiorna un Utente.
     *
     * @param  int    $id
     * @param  array  $input
     * @return \App\Models\User
     */
    public function update($id, array $input)
    {
        $task = $this->find($id);

        $task->fill($input);
        $task->save();

        return $task;
    }

    /**
     * Elimina un Utente.
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
