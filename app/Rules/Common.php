<?php

namespace App\Rules;

/**
 * Class Common
 *
 * @package App\Rules
 */
class Common
{
    /**
     * Verify field is greater than zero
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function greaterThanZero($attribute, $value, $parameters, $validator)
    {
        return $value > 0;
    }

    /**
     * Verify length of field.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function verifyLenght($attribute, $value, $parameters, $validator)
    {
        return strlen((string)$value) <= $parameters[0];
    }

    /**
     * Verify exist field into request.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function existFieldIntoRequest($attribute, $value, $parameters, $validator)
    {
        foreach ($parameters as $parameter) {
            if (!$parameter) return false;
        }

        return true;
    }
}