<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

 if (!($_SESSION['user']['userrole'] == 3) && !($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

$sql = "SELECT appointmentNR, company, firstname, lastname, appdate, time, subject, location, attendingPeople, description, customer.customerNR FROM appointments INNER JOIN customer ON appointments.customerNR = customer.customerNR";
$q= $db->query($sql);
$results = $q->fetchAll();

$sql = "SELECT * FROM customer WHERE active = 1;";
$q= $db->query($sql);
$clients = $q->fetchAll();

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
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Home</a></li>
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

<div class="col-md-10 dash-title">
    <?php if ($_SESSION['user']['userrole'] == 4): ?>
    <h1>Dashboard Sales</h1>
<?php else: ?>
    <h1>Dashboard</h1>
<?php endif ?>
</div>

<div class="table">
    <div class="col-md-6">

        <h2>Appointments</h2>

        <table class='table table-hover'>
            <thead>
                 <tr>
                    <th>Company</th>
                    <th>Subject</th>
                    <th>appdate</th>
                </tr>
            </thead>

            <?php foreach ($results as $result): ?>
                <tbody>
                    <tr class='clickable-row' data-href='<?php echo HTTP . 'public/views/departments/sales/appointmentPage.php?appointmentnr=' .  $result['appointmentNR'] ?>'>

                        <td><?php echo $result['company'] ?></td>

                        <td><?php echo $result['subject'] ?></td>

                        <td><?php echo $result['appdate'] ?></td>

                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>

    </div>
    <div class="col-md-6">

        <h2>Client info</h2>

        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Contact person</th>
                </tr>
            </thead>
            <?php foreach ($clients as $client): ?>
                <tbody>
                    <tr class='clickable-row' data-href='<?php echo HTTP . 'public/views/clients/clientPage.php?clientnr=' .  $client['customerNR'] ?>'>
                        <td><?php echo $client['companyName'] ?></td>
                        <td><?php echo $client['address'] ?></td>
                        <td><?php echo $client['contactPerson'] ?></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>

        </table>

    </div>

</div>
<div class="seperator"></div>
<div class="addProject">
    <h2>Add Appointment</h2>
    <div class="col-md-12">
        <form class="lineout" action="<?php echo HTTP . 'app/controllers/appointmentController.php' ?>" method='POST'>
            <input type="hidden" name="type" value="add">
            <div class=" col-md-3 form-group">
                <label for="Company">Company</label>
                <select class="form-control" name="customerNR">
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['customerNR']?>" selected><?php echo $client['companyName'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class=" col-md-3 form-group">
                <label for="appointmentNR">appointmentNR</label>
                <input class="form-control" type="text" name='appointmentNR'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="customerNR">customerNR</label>
                <input class="form-control" type="text" name='customerNR'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="firstname">firstname</label>
                <input class="form-control" type="text" name='firstname'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="lastname">lastname</label>
                <input class="form-control" type="text" name='lastname'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="appdate">appdate</label>
                <input class="form-control" type="text" name='appdate'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="time">time</label>
                <input class="form-control" type="text" name='time'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="subject">subject</label>
                <input class="form-control" type="text" name='subject'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="location">location</label>
                <input class="form-control" type="text" name='location'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="attendingPeople">attendingPeople</label>
                <input class="form-control" type="text" name='attendingPeople'>
            </div>
            <div class=" col-md-3 form-group">
                <label for="description">description</label>
                <input class="form-control" type="text" name='description'>
            </div>
            <div class=" col-md-3 form-group ">
                <input class="btn btn-primary pull-right" type="submit" id="submit" value="Add appointment">
            </div>
        </form>
    </div>
</div>

<div class="seperator"></div>
<div class="addClient">
    <h2>Add Client</h2>
    <div class="col-md-12">

        <form class="lineout" action="<?php echo HTTP . 'app/controllers/clientController.php' ?>" method='POST'>
            <input type="hidden" name="type" value="add">

            <div class="row">
                <div class=" col-md-3 form-group">
                    <label for="clientName">Client name</label>
                    <input class="form-control" type="text" name='clientName' >
                </div>
                <div class=" col-md-3 form-group">
                    <label for="address">Address</label>
                    <input class="form-control" type="text" name='address'>
                </div>
                <div class=" col-md-3 form-group">
                    <label for="zipcode">Zipcode</label>
                    <input class="form-control" type="text" name='zipcode' >
                </div>
                <div class=" col-md-3 form-group">
                    <label for="place">Place</label>
                    <input class="form-control" type="text" name='place' >
                </div>
                 <div class=" col-md-3 form-group">
                    <label for="tel">Tel Number</label>
                    <input class="form-control" type="text" name='tel' >
                </div>
                 <div class=" col-md-3 form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name='email' >
                </div>
                 <div class=" col-md-3 form-group">
                    <label for="contP">Contact person</label>
                    <input class="form-control" type="text" name='contP'>
                </div>
                <div class=" col-md-3 form-group ">
                    <input class="btn btn-primary pull-right" type="submit" id="submit" value='Add Client'>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once '../../../footer.php'; ?>

