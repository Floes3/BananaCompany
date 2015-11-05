<?php
    require_once '../../../header.php';

    if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
    }
    if (!($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

$sql = "SELECT invoices.description, invoices.invoiceNR, invoices.inDate, customer.companyName  
        FROM invoices 
        INNER JOIN projects ON projects.projectNR = invoices.projectNR 
        INNER JOIN customer ON customer.customerNR = projects.customerNR
        WHERE invoices.active = 0";
    $q= $db->query($sql);
    $results = $q->fetchAll();

$sql = "SELECT * FROM customer WHERE active = 0;";
    $q= $db->query($sql);
    $clients = $q->fetchAll();

    $sql = "SELECT projectName,companyName,projectNR, customer.customerNR FROM projects INNER JOIN customer ON projects.customerNR = customer.customerNR WHERE projects.active = 0;";
    $q= $db->query($sql);
    $prResults = $q->fetchAll();
    
?>

<header>
    <div class="col-md-12">
        <h1>Barroc IT | Admin</h1>
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
    <h1>Dashboard</h1>
</div>


<div class="table">
        <div class="col-md-6">
        <div class="tableOut">
            <h2>Inactive invoices</h2>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Client</th>
                    <th>description</th>
                    <th>date</th>
                    <th>Reset</th>
                  </tr>
                </thead>

                <?php foreach ($results as $result): ?>
                
                <tbody>
                  <tr>
                    <td><?php echo $result['companyName'] ?></td>
                    <td><?php echo $result['description'] ?></td>
                    <td><?php echo $result['inDate'] ?></td>
                    <td>
                        <form action="<?php echo HTTP . 'app/controllers/clientController.php' ?>" method='POST'>
                            <input type="hidden" name="type" value="reset">
                            <input type="hidden" name='inNR' value=<?php echo $result['invoiceNR'] ?>>
                            <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Reset'>
                        </form>
                    </td>
                   
                  </tr>
                  
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        </div>
        <div class="col-md-6">
            <div class="tableOut">
                <h2>Inactive clients</h2>

                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Contact person</th>
                            <th>Reset</th>
                        </tr>
                    </thead>
                    <?php foreach ($clients as $client): ?>
                    <tbody> 

                        <tr>
                            <td><?php echo $client['companyName'] ?></td>
                            <td><?php echo $client['address'] ?></td> 
                            <td><?php echo $client['contactPerson'] ?></td>
                            <td>
                                <form action="<?php echo HTTP . 'app/controllers/clientController.php' ?>" method='POST'>
                                    <input type="hidden" name="type" value="reset">
                                    <input type="hidden" name='clientNR' value=<?php echo $client['customerNR'] ?>>
                                    <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Reset'>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>
<div class="seperator"></div>
    <div class="col-md-6">
       
        <h2>Inactive projects</h2>

        <table class='table table-hover'>
            <thead>
                 <tr>
                    <th>Project name</th>
                    <th>Company</th>
                    <th>Reset</th>
                </tr>
            </thead>

            <?php foreach ($prResults as $result): ?>
                <tbody>
                    <tr class='clickable-row' data-href='<?php echo HTTP . 'public/views/departments/development/projectPage.php?projectnr=' .  $result['projectNR'] ?>'>
                        
                        <td><?php echo $result['projectName'] ?></td>
                        
                        <td><?php echo $result['companyName'] ?></td> 
                        <td>
                            <form action="<?php echo HTTP . 'app/controllers/projectController.php' ?>" method='POST'>
                                <input type="hidden" name="type" value="reset">
                                <input type="hidden" name='projectNR' value=<?php echo $result['projectNR'] ?>>
                                <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Reset'>
                            </form>
                        </td>
                        
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    
    </div>



</div>

<?php require_once '../../../footer.php'; ?>