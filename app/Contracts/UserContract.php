<?php

namespace App\Contracts;

interface UserContract
{
    /**
     * Tutti gli Utenti.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Tutti gli Utenti suddivisi per pagina.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 5);

    /**
     * Trova un Utente.
     *
     * @param  int $id
     * @return \App\Models\User
     */
    public function find($id);

    /**
     * Crea un Utente.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input);

    /**
     * Aggiorna un Utente.
     *
     * @param  int    $id
     * @param  array  $input
     * @return \App\Models\User
     */
    public function update($id, array $input);

    /**
     * Elimina un Utente.
     *
     * @param  int $id
     * @return void
     */
    public function delete($id);
}
