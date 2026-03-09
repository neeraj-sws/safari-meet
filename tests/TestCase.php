<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
<<<<<<< HEAD
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use \Tests\CreatesApplication;
    use RefreshDatabase;
=======
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplicatio;
    use DatabaseTransactions; // <-- THIS stops migrations and rolls back after each test
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
}
