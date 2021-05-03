<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository
{

    protected $model;

    public function __construct(Model $Model)
    {
        $this->model = $Model;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->model->get();
    }

    /**
     * @param Model $Model
     *
     * @return Model
     */
    public function store(Model $Model)
    {
        $Model->creation_date = date('Y-m-d H:i:s');
        $Model->nacceso = 'publico';

        $Model->save();

        return $Model;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param Model $Model
     *
     * @return Model
     */
    public function update(Model $Model)
    {
        $Model->modification_date = date('Y-m-d H:i:s');

        $Model->save();

        return $Model;
    }
}