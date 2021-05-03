<?php

namespace App\Repositories;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StateRepository
 *
 * @package App\Repositories
 */
class StateRepository extends BaseRepository
{
    public function __construct(State $State)
    {
        parent::__construct($State);
    }

    public function store(Model $State)
    {
        Country::findOrFail($State->country_id);

        $State->creation_date = date('Y-m-d H:i:s');
        $State->nacceso = 'publico';

        $State->save();

        return $State;
    }

    public function update(Model $State)
    {
        Country::findOrFail($State->country_id);

        $State->modification_date = date('Y-m-d H:i:s');

        $State->save();

        return $State;
    }
}