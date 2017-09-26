<?php

namespace IntelliHR\Tests\Validation\Validators;

use DateInterval;
use DateTime;
use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MaxDate;

class MaxDateTest extends BaseTestCase
{
    /**
     * @var MaxDate
     */
    protected $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new MaxDate();
    }

    public function testNowIsBeforeNextWeek()
    {
        $now = (new DateTime())->format('Y-m-d');
        $future = (new DateTime)->add(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMaxDate(
            'date',
            $now,
            [
                $future,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    public function testNowIsntBeforeLastWeek()
    {
        $now = (new DateTime())->format('Y-m-d');
        $past = (new DateTime)->sub(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMaxDate(
            'date',
            $now,
            [
                $past,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(false, $valid);
    }

    public function testThatInsufficientParametersThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMaxDate(
            'date',
            1,
            [],
            $this->laravelValidator
        );
    }

    public function testThatErrorMessageIsReplaced()
    {
        $replacement = '2100-01-01';
        $expected = 'date must be before ' . $replacement;
        $string = 'date must be before :max_date';

        $message = $this->validator->replaceMaxDate($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }

    public function testThatInvalidParameterDateFails()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validateMaxDate(
            'date',
            '2007-07-07',
            [
                'invalid',
            ],
            $this->laravelValidator
        );
    }

    public function testThatInvalidValueDatePasses()
    {
        $valid = $this->validator->validateMaxDate(
            'date',
            'invalid',
            [
                '2007-07-07',
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    public function testThatParametersCanBeSpecifiedWithFormat()
    {
        $valid = $this->validator->validateMaxDate(
            'date',
            '2007-07-07',
            [
                '09/09/2009',
                'd/m/Y',
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }
}
