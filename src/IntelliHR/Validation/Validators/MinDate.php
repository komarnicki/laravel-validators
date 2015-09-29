<?php

namespace IntelliHR\Validation\Validators;

use DateTime;
use Illuminate\Contracts\Validation\Validator;
use InvalidArgumentException;

class MinDate extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'min_date';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute must be after :min_date';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateMinDate(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minDate = new DateTime($parameters[0]);
        $date = new DateTime($value);

        return ($date >= $minDate);
    }

    /**
     * Replace all place-holders for the between rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    public function replaceMinDate(
        $message,
        $attribute,
        $rule,
        array $parameters
    ) {
        return str_replace(':min_date', $parameters[0], $message);
    }
}
