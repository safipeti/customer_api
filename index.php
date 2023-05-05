<?php

use controller\CustomerController;
use database\PDOConnection;
use repository\PDORepository;

spl_autoload_register(function ($class) {
    include dirname(__FILE__) . '/' . str_replace('\\', '/', $class) . '.php';
});


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


$parts = explode("/", $path);

$resource = $parts[2];

// resource: customers

$id = isset($parts[3]) ? $parts[3] : null;


$repo = new PDORepository(new PDOConnection('localhost', 'root', '', 'customer_api'));
header('Content-Type: application/json; charset=utf-8');

$app = new CustomerController($repo);
$app->processRequest($_SERVER['REQUEST_METHOD'], $id);