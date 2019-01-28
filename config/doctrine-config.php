<?php

// Paths to Entities that we want Doctrine to see
$paths = array(
    "module/Application/src/Entity",
);

// Tells Doctrine what mode we want
$isDevMode = true;

// Doctrine connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'user'     => 'mailserver',
    'password' => 'cf3UkEDUyTgNyM32',
    'dbname'   => 'mailserver',
);
