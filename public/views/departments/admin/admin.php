<?php
    require_once '../../../header.php';

    if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
    }
    if (!($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

$sql = "SELECT tbl_invoices.description, tbl_invoices.invoiceNR, tbl_invoices.inDate, tbl_customers.companyName  
        FROM tbl_invoices 
        INNER JOIN tbl_projects ON tbl_projects.projectNR = tbl_invoices.projectNR 
        INNER JOIN tbl_customers ON tbl_customers.customerNR = tbl_projects.customerNR
        WHERE tbl_invoices.active = 0";
$q= $db->query($sql);
$results = $q->fetchAll();

$sql = "SELECT * FROM tbl_customers WHERE active = 0;";
$q= $db->query($sql);
$clients = $q->fetchAll();

$sql = "SELECT projectName,companyName,projectNR, tbl_customers.customerNR FROM tbl_projects INNER JOIN tbl_customers ON tbl_projects.customerNR = tbl_customers.customerNR WHERE tbl_projects.active = 0;";
$q= $db->query($sql);
$prResults = $q->fetchAll();

$sql = "SELECT * FROM tbl_users";
$q= $db->query($sql);
$users = $q->fetchAll();

$sql = "SELECT tbl_customers.companyName, tbl_appointments.subject, tbl_appointments.appdate ,tbl_appointments.appointmentNR FROM tbl_appointments INNER JOIN tbl_customers ON tbl_appointments.customerNR = tbl_customers.customerNR WHERE tbl_appointments.active = 0";
$q= $db->query($sql);
$appointments = $q->fetchAll();
    
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
                        <form action="<?php echo HTTP . 'app/controllers/invoiceController.php' ?>" method='POST'>
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
<div class="table">
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
                    <tr>
                        
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


<div class="table">
    <div class="col-md-6">

        <h2>Inactive appointments</h2>

        <table class='table table-hover'>
            <thead>
                 <tr>
                    <th>Company</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Reset</th>
 
                </tr>
            </thead>

            <?php foreach ($appointments as $appointment): ?>
                <tbody>
                    <tr>

                        <td><?php echo $appointment['companyName'] ?></td>

                        <td><?php echo $appointment['subject'] ?></td>

                        <td><?php echo $appointment['appdate'] ?></td>
                        <td>
                            <form action="<?php echo HTTP . 'app/controllers/appointmentController.php' ?>" method='POST'>
                                <input type="hidden" name="type" value="reset">
                                <input type="hidden" name='appointmentNR' value=<?php echo $appointment['appointmentNR'] ?>>
                                <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Reset'>
                            </form>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>

    </div>



    <div class="col-md-12">
    <h2>Users</h2>
        <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Userrole</th>
                <th>Delete</th>
              </tr>
            </thead>

            <?php foreach ($users as $user): ?>
            
            <tbody>
              <tr>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php
                        if ($user['userrole'] == 4) {
                            echo 'Admin';
                         } elseif ($user['userrole'] == 3) {
                            echo 'Sales';
                         } elseif ($user['userrole'] == 2) {
                            echo 'Development';
                         } else {
                            echo 'Finance';
                         }
                        ?>
                    <td>
                        <form action="<?php echo HTTP . 'app/controllers/authController.php' ?>" method='POST'>
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name='userID' value=<?php echo $user['id'] ?>>
                            <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Delete'>
                        </form>
                    </td>
               
                </tr>
              
            </tbody>
            <?php endforeach; ?>
        </table>
    </div>

    

        
    <div class="seperator"></div>
    <div class="addUser">
    <h2>Add User</h2>
    <div class="col-md-12">
        <form class="lineout" action="<?php echo HTTP . 'app/controllers/authController.php' ?>" method='POST'>
            <input type="hidden" name="type" value="register">
            
            <div class=" col-md-3 form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" name='name'>
            </div>

            <div class=" col-md-3 form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name='password'>
            </div>
            
            <div class=" col-md-3 form-group">
                <label for="userrole">Userrole</label>
                <select class="form-control" name="userrole" >
                        <option value="1">Finance</option>
                        <option value="2">Development</option>
                        <option value="3">Sales</option>
                        <option value="4">Admin</option>
                </select>
`           </div>  
            <div class=" col-md-3 form-group ">
                <input class="btn btn-primary pull-right" type="submit" id="submit" value='Add user'>
            </div>
        </form>
    </div>

</div>

<?php require_once '../../../footer.php'; ?>