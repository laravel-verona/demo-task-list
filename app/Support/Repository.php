<?php

namespace Todo\Support;

abstract class Repository {

    /**
     * Query Builder per questo repository
     *
     * @return Builder
     */
    protected function getQuery()
    {
        return call_user_func([
            $this->model,
            'query'
        ]);
    }

    /**
     * Tutti gli items
     *
     * @param  String $with [description]
     * @return   Collection
     */
    public function all($with = null)
    {
         $query = $this->getQuery();

         if ($with) $query->with($with);

         return $query->get();
    }

    /**
     * Trova un item
     *
     * @param  Integer $id
     * @param  String   $with
     * @return   Model
     */
    public function find($id, $with = null)
    {
        $query = $this->getQuery();

        if ($with) $query->with($with);

        return $query->find($id);
    }
}