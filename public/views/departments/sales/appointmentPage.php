<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

$appointmentNR = $_GET['appointmentnr'];
$sql = "SELECT * FROM appointments INNER JOIN customer ON appointments.customerNR = customer.customerNR WHERE appointmentNR = $appointmentNR;";

$q= $db->query($sql);
$results = $q->fetchAll();


?>

<header>
    <div class="col-md-12">
        <h1>Barroc IT</h1>
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
            <li class='active'><a href='<?php echo HTTP . 'public/views/depatments/development/development.php' ?>'>Home</a></li>
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
                        <th>Subject</th>
                        <th>Company</th>
                        <th>Description</th>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $result['subject'] ?></td>
                        <td><?php echo $result['company'] ?></td>
                        <td><?php echo $result['appdate'] ?></td>
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
    		<input type="hidden" name="type" value="edit">
    		<input type="hidden" name='appointmentNR' value=<?php echo $result['appointmentNR'] ?>>
    		<div class=" col-md-3 form-group">
    			<label for="appointmentNR">appointmentNR</label>
    			<input class="form-control" type="text" name='appointmentNR' value='<?php echo $result['appointmentNR'] ?>'>
    		</div>
    		<div class=" col-md-3 form-group">
    			<label for="customerNR">customerNR</label>
    			<input class="form-control" type="text" name='customerNR' value='<?php echo $result['customerNR'] ?>'>
    		</div>
            <div class=" col-md-3 form-group">
                <label for="company">company</label>
                <input class="form-control" type="text" name='company' value='<?php echo $result['company'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="firstname">firstname</label>
                <input class="form-control" type="text" name='firstname' value='<?php echo $result['firstname'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="lastname">lastname</label>
                <input class="form-control" type="text" name='lastname' value='<?php echo $result['lastname'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="appdate">appdate</label>
                <input class="form-control" type="text" name='appdate' value='<?php echo $result['appdate'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="time">time</label>
                <input class="form-control" type="text" name='time' value='<?php echo $result['time'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="subject">subject</label>
                <input class="form-control" type="text" name='subject' value='<?php echo $result['subject'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="location">location</label>
                <input class="form-control" type="text" name='location' value='<?php echo $result['location'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="attendingPeople">attendingPeople</label>
                <input class="form-control" type="text" name='attendingPeople' value='<?php echo $result['attendingPeople'] ?>'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="description">description</label>
                <input class="form-control" type="text" name='description' value='<?php echo $result['description'] ?>'>
            </div>

    		<div class=" col-md-3 form-group">
    			<label for="projectName">active</label>
    			<select class="form-control" name="active" >
            		<option value="1" selected>Yes</option>
    				<option value="0">No</option>
    			</select>

    		</div>
    		<div class=" col-md-3 form-group ">
    			<input class="btn btn-primary pull-right" type="submit" id="submit" value='Edit'>
    		</div>
        </form>
    <?php endforeach; ?>
</div>