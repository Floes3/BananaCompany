<?php
    require_once '../../../header.php';

    if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
    }
    if (!($_SESSION['user']['userrole'] == 2) && !($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }


    $sql = "SELECT projectName,companyName,projectNR, customer.customerNR FROM projects INNER JOIN customer ON projects.customerNR = customer.customerNR WHERE projects.active = 1;";
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
            <li><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
            <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
         <?php else: ?>
            <li><a href='<?php echo HTTP . 'public/index.php' ?>'>Home</a></li>
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
    <h1>Dashboard Development</h1>
<?php else: ?>
    <h1>Dashboard</h1>
<?php endif ?>
</div>

<div class="table">
    <div class="col-md-6">
       
        <h2>Projects</h2>

        <table class='table table-hover'>
            <thead>
                 <tr>
                    <th>Project name</th>
                    <th>Company</th>
                </tr>
            </thead>

            <?php foreach ($results as $result): ?>
                <tbody>
                    <tr class='clickable-row' data-href='<?php echo HTTP . 'public/views/departments/development/projectPage.php?projectnr=' .  $result['projectNR'] ?>'>
                        
                        <td><?php echo $result['projectName'] ?></td>
                        
                        <td><?php echo $result['companyName'] ?></td> 
                        
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
    <h2>Add Project</h2>
    <div class="col-md-12">
        <form class="lineout" action="<?php echo HTTP . 'app/controllers/projectController.php' ?>" method='POST'>
            <input type="hidden" name="type" value="add">
            
            <div class=" col-md-3 form-group">
                <label for="projectName">Project name</label>
                <input class="form-control" type="text" name='projectName'>
            </div>
            
            <div class=" col-md-3 form-group">
                <label for="projectName">Company</label>
                <select class="form-control" name="customerNR" >
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['customerNR']?>" selected><?php echo $client['companyName'] ?></option>
                    <?php endforeach ?>
                </select>
`           </div>  
            <div class=" col-md-3 form-group">
                <label for="desc">Description</label>
                <input class="form-control" type="text" name='description'>
            </div>
    
            <div class=" col-md-3 form-group ">
                <input class="btn btn-primary pull-right" type="submit" id="submit" value='Add project'>
            </div>
        </form>
    </div>
</div>


</div>
<?php require_once '../../../footer.php'; ?>

