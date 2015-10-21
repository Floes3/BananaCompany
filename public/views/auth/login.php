<?php require_once '../../header.php';?>
<div class="login-bg"> 
    <div class="loginscreen">
            <h1>Barroc IT.</h1>
            <h1>Software for real.</h1>
        </div>
    <form class="col-md-4 col-md-push-4" action= "../../../app/controllers/authController.php" method="POST">
        
        <input type="hidden" name="type" value="login">

        <div class="form-group">
            <label for="Username">Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <input type="submit" class="btn btn-primary" style='margin-bottom:5px' value="Login">

        <?php
            if($messageBag->hasMsg()){
               echo $messageBag->show();
            }
        ?>
    </form>
</div>
<?php require_once '../../footer.php';?>