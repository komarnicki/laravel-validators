<?php

namespace IntelliHR\Validation\Validators;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class MinDate extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'min_date';

    /**
     * @var string
     */
    public static $message = ':attribute must be after :min_date';

    public function validateMinDate(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);
        $format = $parameters[1] ?? null;

        $minDate = $this->getDateForParameter($parameters[0], $format);

        try {
            $date = $this->getDateForParameter($value, $format);
        } catch (Exception $e) {
            return true;
        }

        if ($date === false || $minDate === false) {
            return true;
        }

        return ($date >= $minDate);
    }

    public function replaceMinDate(
        string $message,
        string $attribute,
        string $rule,
        array $parameters
    ): string {
        return str_replace(':min_date', $parameters[0], $message);
    }
}
