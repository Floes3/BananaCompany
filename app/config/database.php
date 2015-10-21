<?php

$dsn = 'mysql:host=localhost;dbname=barrocit';
$username = 'root';
$password = '';

try {
	$db = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
	echo $e->getMessage();
}
