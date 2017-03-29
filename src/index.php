#!/usr/bin/env php
<?php

use Webmozart\Console\ConsoleApplication;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/globals.php';

$dotenv = new Dotenv\Dotenv( __DIR__ . '/../');
$dotenv->load();

if(true)
{
	echo '';
}

$cli = new ConsoleApplication(new \PHPMetric\Application());
$cli->run();