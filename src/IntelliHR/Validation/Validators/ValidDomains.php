<?php

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;

class ValidDomains extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'valid_domains';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute does not contain a list of valid domains';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateDividesInto(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $domains = explode(',', $value);

        foreach ($domains as $domain) {
            $valid = '';

            if (!$valid) {
                return false;
            }
        }

        return true;
    }
}
