<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\LessThan;

class LessThanTest extends BaseTestCase
{
    /**
     * @var LessThan
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new LessThan();
    }

    /**
     *
     */
    public function testOneIsLessThanTen()
    {
        $valid = $this->validator->validateLessThan(
            'number',
            1,
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
    public function testTenIsntLessThanOne()
    {
        $valid = $this->validator->validateLessThan(
            'number',
            10,
            [
                1,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(false, $valid);
    }

    /**
     *
     */
    public function testOneIsLessThanIndexedParameter()
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 10
        ]);

        $valid = $this->validator->validateLessThan(
            'number',
            1,
            [
                'something',
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testTenIsntLessThanIndexedParameter()
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 1
        ]);

        $valid = $this->validator->validateLessThan(
            'number',
            10,
            [
                'something',
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

        $this->validator->validateLessThan(
            'size',
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
        $replacement = 10;
        $expected = 'size must be less than ' . $replacement;
        $string = 'size must be less than :less_than';

        $message = $this->validator->replaceLessThan($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }
}
