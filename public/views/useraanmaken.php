<?php
require_once __DIR__ . '/../../../app/init.php';

$username = 'admin';
$password = 'admin';

$db->query("TRUNCATE TABLE users");
$hashed = password_hash($password,PASSWORD_DEFAULT);
if(password_verify($password, $hashed)){
    echo 'true';
}
$sql = "INSERT INTO users (username , password) VALUES ('$username', '$hashed')";
$q = $db->query($sql);
