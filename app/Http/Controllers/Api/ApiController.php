<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Logged user.
     *
     * @var App\Models\User
     */
    protected $logged;

    public function __construct()
    {
        $this->logged = app('auth')->user();
    }

    /**
     * Applica Fractal per una singola risorsa
     *
     * @param  object $data
     * @param  object $transformer
     * @return array
     */
    public function apiItem($data, $transformer)
    {
        $manager = new Manager;
        $resource = new Item($data, $transformer);

        return $manager->createData($resource)->toArray();
    }

    /**
     * Applica Fractal per un elenco di risorse
     *
     * @param  object $data
     * @param  object $transformer
     * @return array
     */
    public function apiCollection($data, $transformer)
    {
        $manager = new Manager;
        $resource = new Collection($data, $transformer);

        if ($data instanceof LengthAwarePaginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        }

        return $manager->createData($resource)->toArray();
    }
}
