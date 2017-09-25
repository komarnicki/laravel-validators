<?php

namespace IntelliHR\Validation\Validators;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class MaxDate extends AbstractValidator
{
    /**
     * @var string
     */
    public static $name = 'max_date';

    /**
     * @var string
     */
    public static $message = ':attribute must be before :max_date';

    public function validateMaxDate(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ): bool {
        $this->requireParameterCount(1, $parameters, self::$name);
        $format = $parameters[1] ?? null;

        $maxDate = $this->getDateForParameter($parameters[0], $format);

        try {
            $date = $this->getDateForParameter($value, $format);
        } catch (Exception $e) {
            return true;
        }

        if ($date === false || $maxDate === false) {
            return true;
        }

        return ($date <= $maxDate);
    }

    public function replaceMaxDate(
        string $message,
        string $attribute,
        string $rule,
        array $parameters
    ): string {
        return str_replace(':max_date', $parameters[0], $message);
    }
}
