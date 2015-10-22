<?php

require_once '../../../header.php';
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
        <li><a href="../../../../app/controllers/authController.php?logout=true" name="type" style='    margin-left: 700px;'>Logout</a></li>
       
        
    </ul>
</div>
<?php
        if($messageBag->hasMsg()){
           echo $messageBag->show();
        }
    ?>
<div class="container">
    
    <div class="col-md-10 dash-title">
        <h1>Dashboard | Development</h1>
    </div>
    
    <div class="table">
        <div class="col-md-6">
            <h2>Appointments</h2>
            <a href=""><p>Add,view,delete or edit appointments</p></a>
        </div>
        <div class="col-md-6">
            <h2>Client information</h2>
            <a href=""><p>Add,view,delete or edit client</p></a>
        </div>
    </div>

</div>

</body>
</html>