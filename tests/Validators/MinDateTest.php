<?php

namespace IntelliHR\Tests\Validation\Validators;

use DateInterval;
use DateTime;
use IntelliHR\Tests\Validation\BaseTestCase;
use IntelliHR\Validation\Validators\MinDate;

class MinDateTest extends BaseTestCase
{
    /**
     * @var MinDate
     */
    protected $validator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = new MinDate();
    }

    /**
     *
     */
    public function testNowIsAfterLastWeek()
    {
        $now = (new DateTime())->format('Y-m-d');
        $past = (new DateTime)->sub(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMinDate(
            'date',
            $now,
            [
                $past,
            ],
            $this->laravelValidator
        );

        $this->assertEquals(true, $valid);
    }

    /**
     *
     */
    public function testNowIsntAfterNextWeek()
    {
        $now = (new DateTime())->format('Y-m-d');
        $future = (new DateTime)->add(new DateInterval('P1W'))->format('Y-m-d');

        $valid = $this->validator->validateMinDate(
            'date',
            $now,
            [
                $future,
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

        $this->validator->validateMinDate(
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
        $replacement = '2000-01-01';
        $expected = 'date must be after ' . $replacement;
        $string = 'date must be after :min_date';

        $message = $this->validator->replaceMinDate($string, '', '', [$replacement]);

        $this->assertEquals($expected, $message);
    }
}
