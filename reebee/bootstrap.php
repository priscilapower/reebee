<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$loader = new \Composer\Autoload\ClassLoader();

$map = require __DIR__ . '/autoload.php';
foreach ($map as $namespace => $path) {
    $loader->setPsr4($namespace, $path);
}
$loader->register(true);

use Database\Database;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

$db = (new Database())->getConnection();
