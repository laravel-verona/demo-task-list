<?php

namespace Todo\Support;

abstract class Repository
{
    protected function getQuery()
    {
        return call_user_func([
            $this->model,
            'query'
        ]);
    }

    public function all($with = null)
    {
         $query = $this->getQuery();

         if ($with) $query->with($with);

         return $query->get();
    }

    public function find($id, $with = null)
    {
        $query = $this->getQuery();

        if ($with) $query->with($with);

        return $query->find($id);
    }
}