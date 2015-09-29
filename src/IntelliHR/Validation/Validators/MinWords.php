<?php

namespace IntelliHR\Validation\Validators;

use Illuminate\Contracts\Validation\Validator;
use InvalidArgumentException;

class MinWords extends AbstractValidator
{
    /**
     * Name of the validator
     *
     * @var string
     */
    public static $name = 'min_words';

    /**
     * Fallback message
     *
     * @var string
     */
    public static $message = ':attribute must have at least :min_words words';

    /**
     * @param           $attribute
     * @param           $value
     * @param array     $parameters
     * @param Validator $validator
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validateMinWords(
        $attribute,
        $value,
        array $parameters,
        Validator $validator
    ) {
        $this->requireParameterCount(1, $parameters, self::$name);

        $minWords = $parameters[0];
        $wordCount = str_word_count($value);

        return ($wordCount >= $minWords);
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
    public function replaceMinWords(
        $message,
        $attribute,
        $rule,
        array $parameters
    ) {
        return str_replace(':min_words', $parameters[0], $message);
    }
}
