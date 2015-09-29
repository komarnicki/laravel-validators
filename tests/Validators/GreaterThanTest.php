<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\GreaterThan;
use Mockery;

class GreaterThanTest extends BaseTestCase
{
    /**
     * @var GreaterThan
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new GreaterThan();
    }

    /**
     *
     */
    public function testTenIsGreaterThanOne()
    {
        $valid = $this->validator->validateGreaterThan(
            'number',
            10,
            [
                1,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testOneIsntGreaterThanTen()
    {
        $valid = $this->validator->validateGreaterThan(
            'number',
            1,
            [
                10,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(false, $valid);
    }

    /**
     *
     */
    public function testTenIsGreaterThanIndexedParameter()
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 1
        ]);

        $valid = $this->validator->validateGreaterThan(
            'number',
            10,
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
    public function testOneIsntGreaterThanIndexedParameter()
    {
        $this->laravelValidator->shouldReceive('getData')->twice()->andReturn([
            'something' => 10
        ]);

        $valid = $this->validator->validateGreaterThan(
            'number',
            1,
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

        $this->validator->validateGreaterThan(
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
        $replacement = 1;
        $expected = 'size must be greater than ' . $replacement;
        $string = 'size must be greater than :greater_than';

        $message = $this->validator->replaceGreaterThan($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }
}
