<?php

namespace IntelliHR\Validation\Validators;

use Carbon\Carbon;
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

    protected function getDateForParameter(
        string $parameter,
        string $format = null
    ): ?Carbon {
        try {
            $date = ($format !== null)
                ? Carbon::createFromFormat($format, $parameter)
                : new Carbon($parameter);
        } catch (Exception $e) {
            return null;
        }

        if ($date === false) {
            return null;
        }

        return $date;
    }
}
