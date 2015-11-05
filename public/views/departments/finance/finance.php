<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

 if (!($_SESSION['user']['userrole'] == 1) && !($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

$sql = "SELECT invoices.description, invoices.invoiceNR, invoices.inDate, customer.companyName  
        FROM invoices 
        INNER JOIN projects ON projects.projectNR = invoices.projectNR 
        INNER JOIN customer ON customer.customerNR = projects.customerNR
        WHERE invoices.active = 1";
$q= $db->query($sql);
$results = $q->fetchAll();

$sql = "SELECT customer.companyName, projects.projectName, projects.projectNR
        FROM projects
        INNER JOIN customer on customer.customerNR = projects.customerNR";
$q= $db->query($sql);
$projects = $q->fetchAll();

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
    <?php if ($_SESSION['user']['userrole'] == 4): ?>
    <h1>Dashboard Finance</h1>
<?php else: ?>
    <h1>Dashboard</h1>
<?php endif ?>
    <div class="table">
        <div class="col-md-6">
        <div class="tableOut">
            <h2>Invoices</h2>
            <table class="table table-hover">
	            <thead>
			      <tr>
			     	<th>Client</th>
			        <th>description</th>
			        <th>date</th>
			      </tr>
			    </thead>

			    <?php foreach ($results as $result): ?>
                
			    <tbody class='clickable-row' data-href='<?php echo HTTP . 'public/views/invoices/invoicePage.php?innr=' .  $result["invoiceNR"] ?>'>
			      <tr>
			      	<td><?php echo $result['companyName'] ?></td>
			        <td><?php echo $result['description'] ?></td>
			        <td><?php echo $result['inDate'] ?></td>
			       
			      </tr>
			      
			    </tbody>
			    <?php endforeach; ?>
			</table>
        </div>
        </div>
        <div class="col-md-6">
            <div class="tableOut">
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
    </div>

    <div class="seperator"></div>
<div class="addInvoice">
    <h2>Add Invoice</h2>
    <div class="col-md-12">
        <form class="lineout" action="<?php echo HTTP . 'app/controllers/invoiceController.php' ?>" method='POST'>
            <input type="hidden" name="type" value="add">
            
                        
            <div class=" col-md-2 form-group">
                <label for="projectNR">Company/project</label>
                <select class="form-control" name="projectNR" >
                                      <?php foreach ($projects as $project): ?>
                        
                            <option value="<?php echo $project['projectNR']?>"><?php echo $project['companyName'] . ' | ' . $project['projectName']; ?></option>
                         
                    <?php endforeach ?>
                </select>
`           </div>

            <div class=" col-md-2 form-group">
                <label for="description">Description</label>
                <input class="form-control" type="text" name='description'>
            </div>
            
            <div class=" col-md-2 form-group">
                <label for="inDate">Date</label>
                <input class="form-control" type="text" name='inDate'>
            </div>

            <div class=" col-md-2 form-group">
                <label for="price">Price</label>
                <input class="form-control" type="text" name='price'>
            </div>

            <div class=" col-md-2 form-group ">
                <input class="btn btn-primary pull-right" type="submit" id="submit" value='Add invoice'>
            </div>
        </form>
    </div>
</div>

</div>

<?php require_once '../../../footer.php'; ?>

