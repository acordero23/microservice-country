<?php

namespace App\Repositories;

use App\Models\County;
use App\Models\Population;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PopulationRepository
 *
 * @package App\Repositories
 */
class PopulationRepository extends BaseRepository
{
    public function __construct(Population $Population)
    {
        parent::__construct($Population);
    }

    public function store(Model $Population)
    {
        County::findOrFail($Population->county_id);

        $Population->creation_date = date('Y-m-d H:i:s');
        $Population->nacceso = 'publico';

        $Population->save();

        return $Population;
    }

    public function update(Model $Population)
    {
        County::findOrFail($Population->county_id);

        $Population->modification_date = date('Y-m-d H:i:s');

        $Population->save();

        return $Population;
    }

    public function find($zipCode)
    {
        $informations = [];

        $Populations = $this->model->where(['zip_code' => $zipCode, 'nacceso'  => 'publico'])->get();

        if ($Populations->count() == 0) return $Populations;

        foreach ($Populations as $Population) {
            $data = [];

            $data['population'] = $Population->only(['id', 'name', 'zip_code']);

            $County = $Population->county;
            $data['county'] = $County->only(['id', 'name']);

            $State = $County->state;
            $data['state'] = $State->only(['id', 'name', 'abbreviation']);

            $Country = $State->country;
            $data['country'] = $Country->only(['id', 'name', 'abbreviation']);

            array_push($informations, $data);
        }

        return collect($informations);
    }
}