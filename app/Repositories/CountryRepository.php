<?php

namespace App\Repositories;

use App\Models\Country;

/**
 * Class CountryRepository
 *
 * @package App\Repositories
 */
class CountryRepository extends BaseRepository
{
    public function __construct(Country $Country)
    {
        parent::__construct($Country);
    }
}