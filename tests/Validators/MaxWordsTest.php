<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MaxWords;

class MaxWordsTest extends BaseTestCase
{
    /**
     * @var MaxWords
     */
    protected $validator;

    /**
     * @var string
     */
    private $sentence;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new MaxWords();
        $this->sentence = 'Lorem ipsum dolor sit amet, consectetur';
    }

    /**
     *
     */
    public function testThatSixWordsAreLessThenTen()
    {
        $valid = $this->validator->validateMaxWords(
            'sentence',
            $this->sentence,
            [
                10,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testThatSixWordsAreMoreThenFive()
    {
        $valid = $this->validator->validateMaxWords(
            'sentence',
            $this->sentence,
            [
                5,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(false, $valid);
    }

    /**
     *
     */
    public function testThatInsufficientParametersThrowException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $this->validator->validateMaxWords(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    /**
     *
     */
    public function testThatErrorMessageIsReplaced()
    {
        $replacement = '10';
        $expected = 'sentence must have no more than ' .  $replacement . ' words';
        $string = 'sentence must have no more than :max_words words';

        $message = $this->validator->replaceMaxWords($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }
}
