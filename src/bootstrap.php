<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = \Dotenv\Dotenv::createUnsafeMutable(__DIR__."/../");
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
}
