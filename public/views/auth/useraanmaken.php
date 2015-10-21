<?php
require_once __DIR__ . '/../../../app/init.php';

$username = 'finance';
$password = 'finance';

//$db->query("TRUNCATE TABLE users");
$hashed = password_hash($password,PASSWORD_DEFAULT);
if(password_verify($password, $hashed)){
    echo 'true';
}
$sql = "INSERT INTO users (name , password, userrole) VALUES ('$username', '$hashed', 1)";
$q = $db->query($sql);
