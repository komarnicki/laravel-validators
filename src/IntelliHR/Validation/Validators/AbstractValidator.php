<?php

namespace IntelliHR\Validation\Validators;

use DateTime;
use Exception;
use InvalidArgumentException;

abstract class AbstractValidator
{
    /**
     * Require a certain number of parameters to be present.
     *
     * @param  int    $count
     * @param  array  $parameters
     * @param  string $rule
     *
     * @throws InvalidArgumentException
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new InvalidArgumentException("Validation rule $rule requires at least $count parameters.");
        }
    }

    /**
     * @return DateTime|bool
     *
     * @throws Exception
     */
    protected function getDateForParameter(
        string $parameter,
        string $format = null
    ) {
        if ($format !== null) {
            return DateTime::createFromFormat($format, $parameter);
        }

        return new DateTime($parameter);
    }
}
