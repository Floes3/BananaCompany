<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}
 ?>

<header>
    <div class="col-md-12">
        <h1>barroc IT</h1>
    </div>
</header>
<div id='cssmenu'>
    <ul>
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='#'>Products</a></li>
        <li><a href='#'>Company</a></li>
        <li><a href='#'>Contact</a></li>
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
        <h1>Dashboard</h1>
    </div>
    <div class="table">
    
        <div class="col-md-6">
        <div class="tableOut">
            <h2>Appointments</h2>
            <a href=""><p>Add,view,delete or edit appointments</p></a>
        </div>
        <div class="col-md-6">
            <h2>Client information</h2>
            <a href=""><p>Add,view,delete or edit client</p></a>
        </div>
    </div>
</div>
</div>

</body>
</html>

