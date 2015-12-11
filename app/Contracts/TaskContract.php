<?php

namespace App\Contracts;

interface TaskContract
{
    /**
     * Tutti i Tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Trova un Task.
     *
     * @param  int $id
     * @return \App\Models\Task
     */
    public function find($id);

    /**
     * Crea un Task.
     *
     * @param  array  $input
     * @return \App\Models\Task
     */
    public function create(array $input);

    /**
     * Aggiorna un Task.
     *
     * @param  int    $id
     * @param  array  $input
     * @return \App\Models\Task
     */
    public function update($id, array $input);

    /**
     * Elimina un Task.
     *
     * @param  int $id
     * @return void
     */
    public function delete($id);
}
