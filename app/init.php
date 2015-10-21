<?php

session_start();

define('SCHEME', 'http');

define('ROOT', __DIR__ . '/../');
define('PUBLIC_FOLDER', ROOT . 'barrocit.bosch-webdevelopment.nl/');
define('APP_FOLDER', ROOT . 'app/');

define( 'HTTP', SCHEME . '://barrocit.bosch-webdevelopment.nl/');


require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/classes/MessageBag.php';

$messageBag = new MessageBag();

