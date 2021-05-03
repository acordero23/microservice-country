<?php

namespace App\Validations;

/**
 * Class Validations
 *
 * @package App\Validations
 */
class Validations
{
    /**
     * Remove validate required specifiqued into rule.
     *
     * @param $fields
     * @param $rules
     *
     * @return array
     */
    public static function removeRequiredValidationWhenFieldDoesNotExistInRequest($fields, $rules)
    {
        return collect($rules)->transform(function ($items, $key) use ($fields) {
            if (!in_array($key, $fields)) {
                unset($items[0]);
            }

            return $items;
        })->all();
    }
}