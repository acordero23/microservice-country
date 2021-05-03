<?php

namespace App\Repositories;

use App\Models\State;
use App\Models\County;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountyRepository
 *
 * @package App\Repositories
 */
class CountyRepository extends BaseRepository
{
    public function __construct(County $County)
    {
        parent::__construct($County);
    }

    public function store(Model $County)
    {
        State::findOrFail($County->state_id);

        $County->creation_date = date('Y-m-d H:i:s');
        $County->nacceso = 'publico';

        $County->save();

        return $County;
    }

    public function update(Model $County)
    {
        State::findOrFail($County->state_id);

        $County->modification_date = date('Y-m-d H:i:s');

        $County->save();

        return $County;
    }
}