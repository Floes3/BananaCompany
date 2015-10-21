<?php require_once '../../header.php';?>

    <form class="col-md-4 col-md-push-4" action= "../../../app/controllers/authController.php" method="POST">
        <h1>Log-in</h1>

        <input type="hidden" name="type" value="register">

        <div class="form-group">
            <label for="Username">Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <?php
        if($messageBag->hasMsg()){
            echo $messageBag->show();
        }
        ?>

        <input type="submit" class="btn btn-primary" value="Registreer">
    </form>

<?php require_once '../../footer.php';?>