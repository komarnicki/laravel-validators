<?php

namespace IntelliHR\Tests\Validation\Validators;

use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MinChecked;

class MinCheckedTest extends BaseTestCase
{
    /**
     * @var MinChecked
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new MinChecked();
    }

    /**
     * @dataProvider checkboxData
     *
     * @param       $totalChecked
     * @param array $data
     */
    public function testThatAtMinAreChecked($totalChecked, array $data)
    {
        $valid = $this->validator->validateMinChecked(
            'checkbox',
            $data,
            [
                $totalChecked
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    /**
     * @dataProvider checkboxData
     *
     * @param       $totalChecked
     * @param array $data
     */
    public function testThatAtMinArentChecked($totalChecked, array $data)
    {
        $valid = $this->validator->validateMinChecked(
            'checkbox',
            $data,
            [
                $totalChecked + 1
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

        $this->validator->validateMinChecked(
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
        $expected = 'checkbox requires a minimum of ' .  $replacement . ' checked options';
        $string = 'checkbox requires a minimum of :min checked options';

        $message = $this->validator->replaceMinChecked($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }

    /**
     *
     */
    public function checkboxData()
    {
        return [
            'one of three checked' => [
                1,
                [
                    1,
                    0,
                    0,
                ],
            ],
            'two of five checked' => [
                2,
                [
                    0,
                    0,
                    1,
                    1,
                    0,
                ],
            ],
            'all four checked' => [
                4,
                [
                    1,
                    1,
                    1,
                    1,
                ],
            ],
        ];
    }
}
