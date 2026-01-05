<?php

use Illuminate\Support\Facades\Artisan;


putenv('APP_ENV=testing');
$_ENV['APP_ENV'] = 'testing';
$_SERVER['APP_ENV'] = 'testing';

require __DIR__.'/TestCase.php';
