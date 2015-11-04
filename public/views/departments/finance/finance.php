<?php

require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

 if (!($_SESSION['user']['userrole'] == 1) && !($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

$sql = "SELECT invoices.description, inDate, companyName 
		FROM invoices 
		INNER JOIN projects ON projects.projectNR = invoices.projectNR 
		INNER JOIN customer ON customer.customerNR = projects.customerNR
		WHERE invoices.active = 1";
$q= $db->query($sql);
$results = $q->fetchAll();

$sql = "SELECT * FROM customer;";
$q= $db->query($sql);
$clients = $q->fetchAll();

 ?>

<header>
    <div class="col-md-12">
        <h1>barroc IT</h1>
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
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='#'>Products</a></li>
        <li><a href='#'>Company</a></li>
        <li><a href='#'>Contact</a></li>
        <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
    <?php  endif; ?>
    </ul>
</div>
<?php
        if($messageBag->hasMsg()){
           echo $messageBag->show();
        }
    ?>
<div class="container">
    <div class="col-md-10 dash-title">
        <h1>Dashboard | Finance</h1>
    </div>
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
			    <tbody class='clickable-row' data-href='<?php echo HTTP . 'public/views/departments/development/invoicePage.php?innr=' .  $result["invoiceNR"] ?>'>
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

                        <tr class='clickable-row' data-href='<?php echo HTTP . 'public/views/departments/development/clientPage.php?clientnr=' .  $client['customerNR'] ?>'>
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

</div>

</body>
</html>

