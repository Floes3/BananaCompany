<?php
    require_once '../../../header.php';

    if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
    }
    if (!($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }


    
?>

<header>
    <div class="col-md-12">
        <h1>Barroc IT</h1>
    </div>
</header>
<div id='cssmenu'>
    <ul>
        <li class='active'><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
        <li class='active'><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
        <li class='active'><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
        <li class='active'><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
        <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>   
    </ul>
</div>
<?php
    if($messageBag->hasMsg()){
       echo $messageBag->show();
    }
?>
<div class="container">

<div class="col-md-10 dash-title">
    <h1>Dashboard | Admin</h1>
</div>