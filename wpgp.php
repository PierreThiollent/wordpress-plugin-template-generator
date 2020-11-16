#!/usr/bin/php
<?php

use Minicli\App;

require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() !== 'cli') {
    exit;
}

$app = new App([
    'app_path' => __DIR__ . '/app/Command'
]);

$app->setSignature('./wpgp.php help');

$app->runCommand($argv);
