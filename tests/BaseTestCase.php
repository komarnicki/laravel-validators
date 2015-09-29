<?php

namespace IntelliHR\Tests\Validation;

use Illuminate\Validation\Validator;
use Mockery;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;

abstract class BaseTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $laravelValidator;

    /**
     *
     */
    public function setUp()
    {
        $this->laravelValidator = Mockery::mock(Validator::class)
            ->makePartial()->shouldAllowMockingProtectedMethods();

        parent::setUp();
    }
    /**
     *
     */
    protected function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }
}
