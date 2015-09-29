<?php

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;
use InvalidArgumentException;

class MinChecked extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'min_checked';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute requires a minimum of :min checked options';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateMinChecked(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minChecked = $parameters[0];
        $valid = 0;

        foreach ($value as $checkbox) {
            if (boolval($checkbox)) {
                $valid++;
            }
        }

        return ($valid >= $minChecked);
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
    public function replaceMinChecked(
        $message,
        $attribute,
        $rule,
        array $parameters
    ) {
        return str_replace(':min', $parameters[0], $message);
    }
}
