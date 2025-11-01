<?php
session_start();

define('DB_PATH', __DIR__ . '/users.db');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

date_default_timezone_set('UTC');

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
?>
