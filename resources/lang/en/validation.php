<?php

return [
    'in'       => 'The selected :attribute is invalid.',
    'integer'  => 'The :attribute must be an integer.',
    'numeric'  => 'The :attribute must be a number.',
    'max'      => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string'  => 'The :attribute may not be greater than :max characters.',
    ],
    'required' => 'The :attribute field is required.',
    'custom'   => [
        'country_id' => [
            'greaterthanzero' => 'The field must be greater than 0.',
            'verifylenght'    => 'The :attribute may not be greater than :lenght.',
            'exists'          => 'The selected :attribute is invalid.',
        ],
        'state_id'   => [
            'greaterthanzero' => 'The field must be greater than 0.',
            'verifylenght'    => 'The :attribute may not be greater than :lenght.',
            'exists'          => 'The selected :attribute is invalid.',
        ],
        'county_id'  => [
            'greaterthanzero'       => 'The field must be greater than 0.',
            'verifylenght'          => 'The :attribute may not be greater than :lenght.',
            'exists'                => 'The selected :attribute is invalid.',
            'existfieldintorequest' => 'Zip code and county are neccesary for validate information'
        ],
        'zip_code'   => [
            'greaterthanzero'       => 'The field must be greater than 0.',
            'verifylenght'          => 'The :attribute may not be greater than :lenght.',
            'existzipcode'          => 'Zip Code is already registered',
            'existfieldintorequest' => 'Zip code and county are neccesary for validate information'
        ],
    ],
];