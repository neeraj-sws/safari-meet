<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplicatio;
    use DatabaseTransactions; // <-- THIS stops migrations and rolls back after each test
}
