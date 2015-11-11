<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

$appointmentNR = $_GET['appNR'];
$sql = "SELECT tbl_customers.companyName, tbl_customers.contactPerson , tbl_appointments.* FROM tbl_appointments INNER JOIN tbl_customers ON tbl_appointments.customerNR = tbl_customers.customerNR WHERE tbl_appointments.appointmentNR = $appointmentNR ";
$q= $db->query($sql);
$results = $q->fetchAll();


?>

<header>
    <div class="col-md-12">
        <?php if ($_SESSION['user']['userrole'] == 4): ?>
        <h1>Barroc IT | Admin</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 1): ?>
        <h1>Barroc IT | Finance</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 2): ?>
        <h1>Barroc IT | Development</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 3): ?>
        <h1>Barroc IT | Sales</h1>
    <?php endif ?>
    </div>
</header>
<div id='cssmenu'>
    <ul>
        <?php if ($_SESSION['user']['userrole'] == 4): ?>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
            <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
         <?php else: ?>
             <li ><a href='<?php echo HTTP . 'public/index.php' ?>'>Home</a></li>
            <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
        <?php endif ?>
    </ul>
</div>
<?php
    if($messageBag->hasMsg()){
        echo $messageBag->show();
    }
?>

<div class="container">
    <?php foreach ($results as $result): ?>
        <div class="col-md-10 dash-title">
            <h1>appointment: <?php echo $result['subject'] ?></h1>
        </div>

    	<div class="col-md-12">

            <table class='table table-hover'>
                <thead>
                     <tr>
                        <th>Client</th>
                        <th>Subject</th>
                        <th>Attending Person</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Location</th>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $result['companyName'] ?></td>
                        <td><?php echo $result['subject'] ?></td>
                        <td><?php echo $result['contactPerson'] ?></td>
                        <td><?php echo $result['appdate'] ?></td>
                        <td><?php echo $result['description'] ?></td>
                        <td><?php echo $result['location'] ?></td>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <td>
                                <form action="<?php echo HTTP . 'app/controllers/appointmentController.php' ?>" method='POST'>
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name='appointmentNR' value=<?php echo $result['appointmentNR'] ?>>
                                    <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Delete'>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                </tbody>


            </table>
        </div>

        <div class="seperator"></div>

    	<form class="lineout" action="<?php echo HTTP . 'app/controllers/appointmentController.php' ?>" method='POST'>
            <input type="hidden" name="appointmentNR" value="<?php echo $result['appointmentNR'] ?>">
            <input type="hidden" name="type" value="edit">
            <div class=" col-md-3 form-group">
                <label for="subject">Subject</label>
                <input class="form-control" type="text" name='subject' value='<?php echo $result['subject'] ?>'>
            </div>             
            <div class=" col-md-3 form-group">
                <label for="appdate">Date</label>
                <input class="form-control" type="text" name='appdate' value='<?php echo $result['appdate'] ?>'>
            </div>     
            <div class=" col-md-3 form-group">
                <label for="description">Description</label>
                <input class="form-control" type="text" name='description' value='<?php echo $result['description'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="location">Location</label>
                <input class="form-control" type="text" name='location' value='<?php echo $result['location'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="active">Active</label>
                <select class="form-control" name="active" >
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class=" col-md-3 form-group ">
                <input class="btn btn-primary pull-right" type="submit" id="submit" value="Edit appointment">
            </div>

        </form>
    <?php endforeach; ?>
</div>