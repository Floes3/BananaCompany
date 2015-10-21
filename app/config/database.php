<?php

$dsn = 'mysql:host=10.184.18.238;dbname=db206494_barrocit';
$username = 'u206494_Floesje';
$password = '1234';

try {
	$db = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
	echo $e->getMessage();
}
