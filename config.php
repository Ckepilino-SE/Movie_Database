<?php
// Minimal shared DB config
$DB_HOST = '127.0.0.1';
$DB_NAME = 'movie_db';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

$DB_DSN = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
$DB_OPTIONS = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];
