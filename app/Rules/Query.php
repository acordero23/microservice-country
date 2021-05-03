<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;

/**
 * Class Query
 *
 * @package App\Rules
 */
class Query
{
    /**
     * Validate exist zipCode into country.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function existZipCode($attribute, $value, $parameters, $validator)
    {
        $findCountryWithZipCode = $this->queryCountry($parameters[1], $parameters[2]);
        $findCountryWithCounty = $this->queryCountry('county_id', $parameters[3]);

        if ($findCountryWithZipCode->count() == 1) {
            return $findCountryWithZipCode[0]->country_id != $findCountryWithCounty[0]->country_id;
        } elseif ($findCountryWithZipCode->count() == 0) {
            return true;
        }

        return false;
    }

        /**
     * Get Country of Population.
     *
     * @param $fiel
     * @param $value
     *
     * @return \Illuminate\Support\Collection
     */
    private function queryCountry($fiel, $value)
    {
        return DB::table('population')
            ->join('county', 'population.county_id', '=', 'county.id')
            ->join('state', 'county.state_id', '=', 'state.id')
            ->join('country', 'state.country_id', '=', 'country.id')
            ->where($fiel, '=', $value)->get(['country.id as country_id', 'country.name as country_name']);
    }
}