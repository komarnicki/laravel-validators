<?php

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class GreaterThan extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'greater_than';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute must be greater than :greater_than';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateGreaterThan(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $greaterThan = $parameters[0];

        if (is_numeric($greaterThan)) {
            return ($value > $greaterThan);
        }

        if (is_string($greaterThan) && array_key_exists($greaterThan, $validator->getData())) {
            $otherField = $validator->getData()[$greaterThan];

            return ($value > $otherField);
        }

        return false;
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
    public function replaceGreaterThan(
        $message,
        $attribute,
        $rule,
        array $parameters
    ) {
        return str_replace(':greater_than', $parameters[0], $message);
    }
}
