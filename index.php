<?php

require_once 'app/init.php';

if ( ! isset($_SESSION['user']) ) {
    header('location: public/views/auth/login.php');
    exit;
}

$role = $_SESSION['user']['userrole'];

switch($role) {
    case 1:
        header('location: public/views/departments/finance/finance.php');
        break;
    case 2:
        header('location: public/views/departments/development/development.php');
        break;
    case 3:
        header('location: public/views/departments/sales/sales.php');
        break;
    case 4:
        
        header('location: public/views/departments/admin/admin.php');
        break;
  
}
?>