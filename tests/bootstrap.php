<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.DIRECTORY_SEPARATOR."..");
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
}
